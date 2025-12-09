<template>
    <MusicLayout>
        <template #title>Liste des musiques</template>

        <template #actions>
            <Link
                :href="route('tracks.create')"
                class="rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700"
            >
                Ajouter une musique
            </Link>
        </template>

        <template #content>
            <input
                v-model="search"
                type="search"
                name="search"
                id="search"
                class="focus:shadow-outline mb-4 w-lg appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none"
                placeholder="Rechercher une musique..."
            />
            <div class="grid grid-cols-4 gap-4">
                <Track
                    v-for="track in filteredTracks"
                    :key="track.slug"
                    :track="track"
                    @listen="handleListen"
                />
            </div>
        </template>
    </MusicLayout>
</template>

<script>
import Track from '@/components/Tracks/Track.vue';
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';

export default {
    name: 'Index',
    props: {
        tracks: Array,
    },
    components: {
        MusicLayout,
        Track,
        Link,
    },
    data() {
        return {
            audio: null,
            currentAudio: null,
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
        changeCurrentAudio(track) {
            this.audio = new Audio(`/storage/${track.audio}`);
            this.audio.play();
            this.currentAudio = track.slug;
        },
        handleListen(track) {
            if (!this.audio) {
                this.changeCurrentAudio(track);
            } else if (track.slug !== this.currentAudio) {
                this.audio.pause();
                this.changeCurrentAudio(track);
            } else if (this.audio.paused) {
                this.audio.play();
            } else {
                this.audio.pause();
            }
        },
    },
};
</script>
