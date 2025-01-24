---
title: Setup UnoCSS with Laravel (The right way)
tags:
    - unocss
    - laravel
layout: post
---

[UnoCSS](https://unocss.com/) is an **Instant On-demand Atomic CSS Engine** that helps you to reduce the CSS file size by generating only the CSS that you need.  UnoCSS also comes with *presets* which you can use TailwindCSS, Bootstrap, or Bulma in your project easily.

The coolest thing is [`Attributify`](https://unocss.dev/presets/attributify) preset, where you can write your css classes like:
```html
<div text-rose-500 uppercase bg-blue-200 p-4>
  Hello World
</div>
```
You see, it's not valid html but CSS doesn't care

## Installation
I'm using `pnpm` in this tutorial, you can use `npm` or `yarn` if you want.

### Add postcss integration
```bash
pnpm add -D unocss @unocss/postcss
```
*Why do I use [PostCSS](https://unocss.dev/integrations/postcss) plugin instead of [CLI](https://unocss.dev/integrations/cli)*, because I don't want to update my `package.json` file, from
```json
{
  "scripts": {
    "dev": "vite"
  }
}
```
into something like
```json
{
  "scripts": {
    "dev": "unocss --watch & vite"
  }
}
```
And when using CLI, it also generates an `uno.css` file (and we should add this to `.gitignore`) and we have to import it into our main `app.css` file, which is not cool.

### Create your postcss config file `postcss.config.js`:
```js
// postcss.config.js
import UnoCSS from '@unocss/postcss'

export default {
  plugins: [
    UnoCSS(),
  ],
}
```

### Create Unocss config file `unocss.config.js`:
```js
// uno.config.js
import { defineConfig, presetUno, presetAttributify } from 'unocss'

export default defineConfig({
  content: {
     filesystem: [
       './resources/views/**/*.blade.php',
     ]
  },
  presets: [
    // presetAttributify(), // enable this if you want attributify mode
    presetUno(),
  ],
})
```

If you want to use some custom brand color like `primary` in your app, you can add it under `theme.colors`. It will be merged with the default theme.
```js
// uno.config.js
//... other stuff
presets: [...],
theme: {
  colors: {
     'primary': {
        '50': '#fff0f2',
        '100': '#ffdde3',
        '200': '#ffc1cb',
        '300': '#ff95a6',
        '400': '#ff5974',
        '500': '#ff2649',
        '600': '#fc062e',
        '700': '#e90026',
        '800': '#af0521',
        '900': '#900c22',
        '950': '#50000d',
        DEFAULT: '#ff2649'
    },
  }
}
```

### Finally, update your `resources/css/app.css`:
```css
/* style.css */
@unocss preflights;
@unocss default;

/*
  Fallback layer. It's always recommended to include.
  Only unused layers will be injected here.
*/
@unocss;
```

Now you can start you dev server and write UnoCSS
```
pnpm dev
```
