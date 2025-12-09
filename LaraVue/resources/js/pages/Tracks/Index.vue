<template>
    <MusicLayout>
        <template #title>Découvrir</template>

        <template #actions>
            <Link
                :href="route('tracks.create')"
                class="group flex items-center gap-2 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-3 font-bold text-white shadow-lg shadow-purple-500/30 transition-all duration-300 hover:scale-105 hover:shadow-purple-500/50"
            >
                <Plus
                    class="h-5 w-5 transition-transform duration-300 group-hover:rotate-90"
                />
                <span>Ajouter une musique</span>
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
                <Track
                    v-for="track in filteredTracks"
                    :key="track.slug"
                    :track="track"
                    @listen="handleListen"
                />
            </transition-group>

            <!-- Empty State -->
            <div
                v-if="filteredTracks.length === 0"
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

            <!-- Spacer for Player -->
            <div v-if="currentTrack" class="h-24 w-full"></div>

            <!-- Minimalist Full Width Player -->
            <div
                v-if="currentTrack"
                class="fixed right-0 bottom-0 left-0 z-50 translate-y-0 border-t border-border bg-background/95 backdrop-blur-xl transition-all duration-500 ease-out md:left-64"
            >
                <!-- Progress Bar -->
                <div
                    class="group/progress absolute top-0 right-0 left-0 h-0.5 cursor-pointer bg-secondary transition-all hover:h-1"
                >
                    <div
                        class="absolute inset-y-0 left-0 w-1/3 bg-purple-500 transition-all group-hover/progress:bg-purple-400"
                    ></div>
                </div>

                <div
                    class="mx-auto flex max-w-[1920px] items-center justify-between px-4 py-3 md:px-6"
                >
                    <!-- Track Info -->
                    <div
                        class="flex flex-1 items-center gap-3 overflow-hidden md:w-1/3 md:gap-4"
                    >
                        <div
                            class="relative h-10 w-10 flex-shrink-0 overflow-hidden rounded bg-muted md:h-12 md:w-12"
                        >
                            <img
                                :src="`/storage/${currentTrack.image}`"
                                class="h-full w-full object-cover"
                            />
                        </div>
                        <div
                            class="flex flex-col justify-center overflow-hidden"
                        >
                            <h4
                                class="truncate text-sm font-medium text-foreground"
                            >
                                {{ currentTrack.title }}
                            </h4>
                            <p
                                class="cursor-pointer truncate text-xs text-muted-foreground transition-colors hover:text-foreground"
                            >
                                {{ currentTrack.artist }}
                            </p>
                        </div>
                        <button
                            class="ml-2 text-muted-foreground transition-colors hover:text-purple-500"
                        >
                            <Heart class="h-4 w-4" />
                        </button>
                    </div>

                    <!-- Controls -->
                    <div
                        class="flex items-center gap-3 md:w-1/3 md:justify-center md:gap-6"
                    >
                        <button
                            class="hidden text-muted-foreground transition hover:text-foreground md:block"
                        >
                            <Shuffle class="h-4 w-4" />
                        </button>
                        <button
                            class="hidden text-muted-foreground transition hover:text-foreground sm:block"
                        >
                            <SkipBack class="h-5 w-5 fill-current" />
                        </button>
                        <button
                            @click="togglePlay"
                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-foreground text-background transition hover:scale-105"
                        >
                            <Pause
                                v-if="isPlaying"
                                class="h-4 w-4 fill-current"
                            />
                            <Play v-else class="ml-0.5 h-4 w-4 fill-current" />
                        </button>
                        <button
                            class="text-muted-foreground transition hover:text-foreground"
                        >
                            <SkipForward class="h-5 w-5 fill-current" />
                        </button>
                        <button
                            class="hidden text-muted-foreground transition hover:text-foreground md:block"
                        >
                            <Repeat class="h-4 w-4" />
                        </button>
                    </div>

                    <!-- Volume / Extras -->
                    <div
                        class="hidden w-1/3 items-center justify-end gap-6 md:flex"
                    >
                        <span class="font-mono text-xs text-muted-foreground"
                            >0:42 / 3:45</span
                        >
                        <div class="group flex items-center gap-3">
                            <Volume2
                                class="h-4 w-4 text-muted-foreground transition group-hover:text-foreground"
                            />
                            <div
                                class="h-1 w-24 cursor-pointer overflow-hidden rounded-full bg-secondary"
                            >
                                <div
                                    class="h-full w-2/3 bg-muted-foreground transition-colors group-hover:bg-foreground"
                                ></div>
                            </div>
                        </div>
                        <button
                            class="text-muted-foreground transition hover:text-foreground"
                        >
                            <ListMusic class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </MusicLayout>
</template>

<script>
import Track from '@/components/Tracks/Track.vue';
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';
import {
    Heart,
    ListMusic,
    Mic2,
    Pause,
    Play,
    Plus,
    Repeat,
    Search,
    Shuffle,
    SkipBack,
    SkipForward,
    Volume2,
} from 'lucide-vue-next';

export default {
    name: 'Index',
    props: {
        tracks: Array,
    },
    components: {
        MusicLayout,
        Track,
        Link,
        Search,
        Plus,
        Play,
        Pause,
        SkipBack,
        SkipForward,
        Heart,
        Shuffle,
        Repeat,
        Volume2,
        Mic2,
        ListMusic,
    },
    data() {
        return {
            audio: null,
            currentTrack: null,
            isPlaying: false,
            search: '',
        };
    },
    computed: {
        filteredTracks() {
            return this.tracks.filter((track) =>
                track.title.toLowerCase().includes(this.search.toLowerCase()),
            );
        },
    },
    methods: {
        play(track) {
            if (this.currentTrack?.slug !== track.slug) {
                if (this.audio) {
                    this.audio.pause();
                    this.audio.currentTime = 0;
                }
                this.audio = new Audio(`/storage/${track.audio}`);
                this.audio.onended = () => {
                    this.isPlaying = false;
                };
                this.currentTrack = track;
            }
            this.audio.play();
            this.isPlaying = true;
        },
        pause() {
            this.audio.pause();
            this.isPlaying = false;
        },
        togglePlay() {
            if (this.isPlaying) {
                this.pause();
            } else if (this.currentTrack) {
                this.play(this.currentTrack);
            }
        },
        handleListen(track) {
            if (this.currentTrack?.slug === track.slug) {
                this.togglePlay();
            } else {
                this.play(track);
            }
        },
    },
    beforeUnmount() {
        if (this.audio) {
            this.audio.pause();
        }
    },
};
</script>

<style scoped>
.paused {
    animation-play-state: paused;
}
</style>
