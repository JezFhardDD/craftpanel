<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);

const logoText = '/images/CRAFTPANEL.png';
const logoImage = '/images/logo2bgr.png';
</script>

<template>
    <div
        class="min-h-screen flex items-center justify-center px-4 py-10 bg-cover bg-center bg-no-repeat"
        style="background-image: linear-gradient(rgba(17,24,39,0.82), rgba(17,24,39,0.9)), url('/images/wallpaper_minecraft_mineshaft_1920x1080.png');"
    >
        <Head title="Email Verification" />

        <div class="w-full max-w-lg rounded-2xl border border-gray-700 bg-gray-900/90 shadow-2xl backdrop-blur-sm p-8">
            <div class="mb-6 text-center">
                <img :src="logoImage" alt="CRAFTPANEL Logo" class="mx-auto h-14 w-14 mb-3" />
                <img :src="logoText" alt="CRAFTPANEL" class="mx-auto h-12 w-56" />
            </div>

            <div class="mb-6 text-center">
                <h2 class="font-minecraftTen text-3xl text-white mb-2">Verify Your Email</h2>
                <p class="text-sm text-gray-300">
                    Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent you.
                </p>
            </div>

            <div
                class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300"
                v-if="verificationLinkSent"
            >
                A new verification link has been sent to the email address you provided during registration.
            </div>

            <form @submit.prevent="submit" class="space-y-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <button
                        type="submit"
                        class="rounded-lg bg-green-500 px-6 py-3 font-bold text-white transition hover:bg-green-600 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing">Sending...</span>
                        <span v-else>Resend Verification Email</span>
                    </button>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="text-sm text-green-400 hover:text-green-300 hover:underline"
                    >
                        Log Out
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
