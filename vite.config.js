import Unocss from 'unocss/vite'
import { presetUno, presetAttributify, presetTypography, transformerDirectives } from "unocss";
import { sveltekit } from '@sveltejs/kit/vite';
import { NodeGlobalsPolyfillPlugin } from '@esbuild-plugins/node-globals-polyfill'

export default {
    plugins: [
        sveltekit(),
        Unocss({
            transformers: [
                transformerDirectives(),
            ],
            presets: [
                presetAttributify(),
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
                            margin: "1\.5rem 0",
                        },
                        img: {
                            'border-radius': '0.5rem',
                        },
                        'pre': {
                            'background-color': "#e5e5e5 !important",
                        },
                    }
                }),
            ]
        })
    ],
    optimizeDeps: {
        esbuildOptions: {
            // Node.js global to browser globalThis
            define: {
                global: 'globalThis'
            },
            // Enable esbuild polyfill plugins
            plugins: [
                NodeGlobalsPolyfillPlugin({
                    buffer: true
                })
            ]
        }
    }
}
