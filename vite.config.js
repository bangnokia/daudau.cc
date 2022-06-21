import Unocss from 'unocss/vite'
import { presetUno, presetAttributify, presetTypography } from "unocss";

export default {
    plugins: [
        Unocss({
            presets: [
                presetAttributify(),
                presetUno(),
                presetTypography(),
            ]
        })
    ]
}
