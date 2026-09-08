---
title: Making the GBA Link Cable Work over the Internet
layout: post
tags:
    - gba
    - link cable
---

The first time two Game Boy Advance games opened their link menu together inside a browser, nothing dramatic happened. Just two tiny 240x160 screens doing what they would have done over a physical cable.

But these were running inside [Rebit](https://rebit.cc), where the players could be on different networks.

The trick was to run every linked GBA in every browser, then send player inputs over the internet. mGBA handled the cable locally. Keeping those copies in sync was the hard part.

This is how we built it, from a two-player demo to a beta that supports up to four players using the game's own link menu.

## Why This Was Hard

Normal online multiplayer is already hard. GBA Link Cable is worse.

Most netplay systems work at the controller level. Each player runs the same emulator, sends inputs to each other, and every machine tries to stay deterministic. That works well when the game itself expects local controller input.

GBA Link Cable is different.

The multiplayer logic is inside the game, but the communication goes through the GBA serial I/O hardware, usually called SIO. The game writes to registers like `SIOCNT`, `RCNT`, and `SIOMLT_SEND`. The hardware waits for other GBAs. A transfer starts. Data from every player is exchanged. Interrupts fire. The game advances.

Timing and ordering matter. A late transfer can leave a game waiting; a different clock or an out-of-order transfer can make the simulations diverge. When that happens during a trade or save, player progress is at risk.

This is why the naive idea does not work:

> "Just send the GBA link cable packets over WebSocket."

That sounds reasonable until you remember that the original hardware expected cable timing, not 80ms mobile internet. If we directly forwarded SIO events across the network, every transfer would be held hostage by latency and jitter.

So the first big decision was this:

**Do not make the internet pretend to be a cable. Make every browser simulate the whole cable locally.**

That one decision shaped everything.

## The Core Idea

Instead of running only one GBA per browser, every browser in a Link Cable room runs the full linked set of GBAs locally.

For a 2-player room, each browser runs two mGBA cores.

For a 4-player room, each browser runs four mGBA cores.

That costs more CPU and memory, but it puts all the emulated cable communication inside one local simulation. In a four-player room, every client runs:

```text
Player 1 core
Player 2 core
Player 3 core
Player 4 core
GBA SIO lockstep coordinator
```

The network carries starting data and session messages:

- Each player's ROM and save data
- Which buttons each player presses each frame
- When the host starts, pauses, or stops the session
- State hashes for desync detection

The host does not stream video, and the server does not emulate the game. This is deterministic netplay where the replicated state includes every GBA and the cable connecting them.

## Why mGBA

We chose mGBA because the emulator already had serious work around GBA SIO and lockstep. That mattered a lot.

This was not a "write a quick fake cable" feature. Real games depend on edge cases:

- Multiplayer transfer timing
- Secondary GBA behavior
- SIO mode changes
- Save state compatibility
- Interrupt timing
- Normal and multiplayer modes
- RCNT/SIOCNT behavior

The mGBA history already had a long trail of SIO lockstep work: new lockstep drivers, save state support, hard sync, detach cleanup, and timing fixes. That was the foundation.

But Rebit needed something mGBA did not provide as a product-ready browser runtime: a small standalone WebAssembly module with a clean JavaScript API for loading multiple GBA cores, attaching them to the same SIO coordinator, running frames, extracting video/audio/save data, and checking determinism.

So we built `mgba_dual`.

The name is a little outdated now because it started as two players, but the runtime now supports up to four.

## Not A Normal Libretro Core

Rebit already uses WebAssembly libretro cores for normal emulation, but GBA Link Cable needed more control than a normal libretro core gives us.

For normal gameplay, a core exposes one game instance. For Link Cable, we need:

- Multiple mGBA cores in one WebAssembly module
- A shared SIO lockstep coordinator
- Per-player input masks
- Per-player framebuffers
- Per-player save data export
- State hash and state export APIs
- Deterministic RTC injection
- Runtime player detach

So `mgba_dual` is built as a standalone Emscripten runtime. It still fits our existing core asset pipeline, but internally it is not a normal libretro core.

The build exports a `createMGBAModule` factory and C APIs like:

```text
mgba_demo_load_game_multi
mgba_demo_set_keys
mgba_demo_run_frame
mgba_demo_get_framebuffer
mgba_demo_state_hash
mgba_demo_export_save
mgba_demo_detach_player
```

In JavaScript, Rebit loads the module, wraps those functions with `cwrap`, and treats the whole linked GBA room as a deterministic simulation engine.

## The First Version: Two Players

The first real version was simple in shape:

```c
#define DEMO_PLAYERS 2
```

Two mGBA cores. Two ROMs. Two save files. Two framebuffers. One lockstep coordinator.

When a player started a Link Cable room, Rebit prepared the local game file and latest in-game save. The players exchanged metadata first: ROM size, save size, hashes, and room protocol version. Then they transferred the needed bytes in chunks.

After both browsers had both players' starting data, each browser called into the WASM runtime:

```text
load player 1 ROM/save data
load player 2 ROM/save data
attach both cores to the SIO coordinator
reset both cores with the same RTC seed
start frame loop
```

The host became authoritative for frame ticks.

The host collected:

- Player 1 local input
- Player 2 remote input

Then the host advanced the local simulation and sent a `tick` message:

```json
{
  "kind": "tick",
  "frame": 1234,
  "keys": [0, 1]
}
```

The guest queued those ticks, applied the exact same key masks, and advanced its own local copy of both GBA cores.

If both browsers started from the same ROMs and saves and received the same frame inputs in the same order, they should produce the same state.

That "should" is where the real work started.

## Determinism Is A Long Fight

The first working demo is exciting. The second hour is humbling.

When building this, we learned that deterministic emulation is not just "same input, same output". It is:

- Same ROM
- Same save data
- Same emulator build
- Same config
- Same RTC
- Same link timing
- Same emulated execution order
- Same transfer drain behavior
- Same player assignment
- Same state after reset

Browsers do not have to finish each frame at the same wall-clock time. They have to perform the same emulated work for that frame.

The real-time clock (RTC) issue was a good example of a hidden input.

Some GBA games read time. If Player 1's browser and Player 2's browser disagree about the current date or second, the game state can diverge before anyone presses a button.

The host creates an RTC epoch seed and every player applies the same value through the mGBA runtime before reset. Matching that starting value is only part of the requirement: subsequent clock reads must also agree across peers. The core has a deterministic RTC compile definition to keep the browser wall clock from silently becoming a hidden network input.

That was one of those bugs that feels silly after you fix it, but it is exactly the kind of thing that destroys netplay.

## The Transfer Drain Problem

Another hard problem was queued link transfers.

In some games, the cores can appear to finish a visible frame while link cable work is still pending internally. If we stop running as soon as "every player advanced one frame", the UI looks fine but the SIO coordinator still has work to do.

Pokémon-style trade/save boundaries are especially sensitive to this.

The frame runner therefore has to account for pending link transfers before returning control to JavaScript.

The runtime now checks whether the coordinator has an active or pending transfer. If a player has already advanced but can help drain the transfer queue, we keep running it for a bounded number of assist passes.

That is why `mgba_demo_run_frame` is more complicated than a simple:

```text
for each player:
    runLoop()
```

It has to respect sleeping players, link queues, pending transfer starts, frame counters, and a maximum loop guard so a bad state does not hang the browser forever.

This was the difference between "the demo boots" and "the link menu survives real game behavior".

## Hashes, Desyncs, And Being Honest

Every 60 frames, Rebit asks the WASM runtime for a state hash for each active player.

Then peers exchange the hashes.

If the host and guest disagree, the session is not trustworthy anymore.

We experimented with recovery: exporting states, sending binary chunks, importing them on the other side, and resuming.

But link cable sessions are dangerous because players may be trading, battling, or saving. Hiding a bad state can be worse than stopping.

So the product decision became conservative:

**Stop when we detect a desync, and tell players the session is no longer trustworthy.**

Periodic hashes are a detection mechanism, not a guarantee that every trade or save is safe. Divergence can occur between checks. Stopping limits further damage; it does not prove that everything before the warning was correct.

## Why The Host Sends Ticks Instead Of Letting Everyone Run Freely

Another key decision was host authority.

Guests do not run freely at their own pace. They wait for ordered ticks from the host. The host limits how many frames it can get ahead based on guest acknowledgements.

This gives us backpressure:

- If a guest is slow, the host stops running too far ahead.
- If packets arrive with jitter, the guest buffers a small number of ticks.
- If tick order breaks, the session fails instead of guessing.

This moves the network wait out of individual cable transfers and into input delivery and frame scheduling. It does not remove latency: a guest's input still has to reach the host, and the resulting tick has to reach the guests.

A little buffering makes the session more stable, but it also makes controls feel less immediate. We tuned the guest buffer down after testing. Trades and menu-driven battles can tolerate more delay than fast action games, so the experience still depends on the game and connection.

## Classic Transport And Edge Transport

Networking has two paths.

Classic Link uses the existing room signaling and WebRTC DataChannels. That is nice because peer-to-peer data can be fast when NAT traversal works.

But browser peer-to-peer is not always reliable. Some networks block it. Some mobile connections are weird. Some users are behind restrictive routers.

So Rebit also has an Edge Link relay path. It still sends the same protocol messages, but through an edge WebSocket relay instead of a direct DataChannel.

This is another tradeoff:

- WebRTC can be lower latency when it connects cleanly.
- Relay is more reliable and easier to reason about.
- Relay costs server bandwidth.
- WebRTC costs debugging time.

For a beta feature, having both paths matters.

## Why Four Players Became Possible

The GBA multiplayer protocol supports up to four players in multiplayer mode, and mGBA's lockstep coordinator understands multiple attached players. Our first Rebit wrapper was fixed at two because that was the minimum useful proof. Expanding it did not require a new networking model.

The upgrade was still a lot of work, but it was not a conceptual rewrite.

We changed the runtime from fixed two-player assumptions to active player counts:

```text
minimum players: 2
maximum players: 4
players array: 4 slots
ROM/save inputs: 4 pairs
input ticks: array of player key masks
state hashes: array of player hashes
room roles: host, player2, player3, player4
```

The new API became `mgba_demo_load_game_multi`, which accepts ROM and save data blocks for up to four players and a `playerCount`.

On the app side, that meant room assignment, UI, chat roster, save export, input routing, and departure handling all had to understand Player 3 and Player 4.

The cost also scaled: four cores mean more CPU, memory, audio/video buffers, hashes, and startup data in every browser. Keeping cable timing local makes synchronization more manageable, but the weakest device in the room still matters.

## Player Detach Was Another Surprise

After the room could run, another question appeared:

What happens when someone leaves?

The simple answer is "end the session". The better answer is "unplug the link cable and keep the remaining game running when it is safe".

That required a detach export in the WASM API and careful handling inside the lockstep coordinator. We had to detach the missing player's SIO driver, wake remaining players, rebuild local runtime assumptions, and avoid killing the whole session if a player disappears after the game already loaded.

Whether the game can continue still depends on how it handles a disconnected cable.

## What Still Needs Work

This is still beta.

Some games will be more sensitive than others. Four-player sessions are heavier than two-player sessions. Mobile browsers can throttle tabs. Relays need to be close to users. WebRTC can fail in weird networks. Save safety matters more than pretending everything is fine.

I also want better diagnostics. When a session desyncs, developers need a clear answer:

- Which player diverged?
- Which frame?
- Which hash?
- Was it RTC?
- Was it a transfer?
- Was it startup data?
- Was it a stale WASM?

The more we can explain, the faster we can make compatibility better.

## The Feeling

I build a lot of web products, but this one felt different.

There is something satisfying about taking a handheld console feature from 2001 and making it work in a browser. The first link menu was exciting, but the work that followed—tracking down clock differences, draining transfers, handling disconnects—is what made it useful.

Sometimes the web still has room for ridiculous ideas.

And sometimes, with enough stubbornness, a Game Boy Advance link cable can become an internet feature.
