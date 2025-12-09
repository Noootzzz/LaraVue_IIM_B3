<template>
    <MusicLayout>
        <template #title> Tracks </template>

        <template #actions>
            <Link
                :href="route('tracks.create')"
                class="rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700"
            >
                Add Track
            </Link>
        </template>

        <template #content>
            <div class="grid grid-cols-4 gap-4">
                <Track
                    v-for="track in tracks"
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
        };
    },
    methods: {
        changeCurrentAudio() {
            this.audio = new Audio(`/storage/${track.audio}`);
            this.audio.play();
            this.currentAudio = track.slug;
        },
        handleListen(track) {
            if (!this.audio) {
                this.changeCurrentAudio();
            } else if (track.slug !== this.currentAudio) {
                this.audio.pause();
                this.changeCurrentAudio();
            } else if (this.audio.paused) {
                this.audio.play();
            } else {
                this.audio.pause();
            }
        },
    },
};
</script>
