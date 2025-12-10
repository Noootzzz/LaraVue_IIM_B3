<template>
    <div
        class="flex min-h-screen overflow-hidden bg-background font-sans text-foreground selection:bg-purple-500 selection:text-white"
    >
        <!-- Ambient Background -->
        <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden">
            <div
                class="absolute top-[-10%] left-[-10%] h-[500px] w-[500px] animate-pulse rounded-full bg-purple-500/20 opacity-50 blur-[120px] dark:bg-purple-900/20"
            ></div>
            <div
                class="absolute right-[-10%] bottom-[-10%] h-[500px] w-[500px] animate-pulse rounded-full bg-indigo-500/20 opacity-50 blur-[120px] dark:bg-indigo-900/20"
                style="animation-delay: 2s"
            ></div>
            <div
                class="absolute top-[40%] left-[40%] h-[600px] w-[600px] animate-pulse rounded-full bg-blue-500/10 opacity-30 blur-[150px] dark:bg-blue-900/10"
                style="animation-delay: 4s"
            ></div>
        </div>

        <!-- Noise Overlay -->
        <div
            class="pointer-events-none fixed inset-0 z-[1] opacity-[0.03]"
            style="
                background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E');
            "
        ></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col border-r border-border bg-sidebar/80 backdrop-blur-xl md:flex"
        >
            <!-- Logo -->
            <div class="flex h-24 items-center px-8">
                <div class="flex items-center gap-3">
                    <div
                        class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-purple-600 to-indigo-600 shadow-lg shadow-purple-500/30"
                    >
                        <Music class="h-6 w-6 text-white" />
                    </div>
                    <span
                        class="bg-gradient-to-r from-foreground to-muted-foreground bg-clip-text text-xl font-bold tracking-tight text-transparent"
                        >MyMusic</span
                    >
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 space-y-2 px-4 py-6">
                <a
                    href="#"
                    class="group flex items-center rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 px-4 py-3.5 text-sm font-semibold text-white shadow-lg shadow-purple-500/25 transition-all hover:scale-[1.02] hover:shadow-purple-500/40"
                >
                    <Music class="mr-3 h-5 w-5" />
                    Musique
                </a>
                <a
                    href="#"
                    class="group flex items-center rounded-xl px-4 py-3.5 text-sm font-medium text-muted-foreground transition-all hover:bg-sidebar-accent hover:pl-5 hover:text-sidebar-accent-foreground"
                >
                    <Heart
                        class="mr-3 h-5 w-5 transition-colors group-hover:text-pink-500"
                    />
                    Favoris
                </a>
                <a
                    href="#"
                    class="group flex items-center rounded-xl px-4 py-3.5 text-sm font-medium text-muted-foreground transition-all hover:bg-sidebar-accent hover:pl-5 hover:text-sidebar-accent-foreground"
                >
                    <Mic2
                        class="mr-3 h-5 w-5 transition-colors group-hover:text-blue-500"
                    />
                    Playlists
                </a>
            </nav>

            <!-- User Profile -->
            <div class="border-t border-white/5 p-4 text-center">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('logout')"
                    method="post"
                    as="button"
                    preserve-scroll
                    class="rounded-full p-2.5"
                    >Log out</Link
                >
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="route('register')"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Register
                    </Link>
                </template>
            </div>
        </aside>

        <!-- Mobile Header -->
        <div
            class="fixed top-0 right-0 left-0 z-30 flex h-16 items-center justify-between border-b border-white/5 bg-[#191922]/90 px-4 backdrop-blur-md md:hidden"
        >
            <div class="flex items-center gap-3">
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-purple-600 to-indigo-600"
                >
                    <Music class="h-5 w-5 text-white" />
                </div>
                <span class="text-lg font-bold">MyMusic</span>
            </div>
            <button
                class="rounded-lg p-2 text-gray-400 hover:bg-white/5 hover:text-white"
            >
                <Menu class="h-6 w-6" />
            </button>
        </div>

        <!-- Notifications -->
        <div
            class="fixed top-24 right-6 z-50 flex w-full max-w-sm flex-col gap-3"
        >
            <transition-group
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="translate-x-full opacity-0"
                enter-to-class="translate-x-0 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="translate-x-0 opacity-100"
                leave-to-class="translate-x-full opacity-0"
                tag="div"
                class="flex flex-col gap-3"
            >
                <div
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="flex items-center gap-4 rounded-2xl border border-white/10 bg-[#191922]/90 p-4 shadow-2xl backdrop-blur-xl"
                >
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-lg shadow-green-500/20"
                    >
                        <CheckCircle class="h-5 w-5" />
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-white">Succès</h4>
                        <p class="text-sm text-gray-400">
                            {{ notification.message }}
                        </p>
                    </div>
                    <button
                        @click="removeNotification(notification.id)"
                        class="rounded-lg p-1 text-gray-500 transition-colors hover:bg-white/10 hover:text-white"
                    >
                        <X class="h-4 w-4" />
                    </button>
                </div>
            </transition-group>
        </div>

        <!-- Main Content -->
        <main class="relative z-10 flex-1 p-4 pt-20 md:ml-64 md:p-10 md:pt-10">
            <div class="mx-auto max-w-7xl">
                <div
                    class="mb-10 flex flex-col gap-6 md:flex-row md:items-end md:justify-between"
                >
                    <div class="flex flex-col gap-2">
                        <h1
                            class="text-4xl font-black tracking-tight text-foreground md:text-5xl lg:text-6xl"
                        >
                            <span
                                class="bg-gradient-to-r from-foreground to-muted-foreground bg-clip-text text-transparent"
                            >
                                <slot name="title" />
                            </span>
                        </h1>
                    </div>
                    <div class="flex-shrink-0">
                        <slot name="actions" />
                    </div>
                </div>

                <div class="animate-fade-in-up min-h-[calc(100vh-12rem)]">
                    <slot name="content" />
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import {
    CheckCircle,
    Disc,
    Heart,
    Menu,
    Mic2,
    Music,
    User,
    X,
} from 'lucide-vue-next';

export default {
    name: 'MusicLayout',
    components: {
        CheckCircle,
        X,
        Music,
        Heart,
        Mic2,
        Disc,
        User,
        Menu,
        Link,
    },
    data() {
        return {
            notifications: [],
        };
    },
    watch: {
        '$page.props.flash.success': {
            handler(newValue) {
                if (newValue) {
                    this.addNotification(newValue);
                }
            },
            immediate: true,
        },
    },
    methods: {
        addNotification(message) {
            const id = Date.now() + Math.random();
            this.notifications.push({
                id,
                message,
            });
            setTimeout(() => {
                this.removeNotification(id);
            }, 5000);
        },
        removeNotification(id) {
            this.notifications = this.notifications.filter((n) => n.id !== id);
        },
    },
};
</script>
