---
title: Set up UnoCSS with Laravel (the right way)
tags:
    - unocss
    - laravel
layout: post
---

[UnoCSS](https://unocss.com/) is an **Instant On-demand Atomic CSS Engine** that helps you reduce the CSS file size by generating only the CSS that you need. UnoCSS also comes with *presets* that let you use Tailwind CSS, Bootstrap, or Bulma in your project easily.

The coolest thing is the [`Attributify`](https://unocss.dev/presets/attributify) preset, where you can write your CSS classes like:
```html
<div text-rose-500 uppercase bg-blue-200 p-4>
  Hello World
</div>
```
You see, it's not valid HTML, but CSS doesn't care.

## Installation
I'm using `pnpm` in this tutorial. You can use `npm` or `yarn` if you want.

### Add PostCSS integration
```bash
pnpm add -D unocss @unocss/postcss
```
*Why do I use the [PostCSS](https://unocss.dev/integrations/postcss) plugin instead of the [CLI](https://unocss.dev/integrations/cli)?* Because I don't want to change my `package.json` from
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
And when using the CLI, it also generates an `uno.css` file (which we should add to `.gitignore`) and we have to import it into our main `app.css` file, which is not cool.

### Create your PostCSS config file `postcss.config.js`:
```js
// postcss.config.js
import UnoCSS from '@unocss/postcss'

export default {
  plugins: [
    UnoCSS(),
  ],
}
```

### Create the UnoCSS config file `unocss.config.js`:
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

If you want to use custom brand colors like `primary` in your app, you can add them under `theme.colors`. They will be merged with the default theme.
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

Now you can start your dev server and write UnoCSS classes.
```
pnpm dev
```
