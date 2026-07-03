import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Define the fade-in directive
const fadeInOnScroll = {
  mounted(el) {
    const directionClasses = {
      'fade-left': ['-translate-x-20', 'translate-x-0'],
      'fade-right': ['translate-x-20', 'translate-x-0'],
      'fade-up': ['translate-y-20', 'translate-y-0'],
      'fade-down': ['-translate-y-20', 'translate-y-0'],
    }

    // Base fade + transition
    el.classList.add('opacity-0', 'transition-all', 'duration-1500', 'ease-in-out')

    // Determine direction class
    let direction = Object.keys(directionClasses).find(dir => el.classList.contains(dir)) || 'fade-up'
    const [offClass, onClass] = directionClasses[direction]

    el.classList.add(offClass)

    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          el.classList.remove('opacity-0', offClass)
          el.classList.add('opacity-100', onClass)
        } else {
          el.classList.remove('opacity-100', onClass)
          el.classList.add('opacity-0', offClass)
        }
      },
      { threshold: 0.1 }
    )

    observer.observe(el)
  }
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .directive('fade-in-on-scroll', fadeInOnScroll); // Register the directive
            
        return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});