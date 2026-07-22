<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const logoText = '/images/CRAFTPANEL.png';
const logoImage = '/images/logo2bgr.png';
</script>

<template>
    <div
        class="min-h-screen flex items-center justify-center px-4 py-10 bg-cover bg-center bg-no-repeat"
        style="background-image: linear-gradient(rgba(17,24,39,0.82), rgba(17,24,39,0.9)), url('/images/wallpaper_minecraft_mineshaft_1920x1080.png');"
    >
        <Head title="Reset Password" />

        <div class="w-full max-w-lg rounded-2xl border border-gray-700 bg-gray-900/90 shadow-2xl backdrop-blur-sm p-8">
            <div class="mb-6 text-center">
                <img :src="logoImage" alt="CRAFTPANEL Logo" class="mx-auto h-14 w-14 mb-3" />
                <img :src="logoText" alt="CRAFTPANEL" class="mx-auto h-12 w-56" />
            </div>

            <div class="mb-6 text-center">
                <h2 class="font-minecraftTen text-3xl text-white mb-2">Choose a New Password</h2>
                <p class="text-sm text-gray-300">
                    Set a fresh password for your account below.
                </p>
            </div>

            <form @submit.prevent="submit" class="space-y-5">
                <div>
                    <label for="email" class="mb-2 block text-sm font-bold text-gray-200">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full rounded-lg border border-gray-600 bg-gray-800 px-4 py-3 text-white placeholder-gray-400 focus:border-green-400 focus:outline-none"
                    />
                    <div v-if="form.errors.email" class="mt-2 text-sm text-red-400">
                        {{ form.errors.email }}
                    </div>
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-bold text-gray-200">New Password</label>
                    <input
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-gray-600 bg-gray-800 px-4 py-3 text-white placeholder-gray-400 focus:border-green-400 focus:outline-none"
                    />
                    <p class="mt-1 text-xs text-gray-400">Use 8+ characters with a mix of letters, numbers, and symbols.</p>
                    <div v-if="form.errors.password" class="mt-2 text-sm text-red-400">
                        {{ form.errors.password }}
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-bold text-gray-200">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-gray-600 bg-gray-800 px-4 py-3 text-white placeholder-gray-400 focus:border-green-400 focus:outline-none"
                    />
                    <div v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-400">
                        {{ form.errors.password_confirmation }}
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <Link
                        :href="route('login')"
                        class="text-sm text-green-400 hover:text-green-300 hover:underline"
                    >
                        Back to login
                    </Link>

                    <button
                        type="submit"
                        class="rounded-lg bg-green-500 px-6 py-3 font-bold text-white transition hover:bg-green-600 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing">Resetting...</span>
                        <span v-else>Reset Password</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
