<!-- resources/js/Pages/About.vue -->
<template>
    <div class="overflow-auto font-minecraft min-h-screen bg-gray-900">
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
                            <!-- Conditional display based on user role -->
                            <div
                                v-if="playerStats"
                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-sm font-bold text-white"
                            >
                                {{ playerStats.level }}
                            </div>
                            <div
                                v-else
                                class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-sm font-bold text-white"
                            >
                                {{ user.name.charAt(0).toUpperCase() }}
                            </div>
                        </button>

                        <div
                            v-if="dropdownOpen"
                            class="absolute right-0 mt-2 w-56 bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-700"
                        >
                            <!-- Role-specific profile links -->
                            <Link
                                v-if="userRole === 'Player'"
                                href="/profile"
                                class="block px-4 py-2 text-white hover:bg-gray-700"
                                >Profile</Link
                            >
                            <Link
                                v-else-if="userRole === 'World Owner'"
                                 :href="route('world-owner.profile')"
                                class="block px-4 py-2 text-white hover:bg-gray-700"
                                >Profile</Link
                            >
                            
                            <!-- Common links for Players -->
                            <template v-if="userRole === 'Player'">
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
                            </template>
                            
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

        <!-- Main Content -->
        <main class="pt-20 pb-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
            <div
                class="bg-gray-800/90 backdrop-blur-sm rounded-xl border border-gray-700 shadow-lg p-8 bg-[url('/images/wallpaper_minecraft_mineshaft_1920x1080.png')] bg-cover bg-center bg-no-repeat"
            >
                <h1
                    class="font-minecraftTen text-3xl text-white mb-6 text-center"
                >
                    About CRAFTPANEL
                </h1>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Project Info -->
                    <div
                        class="bg-gray-700/50 p-6 rounded-lg border border-gray-600"
                    >
                        <h2
                            class="font-minecraftTen text-xl text-green-400 mb-4"
                        >
                            The Project
                        </h2>
                        <p class="text-gray-300 mb-4">
                            CRAFTPANEL is a Minecraft-inspired player management
                            system where:
                        </p>
                        <ul class="list-disc pl-5 text-gray-400 space-y-2">
                            <li>Players can join worlds and complete quests</li>
                            <li>World Owners create and manage game worlds</li>
                            <li>Admins oversee the entire community</li>
                        </ul>
                    </div>

                    <!-- Role-specific Features -->
                    <div
                        class="bg-gray-700/50 p-6 rounded-lg border border-gray-600"
                    >
                        <h2
                            class="font-minecraftTen text-xl text-green-400 mb-4"
                        >
                            <!-- Dynamic title based on user role -->
                            <span v-if="userRole === 'Player'">Player Features</span>
                            <span v-else-if="userRole === 'World Owner'">World Owner Features</span>
                            <span v-else>Key Features</span>
                        </h2>
                        <div class="space-y-4">
                            <!-- Player-specific features -->
                            <template v-if="userRole === 'Player'">
                                <div
                                    v-for="(feature, index) in playerFeatures"
                                    :key="index"
                                    class="flex items-start"
                                >
                                    <div class="flex-shrink-0 mt-1">
                                        <div
                                            class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center"
                                        >
                                            <span class="text-xs">✓</span>
                                        </div>
                                    </div>
                                    <p class="ml-3 text-gray-300">{{ feature }}</p>
                                </div>
                            </template>
                            
                            <!-- World Owner-specific features -->
                            <template v-else-if="userRole === 'World Owner'">
                                <div
                                    v-for="(feature, index) in worldOwnerFeatures"
                                    :key="index"
                                    class="flex items-start"
                                >
                                    <div class="flex-shrink-0 mt-1">
                                        <div
                                            class="w-5 h-5 rounded-full bg-purple-500 flex items-center justify-center"
                                        >
                                            <span class="text-xs">✓</span>
                                        </div>
                                    </div>
                                    <p class="ml-3 text-gray-300">{{ feature }}</p>
                                </div>
                            </template>
                            
                            <!-- General features for other roles -->
                            <template v-else>
                                <div
                                    v-for="(feature, index) in generalFeatures"
                                    :key="index"
                                    class="flex items-start"
                                >
                                    <div class="flex-shrink-0 mt-1">
                                        <div
                                            class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center"
                                        >
                                            <span class="text-xs">✓</span>
                                        </div>
                                    </div>
                                    <p class="ml-3 text-gray-300">{{ feature }}</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Player Stats (only for players) -->
                    <div
                        v-if="playerStats"
                        class="bg-gray-700/50 p-6 rounded-lg border border-gray-600 md:col-span-2"
                    >
                        <h2
                            class="font-minecraftTen text-xl text-green-400 mb-4"
                        >
                            Your Player Stats
                        </h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-400">{{ playerStats.level }}</div>
                                <div class="text-sm text-gray-400">Level</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-400">{{ playerStats.experience_points }}</div>
                                <div class="text-sm text-gray-400">Experience</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-purple-400">{{ playerStats.quests_completed }}</div>
                                <div class="text-sm text-gray-400">Quests</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tech Stack -->
                    <div
                        class="bg-gray-700/50 p-6 rounded-lg border border-gray-600"
                        :class="{ 'md:col-span-2': !playerStats }"
                    >
                        <h2
                            class="font-minecraftTen text-xl text-green-400 mb-4"
                        >
                            Built With
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div
                                v-for="tech in techStack"
                                :key="tech.name"
                                class="flex flex-col items-center"
                            >
                                <img
                                    :src="tech.logo"
                                    :alt="tech.name"
                                    class="h-12 w-12 mb-2"
                                />
                                <span class="text-gray-300 text-sm">{{
                                    tech.name
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-10 text-center">
                    <Link
                        :href="getDashboardRoute()"
                        class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200"
                    >
                        ← Back to Dashboard
                    </Link>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    user: Object,
    playerStats: {
        type: Object,
        default: null
    },
    userRole: String,
});

const dropdownOpen = ref(false);

// Image paths
const logoText = "/images/CRAFTPANEL.png";
const logoImage = "/images/logo2bgr.png";

// Role-specific features
const playerFeatures = [
    "Join exciting worlds and explore adventures",
    "Complete quests to gain experience and level up",
    "Track your progress with detailed statistics",
    "Connect with friends and build your network",
    "Compete on leaderboards with other players",
    "Unlock achievements and rewards",
];

const worldOwnerFeatures = [
    "Create and manage custom game worlds",
    "Design engaging quests for players",
    "Monitor player progress and engagement",
    "Manage player permissions and world access",
    "Track world statistics and performance",
    "Build communities around your content",
];

const generalFeatures = [
    "Role-based dashboards (Player/World Owner/Admin)",
    "World management system",
    "Quest tracking with progress",
    "Leaderboards and player stats",
    "Friend system with requests",
    "Minecraft-inspired UI",
];

const techStack = [
    { name: "Laravel", logo: "/images/laravelIcon.png" },
    { name: "Vue 3", logo: "/images/vueIcon.png" },
    { name: "Inertia", logo: "/images/inertiaIcon.png" },
    { name: "Tailwind", logo: "/images/tailwindIcon.png" },
];

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

const getDashboardRoute = () => {
    switch (props.userRole) {
        case 'admin':
            return route('admin.dashboard');
        case 'World Owner':
            return route('world-owner.dashboard');
        case 'Player':
        default:
            return route('player.dashboard');
    }
};
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}
::-webkit-scrollbar-track {
    background: #2d3748;
}
::-webkit-scrollbar-thumb {
    background: #4a5568;
    border-radius: 4px;
}
</style>