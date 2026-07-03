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
    <main class="pt-20 pb-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
      <!-- World Header -->
      <section class="mb-10">
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
          <h1 class="text-3xl font-minecraftTen text-white mb-2">{{ world.name }}</h1>
          <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            <div class="bg-gray-700 p-3 rounded-lg border border-gray-600">
              <p class="text-gray-400 text-sm">Owner</p>
              <p class="text-green-400 font-medium">{{ world.owner.name }}</p>
            </div>
            <div class="bg-gray-700 p-3 rounded-lg border border-gray-600">
              <p class="text-gray-400 text-sm">Status</p>
              <p class="text-green-400 font-medium">{{ world.status }}</p>
            </div>
            <div class="bg-gray-700 p-3 rounded-lg border border-gray-600">
              <p class="text-gray-400 text-sm">Players</p>
              <p class="text-green-400 font-medium">{{ world.players.length }}/{{ world.max_players }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Quests Section -->
      <section class="mb-10">
        <h2 class="font-minecraftTen text-2xl text-white mb-6">Available Quests</h2>
        
        <div v-if="world.quests.length === 0" class="bg-gray-800 p-6 rounded-xl border border-gray-700 text-center text-gray-400">
          No quests available in this world yet.
        </div>
        
        <div v-else class="grid md:grid-cols-2 gap-6">
          <div 
            v-for="quest in world.quests" 
            :key="quest.id"
            class="bg-gray-800 border border-gray-700 rounded-xl p-6"
          >
            <div class="flex justify-between items-start mb-4">
              <h3 class="font-minecraftTen text-lg text-white">{{ quest.title }}</h3>
              <span class="text-green-400 text-sm">{{ quest.reward_xp }} XP</span>
            </div>
            <p class="text-gray-400 text-sm mb-4">{{ quest.description }}</p>
            
            <div class="flex justify-between items-center">
              <button
                v-if="!isQuestJoined(quest)"
                @click="acquireQuest(quest.id)"
                class="text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded text-sm transition-colors"
                :disabled="processingQuest === quest.id"
              >
                <span v-if="processingQuest === quest.id">Joining...</span>
                <span v-else>Join Quest</span>
              </button>
              <button
                v-else
                @click="leaveQuest(quest.id)"
                class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm transition-colors"
                :disabled="processingQuest === quest.id"
              >
                <span v-if="processingQuest === quest.id">Leaving...</span>
                <span v-else>Leave Quest</span>
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- World Actions -->
      <section class="flex flex-col md:flex-row justify-center gap-4 mb-10">
        <button
          v-if="!isMember"
          @click="joinWorld"
          class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg transition-colors"
          :disabled="processingWorld"
        >
          <span v-if="processingWorld">Joining World...</span>
          <span v-else>Join World</span>
        </button>
        <button
          v-else
          @click="leaveWorld"
          class="bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-3 rounded-lg transition-colors"
          :disabled="processingWorld"
        >
          <span v-if="processingWorld">Leaving World...</span>
          <span v-else>Leave World</span>
        </button>
      </section>

      <!-- Back Button -->
      <div class="text-center">
        <Link
          :href="route('worlds.index')"
          class="inline-flex items-center bg-gray-700 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition-all duration-200"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Worlds List
        </Link>
      </div>
    </main>
  </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
import { ref } from 'vue';

const props = defineProps({
    world: Object,
    isMember: Boolean,
    auth: Object,
});

const logoText = '/images/CRAFTPANEL.png';
const logoImage = '/images/logo2bgr.png';

const processingWorld = ref(false);
const processingQuest = ref(null);

const joinedQuestIds = ref(
    props.world.quests
        .filter((q) => q.users.some((u) => u.id === props.auth.id))
        .map((q) => q.id)
);

const isQuestJoined = (quest) => {
    return joinedQuestIds.value.includes(quest.id);
};

const joinWorld = async () => {
    if (processingWorld.value) return;
    processingWorld.value = true;
    
    try {
        await router.post(route('worlds.join', props.world.id));
    } finally {
        processingWorld.value = false;
    }
};

const leaveWorld = async () => {
    if (processingWorld.value) return;
    processingWorld.value = true;
    
    try {
        await router.post(route('worlds.leave', props.world.id));
    } finally {
        processingWorld.value = false;
    }
};

const acquireQuest = async (questId) => {
    if (processingQuest.value) return;
    processingQuest.value = questId;
    
    try {
        await router.post(
            route('worlds.quests.acquire', [props.world.id, questId]),
            {},
            {
                onSuccess: () => {
                    if (!joinedQuestIds.value.includes(questId)) {
                        joinedQuestIds.value.push(questId);
                    }
                },
            }
        );
    } finally {
        processingQuest.value = null;
    }
};

const leaveQuest = async (questId) => {
    if (processingQuest.value) return;
    processingQuest.value = questId;
    
    try {
        await router.post(
            route('worlds.quests.leave', [props.world.id, questId]),
            {},
            {
                onSuccess: () => {
                    joinedQuestIds.value = joinedQuestIds.value.filter(
                        (id) => id !== questId
                    );
                },
            }
        );
    } finally {
        processingQuest.value = null;
    }
};
</script>