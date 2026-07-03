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

                    <!-- Login Button -->
                    <Link :href="route('login')">
                        <button
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200"
                        >
                            Login
                        </button>
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center justify-center">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img
                    :src="heroBgImage"
                    alt="Minecraft Background"
                    class="w-full h-full object-cover opacity-30"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-b from-gray-900/50 to-gray-900/80"
                ></div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 text-center max-w-4xl mx-auto px-4">
                <img
                    :src="logoImage"
                    alt="CRAFTPANEL"
                    class="h-24 w-24 mx-auto mt-20"
                />
                <h1 class="text-6xl md:text-7xl font-bold mb-6">
                    <img
                        :src="logoText"
                        alt="CRAFTPANEL"
                        class="h-20 w-100 mx-auto mb-8"
                    />
                </h1>
                <p
                    class="font-minecraftTen text-xl md:text-3xl text-gray-300 mb-4 font-medium"
                >
                    Build Your World Together
                </p>
                <p
                    class="font-minecraft text-lg text-gray-400 mb-12 max-w-2xl mx-auto leading-relaxed"
                >
                    The ultimate Minecraft server management platform. Create
                    worlds, manage players, track progress, and build
                    communities with powerful tools designed for server owners
                    and players.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Link :href="route('login')"><button
                        
                        class="font-minecraftTen bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg text-lg transition-all duration-200 transform hover:scale-105"
                    >
                        Start Playing
                    </button></Link>
                    <button
                        @click="scrollToSection('features')"
                        class="font-minecraftTen border-2 border-gray-600 hover:border-green-400 text-white px-8 py-4 rounded-lg text-lg transition-all duration-200 hover:bg-gray-800"
                    >
                        Learn More
                    </button>
                </div>
            </div>

            <!-- Scroll Indicator -->
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="font-minecraftTen text-4xl text-white mb-4">
                        Powerful Features
                    </h2>
                    <p class="font-minecraft text-xl text-gray-400">
                        Everything you need to manage your Minecraft community
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        v-fade-in-on-scroll
                        class="fade-left relative overflow-hidden bg-gray-800 text-white p-6 rounded-xl group transition-all duration-300 shadow-md"
                    >
                        <div
                            class="absolute inset-0 bg-cover bg-center opacity-10 group-hover:opacity-30 group-hover:scale-105 transition-all duration-500 ease-in-out"
                            style="
                                background-image: url('/images/Minecraft_Trails&Tales_.Net_800x450.png');
                            "
                        ></div>
                        <div class="text-green-400 text-3xl mb-4">🌍</div>
                        <h3 class="font-minecraftTen text-xl text-white mb-3">
                            World Management
                        </h3>
                        <p class="font-minecraft text-gray-300">
                            Create and manage multiple worlds with custom
                            settings, player limits, and permissions.
                        </p>
                    </div>

                    <div
                        v-fade-in-on-scroll
                        class="fade-down relative overflow-hidden bg-gray-800 text-white p-6 rounded-xl group transition-all duration-300 shadow-md"
                    >
                        <div
                            class="absolute inset-0 bg-cover bg-center opacity-10 group-hover:opacity-30 group-hover:scale-105 transition-all duration-500 ease-in-out"
                            style="
                                background-image: url('/images/wallpaper_minecraft_adventure_1920x1080.png');
                            "
                        ></div>
                        <div class="text-green-400 text-3xl mb-4">⚔️</div>
                        <h3 class="font-minecraftTen text-xl text-white mb-3">
                            Quest System
                        </h3>
                        <p class="font-minecraft text-gray-300">
                            Design engaging quests and challenges to keep your
                            players motivated and entertained.
                        </p>
                    </div>

                    <div
                        v-fade-in-on-scroll
                        class="fade-right relative overflow-hidden bg-gray-800 text-white p-6 rounded-xl group transition-all duration-300 shadow-md"
                    >
                        <div
                            class="absolute inset-0 bg-cover bg-center opacity-10 group-hover:opacity-30 group-hover:scale-105 transition-all duration-500 ease-in-out"
                            style="
                                background-image: url('/images/wallpaper_minecraft_buzzybees_1920x1080.png');
                            "
                        ></div>
                        <div class="text-green-400 text-3xl mb-4">🏆</div>
                        <h3 class="font-minecraftTen text-xl text-white mb-3">
                            Leaderboards
                        </h3>
                        <p class="font-minecraft text-gray-300">
                            Track player progress and create competitive
                            rankings to drive engagement.
                        </p>
                    </div>

                    <div
                        v-fade-in-on-scroll
                        class="fade-left relative overflow-hidden bg-gray-800 text-white p-6 rounded-xl group transition-all duration-300 shadow-md"
                    >
                        <div
                            class="absolute inset-0 bg-cover bg-center opacity-10 group-hover:opacity-30 group-hover:scale-105 transition-all duration-500 ease-in-out"
                            style="
                                background-image: url('/images/wallpaper_minecraft_cats_pandas_1920x1080.png');
                            "
                        ></div>
                        <div class="text-green-400 text-3xl mb-4">👥</div>
                        <h3 class="font-minecraftTen text-xl text-white mb-3">
                            Player Management
                        </h3>
                        <p class="font-minecraft text-gray-300">
                            Efficiently manage players, permissions, and
                            community interactions.
                        </p>
                    </div>

                    <div
                        v-fade-in-on-scroll
                        class="fade-up relative overflow-hidden bg-gray-800 text-white p-6 rounded-xl group transition-all duration-300 shadow-md"
                    >
                        <div
                            class="absolute inset-0 bg-cover bg-center opacity-10 group-hover:opacity-30 group-hover:scale-105 transition-all duration-500 ease-in-out"
                            style="
                                background-image: url('/images/wallpaper_minecraft_caves_cliffs(part2)_1920x1080.png');
                            "
                        ></div>
                        <div class="text-green-400 text-3xl mb-4">📊</div>
                        <h3 class="font-minecraftTen text-xl text-white mb-3">
                            Analytics
                        </h3>
                        <p class="font-minecraft text-gray-300">
                            Get insights into player activity, world usage, and
                            community growth.
                        </p>
                    </div>

                    <div
                        v-fade-in-on-scroll
                        class="fade-right relative overflow-hidden bg-gray-800 text-white p-6 rounded-xl group transition-all duration-300 shadow-md"
                    >
                        <div
                            class="absolute inset-0 bg-cover bg-center opacity-10 group-hover:opacity-30 group-hover:scale-105 transition-all duration-500 ease-in-out"
                            style="
                                background-image: url('/images/wallpaper_minecraft_island_1920x1080.png');
                            "
                        ></div>
                        <div class="text-green-400 text-3xl mb-4">🤝</div>
                        <h3 class="font-minecraftTen text-xl text-white mb-3">
                            Social Features
                        </h3>
                        <p class="font-minecraft text-gray-300">
                            Friend systems, profiles, and community tools to
                            connect players.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section id="team" class="py-20 bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="font-minecraftTen text-4xl text-white mb-4">
                        Meet Our Team
                    </h2>
                    <p class="font-minecraft text-xl text-gray-400">
                        The developers behind CRAFTPANEL
                    </p>
                </div>

                <div
                    class="flex flex-col md:flex-row gap-8 justify-center items-center"
                >
                    <div
                        class="bg-gray-800 p-8 rounded-xl text-center max-w-sm"
                    >
                        <img
                            :src="jezreelImage"
                            alt="Jezreel Villanueva"
                            class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-green-400 object-cover"
                            @error="handleImageError"
                        />
                        <h3 class="text-2xl font-semibold text-white mb-2">
                            Jezreel Villanueva
                        </h3>
                        <p class="text-green-400 font-medium mb-3">
                            Full Stack Developer
                        </p>
                        <p class="text-gray-400">
                            Database Manager & Backend Architect
                        </p>
                    </div>

                    <div
                        class="bg-gray-800 p-8 rounded-xl text-center max-w-sm"
                    >
                        <img
                            :src="aceyorkImage"
                            alt="Aceyork Buban"
                            class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-green-400 object-cover"
                            @error="handleImageError"
                        />
                        <h3 class="text-2xl font-semibold text-white mb-2">
                            Aceyork Buban
                        </h3>
                        <p class="text-green-400 font-medium mb-3">
                            UI/UX Designer
                        </p>
                        <p class="text-gray-400">
                            Creative Director & Design Specialist
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- References Section -->
        <section id="references" class="py-20 bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-white mb-4">
                        Resources & References
                    </h2>
                    <p class="text-xl text-gray-400">
                        Technologies and tools that power CRAFTPANEL
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a
                        href="#"
                        class="bg-gray-700 p-6 rounded-xl hover:bg-gray-600 transition-colors duration-200 text-center"
                    >
                        <img
                            :src="laravelLogo"
                            alt="CRAFTPANEL"
                            class="h-13 w-13 mx-auto"
                        />
                        <h3 class="text-lg font-semibold text-white">
                            Laravel
                        </h3>
                        <p class="text-gray-400 text-sm">PHP Framework</p>
                    </a>

                    <a
                        href="#"
                        class="bg-gray-700 p-6 rounded-xl hover:bg-gray-600 transition-colors duration-200 text-center"
                    >
                        <img
                            :src="vueLogo"
                            alt="CRAFTPANEL"
                            class="h-15 w-15 mx-auto"
                        />
                        <h3 class="text-lg font-semibold text-white">Vue.js</h3>
                        <p class="text-gray-400 text-sm">Frontend Framework</p>
                    </a>

                    <a
                        href="#"
                        class="bg-gray-700 p-6 rounded-xl hover:bg-gray-600 transition-colors duration-200 text-center"
                    >
                        <img
                            :src="tailwindLogo"
                            alt="CRAFTPANEL"
                            class="h-15 w-15 mx-auto"
                        />
                        <h3 class="text-lg font-semibold text-white">
                            Tailwind CSS
                        </h3>
                        <p class="text-gray-400 text-sm">Styling Framework</p>
                    </a>

                    <a
                        href="#"
                        class="bg-gray-700 p-6 rounded-xl hover:bg-gray-600 transition-colors duration-200 text-center"
                    >
                        <img
                            :src="mysqlLogo"
                            alt="CRAFTPANEL"
                            class="h-15 w-15 mx-auto"
                        />
                        <h3 class="text-lg font-semibold text-white">MySQL</h3>
                        <p class="text-gray-400 text-sm">Database</p>
                    </a>
                </div>
            </div>
        </section>

        <!-- Login Modal -->
        <div
            v-if="showLoginModal"
            class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
            @click.self="showLoginModal = false"
        >
            <div class="bg-gray-800 p-8 rounded-xl max-w-md w-full mx-4">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-white">
                        Login to CRAFTPANEL
                    </h2>
                    <button
                        @click="showLoginModal = false"
                        class="text-gray-400 hover:text-white"
                    >
                        <svg
                            class="w-6 h-6"
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
                    </button>
                </div>

                <form @submit.prevent="handleLogin">
                    <div class="mb-4">
                        <label
                            class="block text-gray-300 text-sm font-bold mb-2"
                            >Username</label
                        >
                        <input
                            type="text"
                            v-model="loginForm.username"
                            class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                        />
                    </div>

                    <div class="mb-6">
                        <label
                            class="block text-gray-300 text-sm font-bold mb-2"
                            >Password</label
                        >
                        <input
                            type="password"
                            v-model="loginForm.password"
                            class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-400"
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold transition-colors duration-200"
                    >
                        Login
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <p class="text-gray-400">
                        Don't have an account?
                        <a href="#" class="text-green-400 hover:text-green-300"
                            >Sign up here</a
                        >
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    name: "HomeComponent",
    components: {
        Link,
    },
    data() {
        return {
            showLoginModal: false,
            loginForm: {
                username: "",
                password: "",
            },
            // Updated image paths for Laravel + Vite
            laravelLogo: "/images/laravelIcon.png",
            vueLogo: "/images/vueIcon.png",
            tailwindLogo: "/images/tailwindIcon.png",
            mysqlLogo: "/images/mySQLIcon.png",
            logoText: "/images/CRAFTPANEL.png",
            logoImage: "/images/logo2bgr.png",
            heroBgImage:
                "/images/Minecraft_TheGardenAwakens_DotNet_1920x1080.png",
            jezreelImage: "/images/jezreel.jpg",
            aceyorkImage: "/images/aceyork.png",
        };
    },
    methods: {
        handlePlayClick() {
            // If user is not logged in, show login modal
            this.showLoginModal = true;
        },

        handleLogin() {
            // Handle login logic here
            console.log("Login attempt:", this.loginForm);
            // For now, just close the modal
            this.showLoginModal = false;
        },

        scrollToSection(sectionId) {
            const element = document.getElementById(sectionId);
            if (element) {
                element.scrollIntoView({ behavior: "smooth" });
            }
        },

        handleImageError(event) {
            console.error("Image failed to load:", event.target.src);
            // You can set a fallback image here
            // event.target.src = '/images/fallback-image.png';
        },
    },
};
</script>

<style scoped>
/* Custom animations and styles if needed */
</style>
