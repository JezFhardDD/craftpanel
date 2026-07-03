<template>
  <div class="overflow-auto font-minecraft min-h-screen bg-gray-900">
    <!-- Navigation Header -->
    <nav class="fixed top-0 w-full bg-gray-900/95 backdrop-blur-sm z-50 border-b border-gray-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex items-center space-x-3">
            <img :src="logoImage" alt="CRAFTPANEL Logo" class="h-10 w-10" />
            <img :src="logoText" alt="CRAFTPANEL" class="h-15 w-60 mx-auto" />
          </div>

          <!-- User Dropdown -->
          <div class="relative">
    <button @click="toggleDropdown" class="flex items-center space-x-2 focus:outline-none">
      <span class="text-white font-medium">{{ user.name }}</span>
      <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-sm font-bold text-white">
        {{ playerStats.level }}
      </div>
    </button>

    <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-56 bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-700">
      <Link href="/profile" class="block px-4 py-2 text-white hover:bg-gray-700">Profile</Link>
      <Link href="/friends" class="block px-4 py-2 text-white hover:bg-gray-700">Friends</Link>
      <Link href="/friend-requests" class="block px-4 py-2 text-white hover:bg-gray-700">Friend Requests</Link>
      <Link :href="route('about')" class="block px-4 py-2 text-white hover:bg-gray-700">About</Link>
      <Link :href="route('logout')" method="post" as="button" class="w-full text-left px-4 py-2 text-white hover:bg-red-600">
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
            Ready to continue your adventure?
          </p>
          
          <!-- Stats Bar -->
          <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gray-700 p-4 rounded-lg border border-gray-600">
              <p class="text-gray-400 text-sm">Level</p>
              <p class="text-green-400 text-2xl font-bold">{{ playerStats.level }}</p>
            </div>
            <div class="bg-gray-700 p-4 rounded-lg border border-gray-600">
              <p class="text-gray-400 text-sm">XP</p>
              <p class="text-green-400 text-2xl font-bold">{{ playerStats.xp_points }}</p>
            </div>
            <div class="bg-gray-700 p-4 rounded-lg border border-gray-600">
              <p class="text-gray-400 text-sm">Friends</p>
              <p class="text-green-400 text-2xl font-bold">{{ playerStats.friends_count }}</p>
            </div>
            <div class="bg-gray-700 p-4 rounded-lg border border-gray-600">
              <p class="text-gray-400 text-sm">Kills</p>
              <p class="text-green-400 text-2xl font-bold">{{ playerStats.kills_pvp + playerStats.kills_pve }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Worlds Section -->
      <section class="mb-10">
        <div class="flex justify-between items-center mb-6">
          <h2 class="font-minecraftTen text-2xl text-white">Your Worlds</h2>
          <Link 
            :href="route('worlds.index')" 
            class="text-green-400 hover:text-green-300 text-sm flex items-center"
          >
            View All Worlds
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </Link>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div 
            v-for="world in joinedWorlds" 
            :key="world.id"
            class="relative overflow-hidden bg-gray-800 text-white p-6 rounded-xl group transition-all duration-300 shadow-md border border-gray-700"
          >
            <div class="absolute inset-0 bg-cover bg-center opacity-10 group-hover:opacity-30 transition-all duration-500" 
                 :style="{ backgroundImage: `url(${worldBackgrounds[world.id % worldBackgrounds.length]})` }"></div>
            <h3 class="font-minecraftTen text-xl text-white mb-2">{{ world.name }}</h3>
            <p class="text-gray-400 text-sm mb-4">Owner: {{ world.owner.name }}</p>
            <div class="flex justify-between items-center">
              <span class="text-green-400 text-sm">{{ world.players_count }}/{{ world.max_players }} players</span>
              <Link 
                :href="route('worlds.show', world.id)" 
                class="text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded text-sm transition-colors"
              >
                Enter
              </Link>
            </div>
          </div>
          
          <!-- Join New World Card -->
          <div class="bg-gray-800 border-2 border-dashed border-gray-600 rounded-xl p-6 flex items-center justify-center hover:border-green-400 transition-colors cursor-pointer">
            <Link :href="route('worlds.index')" class="text-center">
              <div class="text-green-400 text-3xl mb-2">+</div>
              <p class="text-white font-medium">Join a New World</p>
            </Link>
          </div>
        </div>
      </section>

      <!-- Quests Section -->
      <section class="mb-10">
        <h2 class="font-minecraftTen text-2xl text-white mb-6">Your Active Quests</h2>
        
        <div class="grid md:grid-cols-2 gap-6">
          <div 
            v-for="quest in activeQuests" 
            :key="quest.id"
            class="bg-gray-800 border border-gray-700 rounded-xl p-6"
          >
            <div class="flex justify-between items-start mb-4">
              <h3 class="font-minecraftTen text-lg text-white">{{ quest.title }}</h3>
              <span class="text-green-400 text-sm">{{ quest.reward_xp }} XP</span>
            </div>
            <p class="text-gray-400 text-sm mb-4">{{ quest.description }}</p>
            <div class="w-full bg-gray-700 rounded-full h-2.5">
              <div 
                class="bg-green-500 h-2.5 rounded-full" 
                :style="{ width: `${quest.progress}%` }"
              ></div>
            </div>
            <p class="text-right text-gray-400 text-xs mt-2">{{ quest.progress }}% complete</p>
          </div>
        </div>
      </section>

      <!-- Leaderboards Section -->
      <section>
        <h2 class="font-minecraftTen text-2xl text-white mb-6">Leaderboards</h2>
        
        <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-700">
                <th class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase">Rank</th>
                <th class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase">Player</th>
                <th class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase">Level</th>
                <th class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase">XP</th>
                <th class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase">Kills</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="(player, index) in leaderboard" 
                :key="player.id"
                class="border-b border-gray-700 hover:bg-gray-700/50"
                :class="{ 'bg-gray-700/30': player.id === user.id }"
              >
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                  #{{ index + 1 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-500 flex items-center justify-center mr-3">
                      <span class="text-xs">{{ player.level }}</span>
                    </div>
                    <div>
                      {{ player.name }}
                      <span v-if="player.id === user.id" class="text-green-400 text-xs ml-2">(You)</span>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                  {{ player.level }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                  {{ player.xp_points }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
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
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

// Props from Laravel
const props = defineProps({
  user: Object,
  playerStats: Object,
  joinedWorlds: Array,
  activeQuests: Array,
  leaderboard: Array,
});

// Local state
const dropdownOpen = ref(false);
const worldBackgrounds = [
  '/images/Minecraft_Trails&Tales_.Net_800x450.png',
  '/images/wallpaper_minecraft_adventure_1920x1080.png',
  '/images/wallpaper_minecraft_buzzybees_1920x1080.png',
  '/images/wallpaper_minecraft_cats_pandas_1920x1080.png',
];

// Image paths (same as Home.vue)
const logoText = '/images/CRAFTPANEL.png';
const logoImage = '/images/logo2bgr.png';

// Methods
const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value;
};

// Close dropdown when clicking outside
onMounted(() => {
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
      dropdownOpen.value = false;
    }
  });
});
</script>

<style scoped>
/* Add any custom styles here */
</style>