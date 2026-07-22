<!-- resources/js/Pages/WorldOwnerDashboard.vue -->
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
                                {{ ownedWorldsCount }}
                            </div>
                        </button>

                        <div
                            v-if="dropdownOpen"
                            class="absolute right-0 mt-2 w-56 bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-700"
                        >
                            <Link
                                :href="route('world-owner.profile')"
                                class="block px-4 py-2 text-white hover:bg-gray-700"
                            >
                                Profile
                            </Link>
                            <Link
                                :href="route('about')"
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
        <main class="pt-20 pb-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <!-- Welcome Banner -->
            <section class="mb-10">
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h1 class="text-3xl font-minecraftTen text-white mb-2">
                        Welcome back, {{ user.name }}!
                    </h1>
                    <p class="text-gray-400">
                        Ready to manage your worlds and players?
                    </p>

                    <!-- Stats Bar - Shows owned worlds count -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div
                            class="bg-gray-700 p-4 rounded-lg border border-gray-600"
                        >
                            <p class="text-gray-400 text-sm">Worlds Owned</p>
                            <p class="text-green-400 text-2xl font-bold">
                                {{ ownedWorldsCount }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Worlds You Own Section -->
            <section class="mb-10">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-minecraftTen text-2xl text-white">
                        Your Worlds
                    </h2>
                    <Link
                        :href="route('worlds.create')"
                        class="text-green-400 hover:text-green-300 text-sm flex items-center"
                    >
                        Create New World
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
                                d="M12 4v16m8-8H4"
                            ></path>
                        </svg>
                    </Link>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Clickable World Cards -->
                    <Link
                        v-for="world in ownedWorlds"
                        :key="world.id"
                        :href="route('worlds.manage', world.id)"
                        class="relative overflow-hidden bg-gray-800 text-white p-6 rounded-xl group transition-all duration-300 shadow-md border border-gray-700 hover:border-green-400 hover:shadow-lg cursor-pointer block"
                    >
                        <div
                            class="absolute inset-0 bg-cover bg-center opacity-10 group-hover:opacity-30 transition-all duration-500"
                            :style="{
                                backgroundImage: `url(${worldBackgrounds[world.background_image] || worldBackgrounds.default})`,
                            }"
                        ></div>

                        <!-- World Content -->
                        <div class="relative z-10">
                            <h3
                                class="font-minecraftTen text-xl text-white mb-2 group-hover:text-green-400 transition-colors"
                            >
                                {{ world.name }}
                            </h3>
                            <p class="text-gray-400 text-sm mb-1">
                                Status:
                                <span
                                    :class="{
                                        'text-green-400':
                                            world.status === 'active',
                                        'text-yellow-400':
                                            world.status === 'maintenance',
                                        'text-red-400':
                                            world.status === 'inactive',
                                    }"
                                >
                                    {{ world.status }}
                                </span>
                            </p>
                            <p class="text-gray-400 text-sm mb-4">
                                {{ world.players_count }}/{{
                                    world.max_players
                                }}
                                players
                            </p>

                            <!-- Action Buttons -->
                            <div
                                class="flex justify-between items-center"
                                @click.stop
                            >
                                <Link
                                    :href="route('worlds.manage', world.id)"
                                    class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-sm transition-colors z-20 relative"
                                    @click.stop
                                >
                                    Manage
                                </Link>
                                <Link
                                    :href="route('worlds.edit', world.id)"
                                    class="text-white bg-gray-600 hover:bg-gray-500 px-3 py-1 rounded text-sm transition-colors z-20 relative"
                                    @click.stop
                                >
                                    Edit
                                </Link>
                            </div>

                            <!-- Click indicator -->
                            <div
                                class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity"
                            >
                                <svg
                                    class="w-5 h-5 text-green-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </Link>

                    <!-- Create New World Card (shown if no worlds owned) -->
                    <div
                        v-if="ownedWorlds.length === 0"
                        class="bg-gray-800 border-2 border-dashed border-gray-600 rounded-xl p-6 flex items-center justify-center hover:border-green-400 transition-colors cursor-pointer"
                    >
                        <Link
                            :href="route('worlds.create')"
                            class="text-center"
                        >
                            <div class="text-green-400 text-3xl mb-2">+</div>
                            <p class="text-white font-medium">
                                Create Your First World
                            </p>
                        </Link>
                    </div>
                </div>
            </section>

            <!-- Other Worlds Section -->
            <section class="mb-10">
                <h2 class="font-minecraftTen text-2xl text-white mb-6">
                    Other Worlds
                </h2>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="world in otherWorlds"
                        :key="world.id"
                        class="relative overflow-hidden bg-gray-800 text-white p-6 rounded-xl group transition-all duration-300 shadow-md border border-gray-700"
                    >
                        <div
                            class="absolute inset-0 bg-cover bg-center opacity-10 group-hover:opacity-30 transition-all duration-500"
                            :style="{
                                backgroundImage: `url(${worldBackgrounds[world.background_image] || worldBackgrounds.default})`,
                            }"
                        ></div>
                        <h3 class="font-minecraftTen text-xl text-white mb-2">
                            {{ world.name }}
                        </h3>
                        <p class="text-gray-400 text-sm mb-1">
                            Owner: {{ world.owner.name }}
                        </p>
                        <p class="text-gray-400 text-sm mb-4">
                            {{ world.players_count }}/{{ world.max_players }}
                            players
                        </p>
                        <Link
                            :href="route('worlds.show', world.id)"
                            class="text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded text-sm transition-colors"
                        >
                            View
                        </Link>
                    </div>
                </div>
            </section>

            <!-- Leaderboards Section (copied from PlayerDashboard) -->
            <section>
                <h2 class="font-minecraftTen text-2xl text-white mb-6">
                    Leaderboards
                </h2>

                <div
                    class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden"
                >
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th
                                    class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase"
                                >
                                    Rank
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase"
                                >
                                    Player
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase"
                                >
                                    Level
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase"
                                >
                                    XP
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase"
                                >
                                    Kills
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(player, index) in leaderboard"
                                :key="player.id"
                                class="border-b border-gray-700 hover:bg-gray-700/50"
                                :class="{
                                    'bg-gray-700/30': player.id === user.id,
                                }"
                            >
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white"
                                >
                                    #{{ index + 1 }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-white"
                                >
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 rounded-full bg-green-500 flex items-center justify-center mr-3"
                                        >
                                            <span class="text-xs">{{
                                                player.level
                                            }}</span>
                                        </div>
                                        <div>
                                            {{ player.name }}
                                            <span
                                                v-if="player.id === user.id"
                                                class="text-green-400 text-xs ml-2"
                                                >(You)</span
                                            >
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-white"
                                >
                                    {{ player.level }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-white"
                                >
                                    {{ player.xp_points }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-white"
                                >
                                    {{ player.kills_pvp + player.kills_pve }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    user: Object,
    ownedWorlds: Array,
    otherWorlds: Array,
    leaderboard: Array,
});

const dropdownOpen = ref(false);
const worldBackgrounds = {
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

// Image paths
const logoText = "/images/CRAFTPANEL.png";
const logoImage = "/images/logo2bgr.png";

// Computed properties
const ownedWorldsCount = computed(() => props.ownedWorlds.length);

// Methods
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
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
