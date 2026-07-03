<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    user: Object,
    playerStats: Object,
});

const showFriends = ref(false);
const dropdownOpen = ref(false);
const toggleFriends = () => {
    showFriends.value = !showFriends.value;
};
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

// Image paths
const logoText = "/images/CRAFTPANEL.png";
const logoImage = "/images/logo2bgr.png";
</script>

<template>
    <Head title="Profile" />

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

                        <!-- User Dropdown -->
                        <div class="relative">
                            <button
                                @click="toggleDropdown"
                                class="flex items-center space-x-2 focus:outline-none"
                            >
                                <span class="text-white font-medium">{{
                                    user.name
                                }}</span>
                                <div
                                    class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-sm font-bold text-white"
                                >
                                    {{ playerStats.level }}
                                </div>
                            </button>

                            <div
                                v-if="dropdownOpen"
                                class="absolute right-0 mt-2 w-56 bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-700"
                            >
                                <Link
                                    href="/profile"
                                    class="block px-4 py-2 text-white hover:bg-gray-700"
                                    >Profile</Link
                                >
                                <Link
                                    href="/friends"
                                    class="block px-4 py-2 text-white hover:bg-gray-700"
                                    >Friends</Link
                                >
                                <Link
                                    href="/friend-requests"
                                    class="block px-4 py-2 text-white hover:bg-gray-700"
                                    >Friend Requests</Link
                                >
                                <Link
                                    href="/about"
                                    class="block px-4 py-2 text-white hover:bg-gray-700"
                                    >About</Link
                                >
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="w-full text-left px-4 py-2 text-white hover:bg-red-600"
                                >
                                    Logout
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content - Full width with padding -->
            <main class="pt-20 pb-10 min-h-screen">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Profile Header -->
                    <div class="flex items-center justify-between mb-8">
                        <h1 class="font-minecraftTen text-3xl text-white">
                            PLAYER PROFILE
                        </h1>
                        <Link
                            href="/player-dashboard"
                            class="text-green-400 hover:text-green-300 flex items-center"
                        >
                            Back to Dashboard
                            <svg
                                class="w-4 h-4 ml-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                ></path>
                            </svg>
                        </Link>
                    </div>

                    <!-- Profile Sections -->
                    <div class="space-y-6">
                        <!-- Basic Info Card -->
                        <div
                            class="bg-gray-800/90 backdrop-blur-sm p-6 rounded-xl border border-gray-700 shadow-lg"
                        >
                            <h2
                                class="font-minecraftTen text-xl text-white mb-4 border-b border-gray-700 pb-2"
                            >
                                USER INFO
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-400">Username:</p>
                                    <p class="text-white font-bold">
                                        {{ user.name }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-400">Status:</p>
                                    <p class="flex items-center space-x-2">
                                        <span
                                            :class="
                                                user.is_online
                                                    ? 'bg-green-500'
                                                    : 'bg-red-500'
                                            "
                                            class="inline-block w-3 h-3 rounded-full"
                                        ></span>
                                        <span class="text-white">{{
                                            user.is_online
                                                ? "Online"
                                                : "Offline"
                                        }}</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-400">Email:</p>
                                    <p class="text-white">{{ user.email }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-400">Member Since:</p>
                                    <p class="text-white">
                                        {{
                                            new Date(
                                                user.created_at
                                            ).toLocaleDateString()
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Card -->
                        <div
                            class="bg-gray-800/90 backdrop-blur-sm p-6 rounded-xl border border-gray-700 shadow-lg"
                        >
                            <h2
                                class="font-minecraftTen text-xl text-white mb-4 border-b border-gray-700 pb-2"
                            >
                                PLAYER STATISTICS
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
    <!-- Level -->
    <div class="bg-gray-700/50 p-4 rounded-lg border border-gray-600">
        <p class="text-gray-400">Level</p>
        <p class="text-green-400 text-2xl font-bold">{{ playerStats.level }}</p>
    </div>
    
    <!-- XP Points -->
    <div class="bg-gray-700/50 p-4 rounded-lg border border-gray-600">
        <p class="text-gray-400">XP Points</p>
        <p class="text-green-400 text-2xl font-bold">{{ playerStats.xp_points }}</p>
    </div>
    
    <!-- PvP Kills -->
    <div class="bg-gray-700/50 p-4 rounded-lg border border-gray-600">
        <p class="text-gray-400">PvP Kills</p>
        <p class="text-green-400 text-2xl font-bold">{{ playerStats.kills_pvp }}</p>
    </div>
    
    <!-- PvE Kills -->
    <div class="bg-gray-700/50 p-4 rounded-lg border border-gray-600">
        <p class="text-gray-400">PvE Kills</p>
        <p class="text-green-400 text-2xl font-bold">{{ playerStats.kills_pve }}</p>
    </div>
</div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                                <div>
                                    <h4
                                        class="text-white font-medium mb-2 flex items-center"
                                    >
                                        Friends
                                        <button
                                            @click="toggleFriends"
                                            class="text-green-400 text-sm ml-2"
                                        >
                                            {{
                                                showFriends
                                                    ? "[Hide]"
                                                    : "[View]"
                                            }}
                                        </button>
                                    </h4>
                                    <p class="text-gray-400">
                                        {{ playerStats.friends_count }} friends
                                    </p>

                                    <div
                                        v-if="showFriends"
                                        class="mt-4 border-t border-gray-700 pt-4"
                                    >
                                        <div class="grid grid-cols-2 gap-3">
                                            <!-- Friend Item Placeholder -->
                                            <div
                                                v-for="i in 4"
                                                :key="i"
                                                class="flex items-center space-x-3 p-2 hover:bg-gray-700/50 rounded"
                                            >
                                                <div
                                                    class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center text-xs"
                                                >
                                                    {{ i }}
                                                </div>
                                                <span class="text-white text-sm"
                                                    >Friend {{ i }}</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-white font-medium mb-2">
                                        Achievements
                                    </h4>
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="w-8 h-8 bg-yellow-500/20 rounded-full flex items-center justify-center"
                                        >
                                            <span
                                                class="text-yellow-400 text-xs"
                                                >★</span
                                            >
                                        </div>
                                        <span class="text-white"
                                            >{{
                                                playerStats.achievements_unlocked
                                            }}
                                            unlocked</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <Link :href="route('profile.edit')" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
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
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    ></path>
                                </svg>
                                Edit Profile
                            </Link>
                        </div>
                    </div>
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
