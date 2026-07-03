<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-900 flex items-center justify-center px-4">
        <Head title="Login" />
        <div class="w-full max-w-md bg-gray-800 p-8 rounded-xl shadow-md border border-gray-700">
            <h2 class="text-3xl font-bold text-white text-center mb-6 font-minecraftTen">Login to CRAFTPANEL</h2>

            <form @submit.prevent="submit">
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                    <input
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        autofocus
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                    />
                    <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
                        {{ form.errors.email }}
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Password</label>
                    <input
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                    />
                    <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">
                        {{ form.errors.password }}
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-4 flex items-center">
                    <input
                        id="remember"
                        type="checkbox"
                        v-model="form.remember"
                        class="rounded text-green-500 bg-gray-700 border-gray-600 focus:ring-green-400"
                    />
                    <label for="remember" class="ml-2 text-sm text-gray-300">Remember me</label>
                </div>

                <!-- Forgot Password & Submit -->
                <div class="mb-6 flex justify-between items-center">
                    <Link
                        v-if="route().has('password.request')"
                        :href="route('password.request')"
                        class="text-sm text-green-400 hover:underline"
                    >
                        Forgot your password?
                    </Link>

                    <button
                        type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200"
                        :disabled="form.processing"
                        :class="{ 'opacity-50': form.processing }"
                    >
                        Login
                    </button>
                </div>

                <!-- Signup Redirect -->
                <div class="text-center text-sm text-gray-400">
                    Don't have an account?
                    <Link :href="route('register')" class="text-green-400 hover:underline">
                        Sign up here
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
