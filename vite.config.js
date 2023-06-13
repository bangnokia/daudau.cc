import UnoCSS from 'unocss/vite'
import { sveltekit } from '@sveltejs/kit/vite';

export default {
    plugins: [
        sveltekit(),
        UnoCSS({
            // transformers: [
            //     transformerDirectives(),
            // ],
            presets: [

            ]
        })
    ]
}
