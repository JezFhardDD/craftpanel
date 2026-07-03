<template>
    <Head title="Create New World" />

    <AuthenticatedLayout>
        <!-- Full-width background container -->
        <div
            class="font-minecraft min-h-screen bg-gray-900 bg-[url('/images/wallpaper_minecraft_mangroves_1920x1080.png')] bg-cover bg-fixed bg-center"
        >
            <!-- Navigation Header (same as Profile2) -->
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
                    <!-- Page Header -->
                    <div class="flex items-center justify-between mb-8">
                        <h1 class="font-minecraftTen text-3xl text-white">
                            CREATE NEW WORLD
                        </h1>
                        <button
                            @click="goBack"
                            class="text-green-400 hover:text-green-300 flex items-center"
                        >
                            Back
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
                        </button>
                    </div>

                    <!-- Form Card -->
                    <div
                        class="bg-gray-800/90 backdrop-blur-sm p-6 rounded-xl border border-gray-700 shadow-lg"
                    >
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Name Field -->
                            <div>
                                <label class="block text-gray-400 mb-2"
                                    >World Name</label
                                >
                                <input
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Enter world name"
                                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                />
                                <p
                                    class="text-red-500 text-sm mt-1"
                                    v-if="form.errors.name"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <!-- Max Players -->
                            <div>
                                <label class="block text-gray-400 mb-2"
                                    >Max Players</label
                                >
                                <input
                                    v-model.number="form.max_players"
                                    type="number"
                                    min="1"
                                    max="50"
                                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                />
                            </div>

                            <!-- Status Dropdown -->
                            <div>
                                <label class="block text-gray-400 mb-2"
                                    >Status</label
                                >
                                <select
                                    v-model="form.status"
                                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                >
                                    <option value="active">Active</option>
                                    <option value="maintenance">
                                        Maintenance
                                    </option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Background Selector -->
                            <div>
                                <label class="block text-gray-400 mb-2"
                                    >Choose Background</label
                                >
                                <div class="background-grid">
                                    <div
                                        v-for="(
                                            bgPath, bgKey
                                        ) in backgroundOptions"
                                        :key="bgKey"
                                        @click="form.background_image = bgKey"
                                        :class="{
                                            selected:
                                                form.background_image === bgKey,
                                        }"
                                        class="transition-all duration-200 hover:scale-105 cursor-pointer"
                                    >
                                        <img
                                            :src="bgPath"
                                            :alt="bgKey"
                                            class="w-full h-24 object-cover"
                                        />
                                        <span
                                            class="block text-center text-white bg-gray-700 py-1 rounded-b-lg text-xs"
                                            >{{ bgKey }}</span
                                        >
                                    </div>
                                </div>
                                <p class="text-gray-400 text-sm mt-2">
                                    Selected: {{ form.background_image }}
                                </p>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-4 pt-4">
                                <button
                                    type="button"
                                    @click="goBack"
                                    class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors font-medium flex items-center"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium flex items-center"
                                >
                                    <svg
                                        v-if="form.processing"
                                        class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
                                    {{
                                        form.processing
                                            ? "Creating..."
                                            : "Create World"
                                    }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    user: Object,
    backgroundOptions: Object,
});

const form = useForm({
    name: "",
    max_players: 10,
    status: "active",
    background_image: "default",
    owner_id: props.user.id,
});

const submit = () => {
    form.post(route("worlds.store"), {
        onSuccess: () => {
            router.get(route('world-owner.dashboard'));
        },
        onError: (errors) => {
            console.error("Error creating world:", errors);
        },
    });
};

const goBack = () => {
    router.get(route('world-owner.dashboard'));
};

// User dropdown state (same as Profile2)
const dropdownOpen = ref(false);
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

// Image paths (same as Profile2)
const logoText = "/images/CRAFTPANEL.png";
const logoImage = "/images/logo2bgr.png";
</script>

<style scoped>
.background-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
}

.background-grid div {
    border: 2px solid transparent;
    border-radius: 0.5rem;
    overflow: hidden;
    transition: all 0.2s ease;
}

.background-grid div.selected {
    border-color: #4caf50;
    box-shadow: 0 0 0 2px rgba(74, 222, 128, 0.5);
}

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