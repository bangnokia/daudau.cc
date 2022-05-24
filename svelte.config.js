import preprocess from 'svelte-preprocess';
import Unocss from 'unocss/vite'
import {presetUno, presetAttributify, presetTypography} from "unocss";

/** @type {import('@sveltejs/kit').Config} */
const config = {
	// Consult https://github.com/sveltejs/svelte-preprocess
	// for more information about preprocessors
	preprocess: preprocess(),
    kit: {
        vite: {
            plugins: [
                Unocss({
                    presets: [
                        presetAttributify(),
                        presetUno(),
                        presetTypography()
                    ]
                })
            ]
        }
    }
};

export default config;
