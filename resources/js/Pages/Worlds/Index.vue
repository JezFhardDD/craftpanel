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
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20 pb-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
      <!-- Header -->
      <section class="mb-10">
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
          <h1 class="text-3xl font-minecraftTen text-white mb-2">
            Available Worlds
          </h1>
          <p class="text-gray-400">
            Join existing worlds or create your own adventure
          </p>
        </div>
      </section>

      <!-- Worlds Grid - Simplified without hover effects -->
      <section class="mb-10">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div 
            v-for="world in worlds" 
            :key="world.id"
            class="bg-gray-800 text-white p-6 rounded-xl border border-gray-700"
          >
            <h3 class="font-minecraftTen text-xl text-white mb-2">{{ world.name }}</h3>
            <p class="text-gray-400 text-sm mb-1">Owner: {{ world.owner_name }}</p>
            <p class="text-gray-400 text-sm mb-4">{{ world.players_count }}/{{ world.max_players }} players</p>
            
            <div class="flex justify-between items-center gap-2">
              <Link 
                :href="route('worlds.show', world.id)" 
                class="flex-1 text-center text-white bg-blue-500 px-3 py-2 rounded text-sm"
              >
                View
              </Link>
              
              <button
                v-if="isJoined(world.id)"
                @click="leaveWorld(world.id)"
                class="flex-1 text-center text-white bg-red-500 px-3 py-2 rounded text-sm"
                :disabled="joining.includes(world.id)"
              >
                <span v-if="joining.includes(world.id)">Leaving...</span>
                <span v-else>Leave</span>
              </button>
              <button
                v-else
                @click="joinWorld(world.id)"
                class="flex-1 text-center text-white bg-green-500 px-3 py-2 rounded text-sm"
                :disabled="joining.includes(world.id)"
              >
                <span v-if="joining.includes(world.id)">Joining...</span>
                <span v-else>Join</span>
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- Back Button -->
      <div class="mt-10 text-center">
        <Link
          href="/player-dashboard"
          class="inline-flex items-center bg-green-600 text-white font-semibold px-6 py-3 rounded-lg"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Dashboard
        </Link>
      </div>
    </main>
  </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    worlds: Array,
    joinedWorldIds: Array,
});

const joining = ref([]);
const logoText = '/images/CRAFTPANEL.png';
const logoImage = '/images/logo2bgr.png';

const isJoined = (worldId) => props.joinedWorldIds.includes(worldId);

const joinWorld = async (worldId) => {
    if (joining.value.includes(worldId)) return;
    joining.value.push(worldId);

    try {
        await router.post(
            route("worlds.join", worldId),
            {},
            {
                onSuccess: () => props.joinedWorldIds.push(worldId),
            }
        );
    } catch (error) {
        console.error("Error joining world:", error);
    } finally {
        joining.value = joining.value.filter((id) => id !== worldId);
    }
};

const leaveWorld = async (worldId) => {
    if (joining.value.includes(worldId)) return;
    joining.value.push(worldId);

    try {
        await router.post(
            route("worlds.leave", worldId),
            {},
            {
                onSuccess: () => {
                    const index = props.joinedWorldIds.indexOf(worldId);
                    if (index !== -1) props.joinedWorldIds.splice(index, 1);
                },
            }
        );
    } catch (error) {
        console.error("Error leaving world:", error);
    } finally {
        joining.value = joining.value.filter((id) => id !== worldId);
    }
};
</script>