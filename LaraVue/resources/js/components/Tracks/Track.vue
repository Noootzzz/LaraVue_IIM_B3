<template>
    <div
        class="group relative flex flex-col gap-4 transition-all duration-500 hover:-translate-y-2 hover:scale-[1.02]"
    >
        <!-- Image Container -->
        <div
            class="relative aspect-square w-full overflow-hidden rounded-2xl bg-muted shadow-lg ring-1 ring-border transition-all duration-500 group-hover:shadow-2xl group-hover:shadow-purple-500/30 group-hover:ring-purple-500/20"
        >
            <img
                class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-110 group-hover:rotate-2"
                :src="`/storage/${track.image}`"
                :alt="track.title"
            />

            <!-- Gradient Overlay -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
            ></div>

            <!-- Shine Effect -->
            <div
                class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/10 to-transparent transition-transform duration-1000 group-hover:translate-x-full"
            ></div>

            <!-- Play Button Overlay -->
            <div
                class="absolute inset-0 flex items-center justify-center opacity-0 transition-all duration-500 group-hover:opacity-100"
            >
                <button
                    @click="play(track)"
                    class="flex h-16 w-16 translate-y-4 transform items-center justify-center rounded-full bg-white/10 text-white shadow-xl shadow-black/50 backdrop-blur-md transition-all duration-300 group-hover:translate-y-0 hover:scale-110 hover:bg-white hover:text-black"
                >
                    <Pause
                        v-if="isPlaying && currentTrack?.id === track.id"
                        class="ml-0.5 h-8 w-8 fill-current"
                    />
                    <Play v-else class="ml-1 h-8 w-8 fill-current" />
                </button>
            </div>
        </div>

        <!-- Actions -->
        <div
            class="absolute top-3 right-3 z-20 flex translate-y-[-10px] gap-2 opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100"
        >
            <div class="relative" v-if="$page.props.auth.user">
                <button
                    @click.stop="showPlaylists = !showPlaylists"
                    class="rounded-full bg-black/40 p-2.5 text-white backdrop-blur-md transition-colors hover:bg-purple-600 hover:text-white"
                    title="Ajouter à une playlist"
                >
                    <ListMusic class="h-4 w-4" />
                </button>

                <!-- Dropdown Playlists -->
                <div
                    v-if="showPlaylists"
                    class="absolute top-full right-0 z-50 mt-2 w-56 origin-top-right animate-in rounded-xl border border-border bg-card/95 p-1 shadow-2xl backdrop-blur-xl duration-200 zoom-in-95 fade-in"
                    @click.stop
                >
                    <div
                        class="px-2 py-1.5 text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                    >
                        Ajouter à...
                    </div>

                    <div class="my-1 h-px bg-border"></div>

                    <div
                        v-if="
                            $page.props.playlists &&
                            $page.props.playlists.length > 0
                        "
                        class="custom-scrollbar max-h-48 overflow-y-auto"
                    >
                        <button
                            v-for="playlist in $page.props.playlists"
                            :key="playlist.id"
                            @click="addToPlaylist(playlist)"
                            class="group/item flex w-full items-center gap-2 rounded-lg px-2 py-2 text-left text-sm text-foreground transition-colors hover:bg-purple-500/10 hover:text-purple-500"
                        >
                            <ListMusic
                                class="h-4 w-4 text-muted-foreground transition-colors group-hover/item:text-purple-500"
                            />
                            <span class="truncate">{{ playlist.title }}</span>
                        </button>
                    </div>
                    <div
                        v-else
                        class="px-2 py-3 text-center text-xs text-muted-foreground"
                    >
                        Aucune playlist
                    </div>

                    <div class="my-1 h-px bg-border"></div>

                    <Link
                        :href="route('playlists.create')"
                        class="flex w-full items-center gap-2 rounded-lg px-2 py-2 text-left text-sm font-medium text-purple-500 transition-colors hover:bg-purple-500/10"
                    >
                        <Plus class="h-4 w-4" />
                        Nouvelle playlist
                    </Link>
                </div>
            </div>

            <Link
                :href="route('tracks.edit', track)"
                v-if="$page.props.isAdmin"
                class="rounded-full bg-black/40 p-2.5 text-white backdrop-blur-md transition-colors hover:bg-purple-600 hover:text-white"
                title="Modifier"
            >
                <Edit class="h-4 w-4" />
            </Link>
            <Link
                :href="route('tracks.destroy', track)"
                v-if="$page.props.isAdmin"
                method="delete"
                as="button"
                preserve-scroll
                class="rounded-full bg-black/40 p-2.5 text-white backdrop-blur-md transition-colors hover:bg-red-500 hover:text-white"
                title="Supprimer"
            >
                <Trash2 class="h-4 w-4" />
            </Link>
        </div>

        <!-- Text Info -->
        <div class="flex flex-col gap-1 px-1">
            <h3
                class="truncate text-lg font-bold text-foreground transition-colors group-hover:text-purple-400"
                :title="track.title"
            >
                {{ track.title }}
            </h3>
            <p
                class="truncate text-sm font-medium text-muted-foreground transition-colors group-hover:text-foreground"
                :title="track.artist"
            >
                {{ track.artist }}
            </p>
        </div>
    </div>
</template>

<script>
import { usePlayer } from '@/composables/usePlayer';
import { Link, router } from '@inertiajs/vue3';
import { Edit, ListMusic, Pause, Play, Plus, Trash2 } from 'lucide-vue-next';

export default {
    name: 'Track',
    props: {
        track: Object,
    },
    components: {
        Link,
        Play,
        Pause,
        Edit,
        Trash2,
        ListMusic,
        Plus,
    },
    setup() {
        const { play, isPlaying, currentTrack } = usePlayer();
        return { play, isPlaying, currentTrack };
    },
    data() {
        return {
            showPlaylists: false,
        };
    },
    methods: {
        addToPlaylist(playlist) {
            router.post(
                route('playlists.tracks.store', playlist),
                {
                    track_id: this.track.id,
                },
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showPlaylists = false;
                    },
                },
            );
        },
    },
};
</script>
