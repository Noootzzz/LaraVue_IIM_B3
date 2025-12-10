<template>
    <div
        class="group relative overflow-hidden rounded-3xl border border-border bg-card/50 p-4 transition-all duration-500 hover:-translate-y-2 hover:bg-card hover:shadow-2xl hover:shadow-purple-500/20"
    >
        <div class="relative mb-4 aspect-square overflow-hidden rounded-2xl">
            <!-- Placeholder Gradient for Playlist Cover -->
            <div
                class="h-full w-full bg-gradient-to-br from-purple-500/20 to-indigo-500/20 transition-transform duration-700 group-hover:scale-110"
            >
                <div class="flex h-full items-center justify-center">
                    <ListMusic class="h-12 w-12 text-purple-500/50" />
                </div>
            </div>

            <!-- Play Overlay -->
            <div
                class="absolute inset-0 flex items-center justify-center gap-2 bg-black/40 opacity-0 backdrop-blur-sm transition-all duration-300 group-hover:opacity-100"
            >
                <Link
                    :href="route('playlists.show', playlist)"
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-600 text-white transition-transform duration-300 hover:scale-110"
                    title="Voir la playlist"
                >
                    <ListMusic class="h-6 w-6" />
                </Link>
                <Link
                    :href="route('playlists.edit', playlist)"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur-md transition-transform duration-300 hover:scale-110 hover:bg-white/30"
                    title="Modifier"
                >
                    <Edit2 class="h-4 w-4" />
                </Link>
            </div>
        </div>

        <div class="space-y-1">
            <h3 class="truncate text-lg font-bold text-foreground">
                {{ playlist.title }}
            </h3>
        </div>

        <div
            class="mt-4 flex items-center justify-between border-t border-border pt-4"
        >
            <span class="text-xs font-medium text-muted-foreground">
                {{ playlist.tracks_count ?? 0 }} titre{{
                    (playlist.tracks_count ?? 0 > 1) ? 's' : ''
                }}
            </span>
            <Link
                :href="route('playlists.destroy', playlist)"
                method="delete"
                as="button"
                class="rounded-full p-2 text-muted-foreground transition-colors hover:bg-red-500/10 hover:text-red-500"
            >
                <Trash2 class="h-4 w-4" />
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { Edit2, ListMusic, Trash2 } from 'lucide-vue-next';

export default {
    components: {
        Link,
        Edit2,
        ListMusic,
        Trash2,
    },
    props: {
        playlist: Object,
    },
};
</script>
