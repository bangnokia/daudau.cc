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
          'border-radius': '1rem',
        },
        'pre': {
          border: '1px solid rgba(255, 255, 255, 0.2)',
        }
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