<template>
    <Head title="World Owner Profile" />

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
                                    WO
                                </div>
                            </button>

                            <div
                                v-if="dropdownOpen"
                                class="absolute right-0 mt-2 w-56 bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-700"
                            >
                                <Link
                                    :href="route('world-owner.profile')"
                                    class="block px-4 py-2 text-white hover:bg-gray-700"
                                    >Profile</Link
                                >
                                <Link
                                    :href="route('world-owner.dashboard')"
                                    class="block px-4 py-2 text-white hover:bg-gray-700"
                                    >Dashboard</Link
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="pt-20 pb-10 min-h-screen">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Profile Header -->
                    <div class="flex items-center justify-between mb-8">
                        <h1 class="font-minecraftTen text-3xl text-white">
                            WORLD OWNER PROFILE
                        </h1>
                        <Link
                            :href="route('world-owner.dashboard')"
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
                                />
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
                                BASIC INFO
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-400">Username:</p>
                                    <p class="text-white font-bold">
                                        {{ user.name }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-400">Role:</p>
                                    <p class="text-white">World Owner</p>
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
                            </div>
                            <!-- Edit Profile Button -->
                            <div class="mt-4 flex justify-end">
                                <Link
                                    :href="route('world-owner.profile.edit')"
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg transition-colors text-sm"
                                >
                                    <svg
                                        class="w-4 h-4 mr-2"
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

                        <!-- Worlds Management Card -->
                        <div
                            class="bg-gray-800/90 backdrop-blur-sm p-6 rounded-xl border border-gray-700 shadow-lg"
                        >
                            <h2
                                class="font-minecraftTen text-xl text-white mb-4 border-b border-gray-700 pb-2"
                            >
                                WORLDS MANAGEMENT
                            </h2>

                            <!-- Stats Grid -->
                            <div
                                class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6"
                            >
                                <!-- Worlds Owned -->
                                <div
                                    class="bg-gray-700/50 p-4 rounded-lg border border-gray-600"
                                >
                                    <p class="text-gray-400">Worlds Owned</p>
                                    <p
                                        class="text-green-400 text-2xl font-bold"
                                    >
                                        {{ worlds.length }}
                                    </p>
                                </div>

                                <!-- Total Players -->
                                <div
                                    class="bg-gray-700/50 p-4 rounded-lg border border-gray-600"
                                >
                                    <p class="text-gray-400">Total Players</p>
                                    <p
                                        class="text-green-400 text-2xl font-bold"
                                    >
                                        {{ totalPlayersCount }}
                                    </p>
                                </div>

                                <!-- Active Players -->
                                <div
                                    class="bg-gray-700/50 p-4 rounded-lg border border-gray-600"
                                >
                                    <p class="text-gray-400">Active Players</p>
                                    <p
                                        class="text-green-400 text-2xl font-bold"
                                    >
                                        {{ activePlayersCount }}
                                    </p>
                                </div>
                            </div>

                            <!-- Worlds List -->
                            <div>
                                <h4
                                    class="text-white font-medium mb-2 flex items-center"
                                >
                                    My Worlds
                                    <button
                                        @click="toggleWorlds"
                                        class="text-green-400 text-sm ml-2 hover:text-green-300 transition-colors"
                                    >
                                        {{ showWorlds ? "[Hide]" : "[View]" }}
                                    </button>
                                </h4>

                                <div v-if="showWorlds" class="mt-4">
                                    <div
                                        v-if="worlds.length > 0"
                                        class="grid grid-cols-1 md:grid-cols-2 gap-4"
                                    >
                                        <div
                                            v-for="world in worlds"
                                            :key="world.id"
                                            class="bg-gray-700/50 rounded-lg border border-gray-600 overflow-hidden"
                                        >
                                            <!-- World Background -->
                                            <div
                                                class="h-32 bg-cover bg-center"
                                                :style="{
                                                    backgroundImage: `url('${
                                                        backgroundOptions[
                                                            world
                                                                .background_image
                                                        ] ||
                                                        backgroundOptions[
                                                            'default'
                                                        ]
                                                    }')`,
                                                }"
                                            ></div>

                                            <!-- World Info -->
                                            <div class="p-4">
                                                <div
                                                    class="flex justify-between items-start"
                                                >
                                                    <div>
                                                        <h3
                                                            class="text-white font-medium"
                                                        >
                                                            {{ world.name }}
                                                        </h3>
                                                        <p
                                                            class="text-gray-400 text-sm"
                                                        >
                                                            Created
                                                            {{
                                                                formatDate(
                                                                    world.created_at
                                                                )
                                                            }}
                                                        </p>
                                                    </div>
                                                    <span
                                                        :class="{
                                                            'bg-green-500/20 text-green-400':
                                                                world.status ===
                                                                'active',
                                                            'bg-yellow-500/20 text-yellow-400':
                                                                world.status ===
                                                                'maintenance',
                                                            'bg-red-500/20 text-red-400':
                                                                world.status ===
                                                                'inactive',
                                                        }"
                                                        class="px-2 py-1 rounded text-xs font-medium"
                                                    >
                                                        {{
                                                            world.status.toUpperCase()
                                                        }}
                                                    </span>
                                                </div>

                                                <div
                                                    class="mt-3 flex justify-between items-center"
                                                >
                                                    <p class="text-white">
                                                        <span
                                                            class="text-green-400"
                                                            >{{
                                                                world.players_count ||
                                                                0
                                                            }}</span
                                                        >/{{
                                                            world.max_players
                                                        }}
                                                        players
                                                    </p>

                                                    <div class="flex space-x-2">
                                                        <Link
                                                            :href="
                                                                route(
                                                                    'worlds.show',
                                                                    world.id
                                                                )
                                                            "
                                                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm transition-colors"
                                                        >
                                                            View
                                                        </Link>
                                                        <Link
                                                            :href="
                                                                route(
                                                                    'worlds.edit',
                                                                    world.id
                                                                )
                                                            "
                                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm transition-colors"
                                                        >
                                                            Manage
                                                        </Link>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="text-center py-8">
                                        <div class="text-gray-400 mb-4">
                                            <svg
                                                class="w-16 h-16 mx-auto mb-4 opacity-50"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7zm0 0V5a2 2 0 012-2h6l2 2h6a2 2 0 012 2v2M7 13h10l-4-8H7l4 8z"
                                                />
                                            </svg>
                                            <p class="text-lg">
                                                No worlds created yet
                                            </p>
                                        </div>
                                        <Link
                                            :href="route('worlds.create')"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
                                        >
                                            Create Your First World
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Create World Button -->
                        <div class="flex justify-center">
                            <Link
                                :href="route('worlds.create')"
                                class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium"
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
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                    />
                                </svg>
                                Create New World
                            </Link>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    user: Object,
    worlds: {
        type: Array,
        default: () => [],
    },
});

// Calculate player counts
const totalPlayersCount = computed(() => {
    return props.worlds.reduce(
        (total, world) => total + (world.players_count || 0),
        0
    );
});

const activePlayersCount = computed(() => {
    // You'll need to implement this based on your active player logic
    return props.worlds.reduce(
        (total, world) => total + (world.active_players_count || 0),
        0
    );
});

const showWorlds = ref(false);
const dropdownOpen = ref(false);

const toggleWorlds = () => {
    showWorlds.value = !showWorlds.value;
};

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

// Background options - should match your World model
const backgroundOptions = {
    default: "/images/wallpaper_minecraft_pc_bundle_1920x1080.png",
    pale: "/images/Minecraft_TheGardenAwakens_DotNet_1920x1080.png",
    trial: "/images/Minecraft_Trails&Tales_.Net_800x450.png",
    boat: "/images/wallpaper_minecraft_adventure_1920x1080.png",
    bees: "/images/wallpaper_minecraft_buzzybees_1920x1080.png",
    jungle: "/images/wallpaper_minecraft_cats_pandas_1920x1080.png",
    caves: "/images/wallpaper_minecraft_caves_cliffs(part2)_1920x1080.png",
    island: "/images/wallpaper_minecraft_island_1920x1080.png",
    mangroves: "/images/wallpaper_minecraft_mangroves_1920x1080.png",
    mineshaft: "/images/wallpaper_minecraft_mineshaft_1920x1080.png",
    nether: "/images/wallpaper_minecraft_nether_update_1920x1080.png",
    ocean: "/images/wallpaper_minecraft_ocean_monument_1920x1080.png",
    aqua: "/images/wallpaper_minecraft_update_aquatic_1920x1080.png",
    village: "/images/wallpaper_minecraft_village_pillage_1920x1080.png",
    warden: "/images/wallpaper_minecraft_warden_1920x1080.png",
    wild: "/images/wallpaper_minecraft_wild_update_1920x1080.png",
};

// Format date for display
const formatDate = (dateString) => {
    const options = { year: "numeric", month: "short", day: "numeric" };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

// Image paths
const logoText = "/images/CRAFTPANEL.png";
const logoImage = "/images/logo2bgr.png";
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

/* Ensure full height for background */
html,
body {
    height: 100%;
    margin: 0;
}
</style>
