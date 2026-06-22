---
title: Making GBA Link Cable work over the internet
layout: post
tags:
    - rebit
    - emulation
    - webassembly
    - multiplayer
---

I still remember the first time I saw two Game Boy Advance screens talking to each other inside a browser.

It did not look dramatic. No huge animation. No fireworks. Just two tiny 240x160 canvases, both running the same game, both stepping frame by frame, and then the game opened its own link menu like this was normal.

But for me, it felt unreal.

The Game Boy Advance link cable was designed for a short physical cable. A few centimeters of copper. Very small timing windows. Hardware registers. Synchronous serial transfer. Two, three, or four handhelds sitting next to each other.

And somehow we were trying to make it work over the internet, inside Rebit, inside a browser, with WebAssembly, WebRTC, WebSocket relays, user saves, room codes, and unreliable human Wi-Fi.

This is the story of how we made GBA Link Cable possible on Rebit.

Not perfect. Not magic. But real enough that you can open a room, invite players, and use the game's own trade, battle, or multiplayer menu from the web.

## Why This Was Hard

Normal online multiplayer is already hard. GBA Link Cable is worse.

Most netplay systems work at the controller level. Each player runs the same emulator, sends inputs to each other, and every machine tries to stay deterministic. That works well when the game itself expects local controller input.

GBA Link Cable is different.

The multiplayer logic is inside the game, but the communication goes through the GBA serial I/O hardware, usually called SIO. The game writes to registers like `SIOCNT`, `RCNT`, and `SIOMLT_SEND`. The hardware waits for other GBAs. A transfer starts. Data from every player is exchanged. Interrupts fire. The game advances.

If one side is a little late, the game can wait forever.

If one side sees a different clock, the state diverges.

If one side gets a transfer start in the wrong order, the trade menu breaks.

If one side saves during a link transition while the other side is still draining a transfer, congratulations, you now have a desync that might corrupt the most important moment of the session.

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

That sounds expensive, and it is. But it gives us something incredibly valuable: every browser has the whole link cable world in one deterministic process.

The host does not stream video. The guest does not wait for remote SIO packets. The server does not emulate the game.

Every client runs:

```text
Player 1 core
Player 2 core
Player 3 core
Player 4 core
GBA SIO lockstep coordinator
```

Then the network only has to move the things that change per player:

- Which ROM and SRAM each player starts with
- Which buttons each player presses each frame
- When the host starts, pauses, or stops the session
- State hashes for desync detection

This is much more like deterministic netplay than packet tunneling.

The trick is that the deterministic world includes not just the game CPU, but also the GBA link cable behavior.

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

This part is important.

Rebit already uses WebAssembly libretro cores for normal emulation, but GBA Link Cable needed more control than a normal libretro core gives us.

For normal gameplay, a core exposes one game instance. For Link Cable, we need:

- Multiple mGBA cores in one WebAssembly module
- A shared SIO lockstep coordinator
- Per-player input masks
- Per-player framebuffers
- Per-player SRAM export
- State hash and state export APIs
- Deterministic RTC injection
- Runtime player detach

So `mgba_dual` is built as a standalone Emscripten runtime. It still produces files named `mgba_dual_libretro.js` and `mgba_dual_libretro.wasm` for compatibility with our asset pipeline, but internally it is not a normal libretro core.

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

Two mGBA cores. Two ROMs. Two SRAM files. Two framebuffers. One lockstep coordinator.

When a player started a Link Cable room, Rebit prepared the local game file and latest in-game save. The players exchanged metadata first: ROM size, SRAM size, hashes, and room protocol version. Then they transferred the needed bytes in chunks.

After both browsers had both players' starting data, each browser called into the WASM runtime:

```text
load player 1 ROM/SRAM
load player 2 ROM/SRAM
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

If both browsers started from the same ROM/SRAM and received the same frame inputs in the same order, they should produce the same state.

That "should" is where the real work started.

## Determinism Is A Long Fight

The first working demo is exciting. The second hour is humbling.

When building this, we learned that deterministic emulation is not just "same input, same output". It is:

- Same ROM
- Same SRAM
- Same emulator build
- Same config
- Same RTC
- Same link timing
- Same frame pacing
- Same transfer drain behavior
- Same player assignment
- Same state after reset

The RTC issue was a good example.

Some GBA games read time. If Player 1's browser and Player 2's browser disagree about the current date or second, the game state can diverge before anyone presses a button.

So we made RTC deterministic. The host creates an RTC epoch seed and every player applies the same value through the mGBA runtime before reset. The core also has a deterministic RTC compile definition so the browser wall clock does not silently become a hidden network input.

That was one of those bugs that feels silly after you fix it, but it is exactly the kind of thing that destroys netplay.

## The Transfer Drain Problem

Another hard problem was queued link transfers.

In some games, the cores can appear to finish a visible frame while link cable work is still pending internally. If we stop running as soon as "every player advanced one frame", the UI looks fine but the SIO coordinator still has work to do.

Pokemon-style trade/save boundaries are especially sensitive to this.

The fix was to teach the frame runner that link transfers are part of the frame's truth, not background noise.

The runtime now checks whether the coordinator has an active or pending transfer. If a player has already advanced but can help drain the transfer queue, we keep running it for a bounded number of assist passes.

That is why `mgba_demo_run_frame` is more complicated than a simple:

```c
for each player:
    runLoop()
```

It has to respect sleeping players, link queues, pending transfer starts, frame counters, and a maximum loop guard so a bad state does not hang the browser forever.

This was the difference between "the demo boots" and "the link menu survives real game behavior".

## Hashes, Desyncs, And Being Honest

Every 60 frames, Rebit asks the WASM runtime for a state hash for each active player.

Then peers exchange the hashes.

If the host and guest disagree, the session is not trustworthy anymore.

At one point we experimented with recovery: exporting states, sending binary chunks, importing them on the other side, and resuming. The code history still shows that stage. It was an attractive idea because nobody likes seeing a desync message.

But link cable sessions are dangerous because players may be trading, battling, or saving. Hiding a bad state can be worse than stopping.

So the product decision became conservative:

**Detect desyncs early and fail loudly before users trust a broken trade or save.**

That is not as flashy as automatic recovery, but it is the right tradeoff for a feature that can affect user progress.

## Why The Host Sends Ticks Instead Of Letting Everyone Run Freely

Another key decision was host authority.

Guests do not run freely at their own pace. They wait for ordered ticks from the host. The host limits how many frames it can get ahead based on guest acknowledgements.

This gives us backpressure:

- If a guest is slow, the host stops running too far ahead.
- If packets arrive with jitter, the guest buffers a small number of ticks.
- If tick order breaks, the session fails instead of guessing.

The tradeoff is latency.

A little buffering makes the session more stable, but it also makes controls feel slightly less immediate. We tuned the guest buffer down after testing because Link Cable games already have menus and transitions where correctness matters more than twitch responsiveness.

For battles and trades, a few frames of input delay is acceptable.

A desynced save is not.

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

The fun part is that once the two-player architecture worked, four players became possible for a very specific reason:

We were not trying to send physical cable signals over the internet.

We were replicating the entire linked GBA room inside every browser.

The GBA multiplayer protocol already supports up to four players in multi mode. mGBA's lockstep coordinator understands multiple attached players. Our first Rebit wrapper was artificially fixed at two because that was the minimum useful proof.

The upgrade was still a lot of work, but it was not a conceptual rewrite.

We changed the runtime from fixed two-player assumptions to active player counts:

```text
minimum players: 2
maximum players: 4
players array: 4 slots
ROM/SRAM inputs: 4 pairs
input ticks: array of player key masks
state hashes: array of player hashes
room roles: host, player2, player3, player4
```

The new API became `mgba_demo_load_game_multi`, which accepts ROM/SRAM blocks for up to four players and a `playerCount`.

On the app side, that meant room assignment, UI, chat roster, save export, input routing, and departure handling all had to understand Player 3 and Player 4.

The cost also scaled.

In a four-player room, every browser may run four mGBA cores. That means more CPU, more memory, more audio/video buffers, more hashes, and more startup data. We made peace with that because the alternative - remote SIO over the internet - would have been much more fragile.

The architecture bought us correctness. The tradeoff was local compute.

That is a trade I am happy with.

## Player Detach Was Another Surprise

After the room could run, another question appeared:

What happens when someone leaves?

The simple answer is "end the session". The better answer is "unplug the link cable and keep the remaining game running when it is safe".

That required a detach export in the WASM API and careful handling inside the lockstep coordinator. We had to detach the missing player's SIO driver, wake remaining players, rebuild local runtime assumptions, and avoid killing the whole session if a player disappears after the game already loaded.

This is one of those product details that sounds small but makes the feature feel alive.

A real cable can be unplugged.

Our fake internet cable needed to survive that too.

## The Build Pipeline

The build project has a special `mgba_dual` target.

It clones the Rebit mGBA fork, builds `rebit/emscripten` with Emscripten, and copies the output into the Rebit public cores directory:

```bash
cd build-cores
./setup-cores.sh mgba_dual
make build-core CORE=mgba_dual
```

The output is:

```text
mgba_dual_libretro.js
mgba_dual_libretro.wasm
```

Even though the filename says `libretro`, the runtime is our standalone mGBA multiplayer module.

We also had to use cache keys aggressively. When the WASM changed but the browser or service worker kept an old file, the JavaScript API and WASM exports could disagree. That kind of bug is painful because the code looks correct, but the user's browser is running yesterday's core.

So every core change needs a cache bump.

## The Commit History Tells The Story

Looking back, the history is almost a diary of the problems:

- May 2: split-view mGBA dual playground and bundled artifacts
- May 16: standalone Rebit Emscripten runtime for mGBA multiplayer
- May 17: first GBA Link Cable multiplayer integration in Rebit
- May 19: guest buffer tuning and cache busting
- May 24: deterministic RTC and desync recovery experiments
- May 27: pending transfer handling and local relay tooling
- June 5: better data exchange and room roster
- June 7-8: player departure and detach support
- June 9: four-player GBA Link Cable promotion

That is how these features usually happen.

Not one giant genius commit. More like a long argument with reality.

Every time the game froze, we learned where the abstraction was wrong.

Every time a save diverged, we found another hidden input.

Every time the browser cached the wrong WASM, we added another guard.

Every time a third or fourth player joined, we discovered one more place where the code secretly believed the world only had two people.

## What I Like About This Solution

The best part is that the browser is not just a thin client.

It is running real emulation. It is participating in the deterministic simulation. It owns the game state.

The network is important, but it is not pretending to be a hardware cable at cycle-level latency. It is just carrying enough information for every browser to recreate the same local universe.

That is the part that still feels beautiful to me.

We did not defeat latency by making the internet faster.

We avoided asking latency the wrong question.

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

Most web features are CRUD, payments, uploads, dashboards, forms, queues, caches. Useful stuff. Important stuff. But this was different.

This was taking a handheld console feature from 2001 and convincing it to survive modern browsers, NAT, mobile Wi-Fi, WebAssembly memory, service worker caching, and internet latency.

It should not have worked.

But the first time two browser tabs reached the in-game link menu together, it felt like opening a door.

Then two players became stable.

Then we fought desyncs.

Then we fixed RTC.

Then transfer drains.

Then saves.

Then detach.

Then four players.

And suddenly the impossible thing was not impossible anymore. It was just engineering: ugly in the middle, fragile at the edges, but real.

That is the part I love most.

Sometimes the web still has room for ridiculous ideas.

And sometimes, with enough stubbornness, a Game Boy Advance link cable can become an internet feature.
