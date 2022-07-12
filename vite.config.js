import Unocss from 'unocss/vite'
import { presetUno, presetAttributify, presetTypography } from "unocss";

export default {
    plugins: [
        Unocss({
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
                            border: '1px solid #eee',
                            'border-radius': '0.5rem',
                        }
                    }
                }),
            ]
        })
    ]
}
