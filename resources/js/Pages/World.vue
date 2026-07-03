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
                                auth.user.name
                            }}</span>
                            <div
                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-sm font-bold text-white"
                            >
                                {{
                                    world.owner_id === auth.user.id ? "W" : "P"
                                }}
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
            <!-- World Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <div v-if="!editMode">
                        <h1 class="text-3xl font-minecraftTen text-white mb-1">
                            {{ world.name }}
                        </h1>
                        <div class="flex items-center space-x-4">
                            <span
                                class="text-gray-400 text-sm flex items-center"
                            >
                                <span
                                    class="w-2 h-2 rounded-full mr-1"
                                    :class="{
                                        'bg-green-500':
                                            world.status === 'active',
                                        'bg-yellow-500':
                                            world.status === 'maintenance',
                                        'bg-red-500':
                                            world.status === 'inactive',
                                    }"
                                ></span>
                                {{ world.status }}
                            </span>
                            <span class="text-gray-400 text-sm">
                                {{ world.players_count }}/{{
                                    world.max_players
                                }}
                                players
                            </span>
                            <span class="text-gray-400 text-sm">
                                Created: {{ formatDate(world.created_at) }}
                            </span>
                        </div>
                    </div>

                    <!-- Edit Mode Form -->
                    <div v-if="editMode" class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1"
                                >World Name</label
                            >
                            <input
                                v-model="editForm.name"
                                type="text"
                                required
                                class="block w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:border-green-400 focus:ring-green-400"
                            />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-400 mb-1"
                                    >Max Players</label
                                >
                                <input
                                    v-model="editForm.max_players"
                                    type="number"
                                    min="1"
                                    required
                                    class="block w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:border-green-400 focus:ring-green-400"
                                />
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1"
                                    >Status</label
                                >
                                <select
                                    v-model="editForm.status"
                                    class="block w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:border-green-400 focus:ring-green-400"
                                >
                                    <option value="active">Active</option>
                                    <option value="maintenance">
                                        Maintenance
                                    </option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <button
                    @click="toggleEditMode"
                    class="text-green-400 hover:text-green-300 text-sm flex items-center border border-green-400 px-4 py-2 rounded hover:bg-green-400/10 transition-colors"
                >
                    {{ editMode ? "Save Changes" : "Edit World" }}
                </button>
            </div>

            <!-- World Status Card -->
            <div class="mb-8 bg-gray-800 rounded-xl p-6 border border-gray-700">
                <h3 class="font-minecraftTen text-xl text-white mb-4">
                    World Status
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm text-gray-400 mb-2"
                            >Current Status</label
                        >
                        <select
                            v-model="worldStatus"
                            @change="updateWorldStatus"
                            class="block w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:border-green-400 focus:ring-green-400"
                        >
                            <option
                                value="active"
                                class="bg-gray-800 text-white"
                                :selected="worldStatus === 'active'"
                            >
                                Active
                            </option>
                            <option
                                value="maintenance"
                                class="bg-gray-800 text-white"
                                :selected="worldStatus === 'maintenance'"
                            >
                                Maintenance
                            </option>
                            <option
                                value="inactive"
                                class="bg-gray-800 text-white"
                                :selected="worldStatus === 'inactive'"
                            >
                                Inactive
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-2"
                            >Players Online</label
                        >
                        <p class="text-green-400 text-xl font-bold">
                            {{ world.current_players }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-2"
                            >Max Players</label
                        >
                        <p class="text-white text-xl font-bold">
                            {{ world.max_players }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Players Management Card -->
            <div class="mb-8 bg-gray-800 rounded-xl border border-gray-700">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-minecraftTen text-xl text-white">
                            Players ({{ world.players.length }})
                        </h3>
                    </div>

                    <div
                        v-if="world.players.length === 0"
                        class="text-gray-500 text-center py-4 border border-gray-700 rounded-lg"
                    >
                        No players in this world yet.
                    </div>

                    <div v-else class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase tracking-wider"
                                    >
                                        Player
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase tracking-wider"
                                    >
                                        Role
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase tracking-wider"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-minecraftTen text-gray-400 uppercase tracking-wider"
                                    >
                                        Joined
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-minecraftTen text-gray-400 uppercase tracking-wider"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                <tr
                                    v-for="player in world.players"
                                    :key="player.id"
                                    class="hover:bg-gray-700/50"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-bold"
                                            >
                                                {{ player.name.charAt(0) }}
                                            </div>
                                            <div class="ml-4">
                                                <div
                                                    class="text-sm font-medium text-white"
                                                >
                                                    {{ player.name }}
                                                </div>
                                                <div
                                                    class="text-sm text-gray-400"
                                                >
                                                    {{ player.email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                            :class="{
                                                'bg-green-900 text-green-300':
                                                    player.pivot
                                                        .role_in_world ===
                                                    'admin',
                                                'bg-blue-900 text-blue-300':
                                                    player.pivot
                                                        .role_in_world ===
                                                    'moderator',
                                                'bg-gray-700 text-gray-300':
                                                    player.pivot
                                                        .role_in_world ===
                                                    'member',
                                            }"
                                        >
                                            {{ player.pivot.role_in_world }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                            :class="{
                                                'bg-green-900 text-green-300':
                                                    player.is_online,
                                                'bg-gray-700 text-gray-300':
                                                    !player.is_online,
                                            }"
                                        >
                                            {{
                                                player.is_online
                                                    ? "Online"
                                                    : "Offline"
                                            }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-400"
                                    >
                                        {{
                                            formatDate(player.pivot.created_at)
                                        }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2"
                                    >
                                        <button
                                            @click="kickPlayer(player.id)"
                                            class="text-yellow-400 hover:text-yellow-300"
                                        >
                                            Kick
                                        </button>
                                        <button
                                            @click="banPlayer(player.id)"
                                            class="text-red-400 hover:text-red-300"
                                        >
                                            Ban
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quests Management Card -->
            <div class="mb-8 bg-gray-800 rounded-xl border border-gray-700">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-minecraftTen text-xl text-white">
                            Quests ({{ world.quests.length }})
                        </h3>
                        <button
                            @click="showAddQuestModal = true"
                            class="text-green-400 hover:text-green-300 text-sm flex items-center border border-green-400 px-4 py-2 rounded hover:bg-green-400/10 transition-colors"
                        >
                            Add Quest
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
                        </button>
                    </div>

                    <div
                        v-if="world.quests.length === 0"
                        class="text-gray-500 text-center py-4 border border-gray-700 rounded-lg"
                    >
                        No quests created yet.
                    </div>

                    <div v-else class="space-y-4">
                        <div
                            v-for="quest in world.quests"
                            :key="quest.id"
                            class="border border-gray-700 rounded-lg p-4 hover:border-green-400 transition-colors"
                        >
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4
                                        class="text-lg font-medium text-white mb-1"
                                    >
                                        {{ quest.title }}
                                    </h4>
                                    <p class="text-gray-400 text-sm mb-3">
                                        {{ quest.description }}
                                    </p>
                                    <div
                                        class="flex items-center space-x-4 flex-wrap gap-y-2"
                                    >
                                        <span
                                            class="text-sm text-gray-400 flex items-center"
                                        >
                                            <svg
                                                class="w-4 h-4 mr-1 text-yellow-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                                                ></path>
                                            </svg>
                                            {{ quest.reward_xp }} XP
                                        </span>
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                            :class="{
                                                'bg-green-900 text-green-300':
                                                    quest.is_active,
                                                'bg-red-900 text-red-300':
                                                    !quest.is_active,
                                            }"
                                        >
                                            {{
                                                quest.is_active
                                                    ? "Active"
                                                    : "Inactive"
                                            }}
                                        </span>
                                        <span
                                            class="text-sm text-gray-400 flex items-center"
                                        >
                                            <svg
                                                class="w-4 h-4 mr-1 text-blue-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                                ></path>
                                            </svg>
                                            {{ quest.users_count || 0 }} players
                                        </span>
                                    </div>
                                </div>
                                <div class="flex space-x-2 ml-4 flex-shrink-0">
                                    <button
                                        @click="toggleQuestStatus(quest.id)"
                                        class="text-sm px-2 py-1 rounded hover:bg-gray-700"
                                        :class="
                                            quest.is_active
                                                ? 'text-red-400 hover:text-red-300'
                                                : 'text-green-400 hover:text-green-300'
                                        "
                                    >
                                        {{
                                            quest.is_active
                                                ? "Deactivate"
                                                : "Activate"
                                        }}
                                    </button>
                                    <button
                                        @click="deleteQuest(quest.id)"
                                        class="text-red-400 hover:text-red-300 text-sm px-2 py-1 rounded hover:bg-gray-700"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>

                            <!-- Quest Participants -->
                            <div
                                v-if="quest.users && quest.users.length > 0"
                                class="mt-4 pt-3 border-t border-gray-700"
                            >
                                <h5
                                    class="text-sm font-medium text-gray-400 mb-2"
                                >
                                    Players with this quest:
                                </h5>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        v-for="user in quest.users"
                                        :key="user.id"
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                        :class="
                                            user.pivot.is_completed
                                                ? 'bg-green-900 text-green-300'
                                                : 'bg-blue-900 text-blue-300'
                                        "
                                    >
                                        {{ user.name }}
                                        {{
                                            user.pivot.is_completed
                                                ? "(Completed)"
                                                : `(${user.pivot.progress}%)`
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div
                class="bg-gray-800 rounded-xl border-l-4 border-red-500 overflow-hidden"
            >
                <div class="p-6">
                    <h3 class="font-minecraftTen text-xl text-red-400 mb-4">
                        Danger Zone
                    </h3>
                    <p class="text-sm text-red-400 mb-4">
                        Once you delete this world, there is no going back. This
                        will permanently delete the world and all associated
                        data.
                    </p>
                    <button
                        @click="showDeleteModal = true"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Delete World
                    </button>
                </div>
            </div>
        </main>

        <!-- Add Quest Modal -->
        <div
            v-if="showAddQuestModal"
            class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex items-center justify-center z-50"
        >
            <div
                class="bg-gray-800 rounded-xl p-6 w-full max-w-md border border-gray-700"
            >
                <h3 class="font-minecraftTen text-xl text-white mb-4">
                    Add New Quest
                </h3>
                <form @submit.prevent="addQuest">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1"
                                >Title</label
                            >
                            <input
                                v-model="questForm.title"
                                type="text"
                                required
                                class="block w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:border-green-400 focus:ring-green-400"
                            />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1"
                                >Description</label
                            >
                            <textarea
                                v-model="questForm.description"
                                rows="3"
                                required
                                class="block w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:border-green-400 focus:ring-green-400"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1"
                                >Reward XP</label
                            >
                            <input
                                v-model="questForm.reward_xp"
                                type="number"
                                min="1"
                                required
                                class="block w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:border-green-400 focus:ring-green-400"
                            />
                        </div>
                        <div class="flex items-center">
                            <input
                                v-model="questForm.is_active"
                                type="checkbox"
                                class="h-4 w-4 text-green-400 focus:ring-green-400 border-gray-600 rounded bg-gray-700"
                            />
                            <label class="ml-2 block text-sm text-gray-300"
                                >Make quest active immediately</label
                            >
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button
                            type="button"
                            @click="showAddQuestModal = false"
                            class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 hover:bg-gray-600 rounded-md border border-gray-600"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md"
                        >
                            Add Quest
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex items-center justify-center z-50"
        >
            <div
                class="bg-gray-800 rounded-xl p-6 w-full max-w-md border border-gray-700"
            >
                <h3 class="font-minecraftTen text-xl text-red-400 mb-4">
                    Delete World
                </h3>
                <p class="text-sm text-gray-400 mb-4">
                    Are you sure you want to delete "{{ world.name }}"? This
                    action cannot be undone and will permanently delete all
                    world data, including quests and player progress.
                </p>
                <div class="flex justify-end space-x-3">
                    <button
                        @click="showDeleteModal = false"
                        class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 hover:bg-gray-600 rounded-md border border-gray-600"
                    >
                        Cancel
                    </button>
                    <button
                        @click="deleteWorld"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md"
                    >
                        Delete World
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-10 text-center">
            <Link
                href="/dashboard"
                class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-all duration-200"
            >
                ← Go Back to Dashboard
            </Link>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, reactive } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";

// Image paths
const logoText = "/images/CRAFTPANEL.png";
const logoImage = "/images/logo2bgr.png";

const props = defineProps({
    world: Object,
    auth: Object,
});

// Reactive data
const dropdownOpen = ref(false);
const editMode = ref(false);
const worldStatus = ref(props.world.status);
const showAddQuestModal = ref(false);
const showDeleteModal = ref(false);

const editForm = useForm({
    name: props.world.name,
    max_players: props.world.max_players,
    status: props.world.status,
});

const questForm = reactive({
    title: "",
    description: "",
    reward_xp: 100,
    is_active: true,
});

// Methods
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

const toggleEditMode = async () => {
    if (editMode.value) {
        await editForm.patch(route("worlds.update", props.world.id), {
            preserveScroll: true,
            onSuccess: () => {
                editMode.value = false;
                worldStatus.value = editForm.status;
            },
            onError: (errors) => {
                console.error("Error updating world:", errors);
            },
        });
    } else {
        editMode.value = true;
    }
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

const updateWorldStatus = () => {
    router.patch(
        route("worlds.update-status", props.world.id),
        {
            status: worldStatus.value,
        },
        {
            preserveScroll: true,
        }
    );
};

const kickPlayer = (playerId) => {
    if (confirm("Are you sure you want to kick this player?")) {
        router.post(
            route("worlds.players.kick", [props.world.id, playerId]),
            {},
            {
                preserveScroll: true,
            }
        );
    }
};

const banPlayer = (playerId) => {
    if (confirm("Are you sure you want to ban this player?")) {
        router.post(
            route("worlds.players.ban", [props.world.id, playerId]),
            {},
            {
                preserveScroll: true,
            }
        );
    }
};

const addQuest = () => {
    router.post(route("worlds.quests.store", props.world.id), questForm, {
        preserveScroll: true,
        onSuccess: () => {
            showAddQuestModal.value = false;
            // Reset form
            Object.assign(questForm, {
                title: "",
                description: "",
                reward_xp: 100,
                is_active: true,
            });
        },
    });
};

const toggleQuestStatus = (questId) => {
    const quest = props.world.quests.find((q) => q.id === questId);
    router.patch(
        route("worlds.quests.update", [props.world.id, questId]),
        {
            is_active: !quest.is_active,
        },
        {
            preserveScroll: true,
        }
    );
};

const deleteQuest = (questId) => {
    if (confirm("Are you sure you want to delete this quest?")) {
        router.delete(
            route("worlds.quests.destroy", [props.world.id, questId]),
            {
                preserveScroll: true,
            }
        );
    }
};

const deleteWorld = () => {
    router.delete(route("worlds.destroy", props.world.id), {
        onSuccess: () => {
            router.visit(route("world-owner.dashboard"));
        },
    });
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
