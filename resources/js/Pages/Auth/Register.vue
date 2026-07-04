<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Recaptcha from '@/components/Recaptcha.vue';

const recaptcha = ref(null);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'Player', // Default role
    'g-recaptcha-response': '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation', 'g-recaptcha-response');
            recaptcha.value.reset(); 
        }
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-900 flex items-center justify-center px-4">
        <Head title="Register" />
        <div class="w-full max-w-md bg-gray-800 p-8 rounded-xl shadow-md border border-gray-700">
            <h2 class="text-3xl font-bold text-white text-center mb-6 font-minecraftTen">Create Your Account</h2>

            <form @submit.prevent="submit">
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Name</label>
                    <input
                        id="name"
                        type="text"
                        v-model="form.name"
                        required
                        autofocus
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                    />
                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
                        {{ form.errors.name }}
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                    <input
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                    />
                    <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
                        {{ form.errors.email }}
                    </div>
                </div>

                <!-- Role Dropdown -->
                <div class="mb-4">
                    <label for="role" class="block text-gray-300 text-sm font-bold mb-2">User Role</label>
                    <select
                        id="role"
                        v-model="form.role"
                        required
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                    >
                        <option value="Player">Player</option>
                        <option value="World Owner">World Owner</option>
                        <option value="Admin">Admin</option>
                    </select>
                    <div v-if="form.errors.role" class="text-red-500 text-sm mt-1">
                        {{ form.errors.role }}
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

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-300 text-sm font-bold mb-2">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        required
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                    />
                    <div v-if="form.errors.password_confirmation" class="text-red-500 text-sm mt-1">
                        {{ form.errors.password_confirmation }}
                    </div>
                </div>
                <div class="mb-4">
                    <Recaptcha
                        ref="recaptcha"
                        @verify="token => form['g-recaptcha-response'] = token"
                        @expire="() => form['g-recaptcha-response'] = ''"
                    />
                    <div v-if="form.errors['g-recaptcha-response']" class="text-red-500 text-sm mt-1">
                        {{ form.errors['g-recaptcha-response'] }}
                    </div>
                </div>
                <!-- Submit -->
                <div class="mb-6">
                    <button
                        type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200"
                        :disabled="form.processing"
                        :class="{ 'opacity-50': form.processing }"
                    >
                        Register
                    </button>
                </div>

                <!-- Already registered -->
                <div class="text-center text-sm text-gray-400">
                    Already have an account?
                    <Link :href="route('login')" class="text-green-400 hover:underline">
                        Log in here
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
