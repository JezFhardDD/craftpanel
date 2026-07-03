<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3';
const props = defineProps({
    user: Object,
    playerStats: Object,
});

// Form setup
const form = useForm({
    name: props.user.name,
    
    is_online: props.user.is_online,
    level: props.playerStats.level,
    xp_points: props.playerStats.xp_points,
    kills_pvp: props.playerStats.kills_pvp,
    kills_pve: props.playerStats.kills_pve,
    achievements_unlocked: props.playerStats.achievements_unlocked,
});

const submit = () => {
    console.log('Submit started');
    console.log('Form data:', form.data());
    console.log('Form errors before submit:', form.errors);
    
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onStart: () => {
            console.log('Request started');
        },
        onProgress: (progress) => {
            console.log('Progress:', progress);
        },
        onSuccess: (response) => {
            console.log('Success callback triggered');
            console.log('Response:', response);
            console.log('Current URL:', window.location.href);
        },
        onError: (errors) => {
            console.log('Error callback triggered');
            console.log('Errors:', errors);
            console.log('Form errors after submit:', form.errors);
        },
        onFinish: () => {
            console.log('Request finished');
            console.log('Final URL:', window.location.href);
        }
    });
};


// Image paths
const logoText = "/images/CRAFTPANEL.png";
const logoImage = "/images/logo2bgr.png";
</script>

<template>
    <Head title="Edit Profile" />

    <AuthenticatedLayout>
        <!-- Full-width background container -->
        <div
            class="font-minecraft min-h-screen bg-gray-900 bg-[url('/images/wallpaper_minecraft_mangroves_1920x1080.png')] bg-cover bg-fixed bg-center"
        >
            <!-- Navigation Header -->
            <nav
                class="fixed top-0 w-full bg-gray-900/95 backdrop-blur-sm z-50 border-b border-gray-800"
            >
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex items-center space-x-3">
                            <img
                                :src="logoImage"
                                alt="CRAFTPANEL Logo"
                                class="h-10 w-10"
                            />
                            <img
                                :src="logoText"
                                alt="CRAFTPANEL"
                                class="h-15 w-60 mx-auto"
                            />
                        </div>

                        <!-- Back Link -->
                        <Link
                            href="/profile"
                            class="text-green-400 hover:text-green-300 flex items-center"
                        >
                            <svg
                                class="w-4 h-4 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 19l-7-7 7-7"
                                ></path>
                            </svg>
                            Back to Profile
                        </Link>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="pt-20 pb-10 min-h-screen">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Page Header -->
                    <div class="mb-8">
                        <h1 class="font-minecraftTen text-3xl text-white">
                            EDIT PROFILE
                        </h1>
                        <p class="text-gray-400 mt-2">
                            Update your player information
                        </p>
                    </div>

                    <!-- Edit Form -->
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- User Information Card -->
                        <div
                            class="bg-gray-800/90 backdrop-blur-sm p-6 rounded-xl border border-gray-700 shadow-lg"
                        >
                            <h2
                                class="font-minecraftTen text-xl text-white mb-6 border-b border-gray-700 pb-2"
                            >
                                USER INFORMATION
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Username -->
                                <div>
                                    <label
                                        for="name"
                                        class="block text-gray-400 mb-2"
                                        >Username</label
                                    >
                                    <input
                                        id="name"
                                        type="text"
                                        v-model="form.name"
                                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        required
                                    />
                                    <div
                                        v-if="form.errors.name"
                                        class="text-red-400 text-sm mt-1"
                                    >
                                        {{ form.errors.name }}
                                    </div>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label
                                        for="is_online"
                                        class="block text-gray-400 mb-2"
                                        >Status</label
                                    >
                                    <select
                                        id="is_online"
                                        v-model="form.is_online"
                                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    >
                                        <option :value="true">Online</option>
                                        <option :value="false">Offline</option>
                                    </select>
                                    <div
                                        v-if="form.errors.is_online"
                                        class="text-red-400 text-sm mt-1"
                                    >
                                        {{ form.errors.is_online }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Player Statistics Card -->
                        <div
                            class="bg-gray-800/90 backdrop-blur-sm p-6 rounded-xl border border-gray-700 shadow-lg"
                        >
                            <h2
                                class="font-minecraftTen text-xl text-white mb-6 border-b border-gray-700 pb-2"
                            >
                                PLAYER STATISTICS
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Level -->
                                <div>
                                    <label
                                        for="level"
                                        class="block text-gray-400 mb-2"
                                        >Level</label
                                    >
                                    <input
                                        id="level"
                                        type="number"
                                        v-model.number="form.level"
                                        min="1"
                                        max="100"
                                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        required
                                    />
                                    <div
                                        v-if="form.errors.level"
                                        class="text-red-400 text-sm mt-1"
                                    >
                                        {{ form.errors.level }}
                                    </div>
                                </div>

                                <!-- XP Points -->
                                <div>
                                    <label
                                        for="xp_points"
                                        class="block text-gray-400 mb-2"
                                        >XP Points</label
                                    >
                                    <input
                                        id="xp_points"
                                        type="number"
                                        v-model.number="form.xp_points"
                                        min="0"
                                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        required
                                    />
                                    <div
                                        v-if="form.errors.xp_points"
                                        class="text-red-400 text-sm mt-1"
                                    >
                                        {{ form.errors.xp_points }}
                                    </div>
                                </div>

                                <!-- PvP Kills -->
                                <div>
                                    <label
                                        for="kills_pvp"
                                        class="block text-gray-400 mb-2"
                                        >PvP Kills</label
                                    >
                                    <input
                                        id="kills_pvp"
                                        type="number"
                                        v-model.number="form.kills_pvp"
                                        min="0"
                                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        required
                                    />
                                    <div
                                        v-if="form.errors.kills_pvp"
                                        class="text-red-400 text-sm mt-1"
                                    >
                                        {{ form.errors.kills_pvp }}
                                    </div>
                                </div>

                                <!-- PvE Kills -->
                                <div>
                                    <label
                                        for="kills_pve"
                                        class="block text-gray-400 mb-2"
                                        >PvE Kills</label
                                    >
                                    <input
                                        id="kills_pve"
                                        type="number"
                                        v-model.number="form.kills_pve"
                                        min="0"
                                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        required
                                    />
                                    <div
                                        v-if="form.errors.kills_pve"
                                        class="text-red-400 text-sm mt-1"
                                    >
                                        {{ form.errors.kills_pve }}
                                    </div>
                                </div>

                                <!-- Achievements -->
                                <div class="md:col-span-2">
                                    <label
                                        for="achievements_unlocked"
                                        class="block text-gray-400 mb-2"
                                        >Achievements Unlocked</label
                                    >
                                    <input
                                        id="achievements_unlocked"
                                        type="number"
                                        v-model.number="form.achievements_unlocked"
                                        min="0"
                                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        required
                                    />
                                    <div
                                        v-if="form.errors.achievements_unlocked"
                                        class="text-red-400 text-sm mt-1"
                                    >
                                        {{ form.errors.achievements_unlocked }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between items-center">
                            <Link
                                href="/profile"
                                class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors flex items-center"
                            >
                                <svg
                                    class="w-5 h-5 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    ></path>
                                </svg>
                                Cancel
                            </Link>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="px-6 py-3 bg-green-600 hover:bg-green-700 disabled:bg-green-800 text-white rounded-lg transition-colors flex items-center"
                            >
                                <svg
                                    v-if="form.processing"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                <svg
                                    v-else
                                    class="w-5 h-5 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    ></path>
                                </svg>
                                {{ form.processing ? "Saving..." : "Save Changes" }}
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Ensure full height for background */
html,
body {
    height: 100%;
    margin: 0;
}
</style>