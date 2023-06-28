// uno.config.ts
import { defineConfig } from 'unocss'
import { presetUno, presetTypography, presetWebFonts } from "unocss";


export default defineConfig({
  presets: [
    presetUno(),
    presetWebFonts({
      provider: 'bunny',
      fonts: {
        sans: ['Roboto'],
        mono: ['Fira Code', 'Fira Mono:400,700']
      }
    }),
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
          'border-radius': '1rem',
        },
      }
    }),
  ],
  preflights: [
    {
      getCSS: () => `
        body {
          background-color: #f5f5f5;
        }
        a {
            color: rgba(20,184,166)
        }
        a:hover {
            text-decoration: underline;
        }
      `
    }
  ]
})