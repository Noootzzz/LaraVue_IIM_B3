<template>
    <MusicLayout>
        <template #title>{{ playlist.title }}</template>

        <template #actions>
            <Link
                :href="route('playlists.index')"
                class="flex items-center gap-2 rounded-full bg-white/5 px-6 py-3 font-semibold text-white backdrop-blur-md transition-all hover:scale-105 hover:bg-white/10"
            >
                <ArrowLeft class="h-5 w-5" />
                <span>Retour</span>
            </Link>
        </template>

        <template #content>
            <div class="mt-8">
                <div
                    v-if="playlist.tracks.length === 0"
                    class="flex flex-col items-center justify-center py-32 text-muted-foreground"
                >
                    <div
                        class="mb-6 rounded-full bg-gradient-to-br from-muted to-card p-8 shadow-2xl shadow-black/50"
                    >
                        <Music class="h-16 w-16 text-muted-foreground" />
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-foreground">
                        Cette playlist est vide
                    </h3>
                    <p class="text-muted-foreground">
                        Ajoutez des musiques depuis la page "Musique"
                    </p>
                    <Link
                        :href="route('tracks.index')"
                        class="mt-6 rounded-full bg-purple-600 px-6 py-2 text-white transition-colors hover:bg-purple-700"
                    >
                        Découvrir des musiques
                    </Link>
                </div>

                <div v-else class="grid grid-cols-1 gap-4">
                    <div
                        v-for="(track, index) in playlist.tracks"
                        :key="track.id"
                        class="group flex items-center justify-between rounded-xl border border-border bg-card/50 p-4 transition-all hover:bg-card hover:shadow-lg"
                    >
                        <div class="flex items-center gap-4">
                            <span
                                class="w-8 text-center font-mono text-muted-foreground"
                                >{{ index + 1 }}</span
                            >
                            <div
                                class="relative h-12 w-12 overflow-hidden rounded-lg"
                            >
                                <img
                                    :src="`/storage/${track.image}`"
                                    :alt="track.title"
                                    class="h-full w-full object-cover"
                                />
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100"
                                >
                                    <button
                                        @click="play(track)"
                                        class="text-white transition-transform hover:scale-110"
                                    >
                                        <Pause
                                            v-if="
                                                isPlaying &&
                                                currentTrack?.id === track.id
                                            "
                                            class="h-6 w-6 fill-current"
                                        />
                                        <Play
                                            v-else
                                            class="h-6 w-6 fill-current"
                                        />
                                    </button>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-foreground">
                                    {{ track.title }}
                                </h4>
                                <p class="text-sm text-muted-foreground">
                                    {{ track.artist }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button
                                @click="removeTrack(track)"
                                class="rounded-full p-2 text-muted-foreground opacity-0 transition-all group-hover:opacity-100 hover:bg-red-500/10 hover:text-red-500"
                                title="Retirer de la playlist"
                            >
                                <Trash2 class="h-5 w-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </MusicLayout>
</template>

<script setup lang="ts">
import { usePlayer } from '@/composables/usePlayer';
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ArrowLeft, Music, Pause, Play, Trash2 } from 'lucide-vue-next';
import { route } from 'ziggy-js';

const props = defineProps<{
    playlist: {
        id: number;
        title: string;
        slug: string;
        tracks: Array<{
            id: number;
            title: string;
            artist: string;
            image: string;
            audio: string;
            slug: string;
        }>;
    };
}>();

const { play, isPlaying, currentTrack } = usePlayer();

const removeTrack = (track: any) => {
    if (
        confirm('Voulez-vous vraiment retirer cette musique de la playlist ?')
    ) {
        router.delete(
            route('playlists.tracks.destroy', {
                playlist: props.playlist,
                track: track.id,
            }),
        );
    }
};
</script>
