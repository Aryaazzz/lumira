import '../css/app.css'
import './bootstrap'

import { createInertiaApp, router } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

import AOS from 'aos'
import 'aos/dist/aos.css'

const appName = import.meta.env.VITE_APP_NAME || 'Lumira'

AOS.init({
    duration: 800,
    easing: 'ease-out-cubic',
    once: true,
    offset: 40,
    mirror: false,
    disableMutationObserver: false,
})

router.on('finish', () => {
    AOS.refreshHard()
})

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
    },
    progress: {
        color: '#166534',
    },
})