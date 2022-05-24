import Unocss from 'unocss/vite'
import presetUno from '@unocss/preset-uno'

export default {
    plugins: [
        Unocss({
            presets: [presetUno()]
        })
    ]
}
