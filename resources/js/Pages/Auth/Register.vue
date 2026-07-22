<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Recaptcha from '@/components/Recaptcha.vue';

const recaptcha = ref(null);
const showPassword = ref(false);
const showConfirmPassword = ref(false);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'Player',
    'g-recaptcha-response': '',
});

const passwordRequirements = [
    'At least 8 characters',
    'One uppercase letter',
    'One lowercase letter',
    'One number',
    'One special character',
];

const passwordErrorMessage = () => {
    const password = form.password;
    const errors = [];

    if (password.length < 8) {
        errors.push('Password must be at least 8 characters long.');
    }
    if (!/[A-Z]/.test(password)) {
        errors.push('Password must include at least one uppercase letter.');
    }
    if (!/[a-z]/.test(password)) {
        errors.push('Password must include at least one lowercase letter.');
    }
    if (!/\d/.test(password)) {
        errors.push('Password must include at least one number.');
    }
    if (!/[^A-Za-z0-9]/.test(password)) {
        errors.push('Password must include at least one special character.');
    }
    if (password && password !== form.password_confirmation) {
        errors.push('Password confirmation does not match.');
    }

    return errors.join(' ');
};

const submit = () => {
    const passwordMessage = passwordErrorMessage();

    if (passwordMessage) {
        window.alert(passwordMessage);
        return;
    }

    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation', 'g-recaptcha-response');
            showPassword.value = false;
            showConfirmPassword.value = false;
            recaptcha.value?.reset();
        },
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
                        placeholder="Enter your display name"
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                    />
                    <p class="mt-1 text-xs text-gray-400">Use the name you want visible on your profile.</p>
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
                        placeholder="name@example.com"
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                    />
                    <p class="mt-1 text-xs text-gray-400">We’ll use this email to sign you in and recover your account.</p>
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
                    <p class="mt-1 text-xs text-gray-400">Choose the role that best fits your account.</p>
                    <div v-if="form.errors.role" class="text-red-500 text-sm mt-1">
                        {{ form.errors.role }}
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Password</label>
                    <div class="relative">
                        <input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            v-model="form.password"
                            required
                            placeholder="Create a strong password"
                            class="w-full px-4 py-2 pr-20 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                        />
                        <button
                            type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-green-400 hover:text-green-300"
                            @click="showPassword = !showPassword"
                        >
                            {{ showPassword ? 'Hide' : 'Show' }}
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Use at least 8 characters with uppercase, lowercase, a number, and a symbol.</p>
                    <div class="mt-2 text-xs text-gray-300">
                        <ul class="list-disc list-inside space-y-1">
                            <li v-for="item in passwordRequirements" :key="item">{{ item }}</li>
                        </ul>
                    </div>
                    <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">
                        {{ form.errors.password }}
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-300 text-sm font-bold mb-2">Confirm Password</label>
                    <div class="relative">
                        <input
                            id="password_confirmation"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            v-model="form.password_confirmation"
                            required
                            placeholder="Repeat your password"
                            class="w-full px-4 py-2 pr-20 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                        />
                        <button
                            type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-green-400 hover:text-green-300"
                            @click="showConfirmPassword = !showConfirmPassword"
                        >
                            {{ showConfirmPassword ? 'Hide' : 'Show' }}
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Re-enter the same password to confirm it matches.</p>
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
