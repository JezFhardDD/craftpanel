<script setup>
import { onMounted, ref } from 'vue';

const emit = defineEmits(['verify', 'expire']);
const container = ref(null);
let widgetId = null;

onMounted(() => {
    const render = () => {
        if (window.grecaptcha && window.grecaptcha.render) {
            widgetId = window.grecaptcha.render(container.value, {
                sitekey: import.meta.env.VITE_RECAPTCHA_SITE_KEY,
                callback: (token) => emit('verify', token),
                'expired-callback': () => emit('expire'),
            });
        } else {
            setTimeout(render, 200); // wait for the external script to load
        }
    };
    render();
});

defineExpose({
    reset: () => window.grecaptcha?.reset(widgetId),
});
</script>

<template>
    <div ref="container"></div>
</template>