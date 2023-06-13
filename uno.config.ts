// uno.config.ts
import { defineConfig } from 'unocss'
import { presetUno, presetTypography } from "unocss";


export default defineConfig({
  presets: [
    presetUno(),
    presetTypography({
      cssExtend: {
        a: {
          'text-decoration': 'none',
          color: 'rose'
        },
        'a:hover': {
          'text-decoration': 'underline',
        },
        p: {
          margin: "1.5rem 0",
        },
        img: {
          'border-radius': '0.5rem',
        },
        'pre': {
          'background-color': "#e5e5e5 !important",
        },
      }
    }),
  ],
})