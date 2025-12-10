<template>
    <MusicLayout>
        <template #title>Créer une playlist</template>

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
            <div class="mx-auto max-w-4xl">
                <div
                    class="relative overflow-hidden rounded-3xl border border-border bg-card/50 p-8 shadow-2xl backdrop-blur-xl md:p-12"
                >
                    <!-- Decorative Gradients -->
                    <div
                        class="absolute top-0 right-0 -mt-20 -mr-20 h-64 w-64 rounded-full bg-purple-500/20 blur-3xl"
                    ></div>
                    <div
                        class="absolute bottom-0 left-0 -mb-20 -ml-20 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl"
                    ></div>

                    <PlaylistForm :tracks="tracks" />
                </div>
            </div>
        </template>
    </MusicLayout>
</template>

<script>
import PlaylistForm from '@/components/Playlists/PlaylistForm.vue';
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';

export default {
    name: 'Create',
    components: {
        MusicLayout,
        PlaylistForm,
        Link,
        ArrowLeft,
    },
    props: {
        tracks: Array,
    },
};
</script>
