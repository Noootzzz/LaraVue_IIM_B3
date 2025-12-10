<template>
    <MusicLayout>
        <template #title>Playlists</template>

        <template #actions>
            <Link
                :href="route('playlists.create')"
                class="group flex items-center gap-2 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-3 font-bold text-white shadow-lg shadow-purple-500/30 transition-all duration-300 hover:scale-105 hover:shadow-purple-500/50"
            >
                <Plus
                    class="h-5 w-5 transition-transform duration-300 group-hover:rotate-90"
                />
                <span>Ajouter une playlist</span>
            </Link>
        </template>

        <template #content>
            <!-- Hero Section -->
            <div class="relative mt-8 mb-16">
                <!-- Search Bar -->
                <div class="group relative max-w-2xl">
                    <div
                        class="absolute -inset-1 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 opacity-25 blur transition duration-1000 group-hover:opacity-50 group-hover:duration-200"
                    ></div>
                    <div class="relative">
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-6"
                        >
                            <Search
                                class="h-6 w-6 text-muted-foreground transition-colors group-focus-within:text-purple-400"
                            />
                        </div>
                        <input
                            v-model="search"
                            type="search"
                            name="search"
                            id="search"
                            class="block w-full rounded-full border border-border bg-card/90 py-5 pr-6 pl-16 text-lg text-foreground placeholder-muted-foreground shadow-2xl backdrop-blur-xl transition-all duration-300 focus:border-purple-500/50 focus:bg-card focus:ring-4 focus:ring-purple-500/10 focus:outline-none"
                            placeholder="Rechercher un titre, un artiste..."
                        />
                    </div>
                </div>
            </div>

            <!-- Grid -->
            <transition-group
                tag="div"
                class="grid grid-cols-2 gap-x-8 gap-y-10 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5"
                enter-active-class="transition duration-500 ease-out"
                enter-from-class="opacity-0 translate-y-10"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="absolute transition duration-300 ease-in"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
                move-class="transition duration-500 ease-in-out"
            >
                <Playlist
                    v-for="playlist in filteredPlaylists"
                    :key="playlist.id"
                    :playlist="playlist"
                />
            </transition-group>

            <!-- Empty State -->
            <div
                v-if="filteredPlaylists.length === 0"
                class="flex flex-col items-center justify-center py-32 text-muted-foreground"
            >
                <div
                    class="mb-6 rounded-full bg-gradient-to-br from-muted to-card p-8 shadow-2xl shadow-black/50"
                >
                    <Search class="h-16 w-16 text-muted-foreground" />
                </div>
                <h3 class="mb-2 text-xl font-bold text-foreground">
                    Aucun résultat trouvé
                </h3>
                <p class="text-muted-foreground">
                    Essayez de rechercher autre chose
                </p>
            </div>
        </template>
    </MusicLayout>
</template>

<script>
import Playlist from '@/components/Playlists/Playlist.vue';
import { usePlayer } from '@/composables/usePlayer';
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Plus, Search } from 'lucide-vue-next';

export default {
    name: 'Index',
    props: {
        playlists: Array,
    },
    components: {
        MusicLayout,
        Link,
        Search,
        Plus,
        Playlist,
    },
    setup() {
        const { play } = usePlayer();
        return { play };
    },
    data() {
        return {
            search: '',
        };
    },
    computed: {
        filteredPlaylists() {
            return this.playlists.filter((playlist) =>
                playlist.title
                    .toLowerCase()
                    .includes(this.search.toLowerCase()),
            );
        },
    },
};
</script>
