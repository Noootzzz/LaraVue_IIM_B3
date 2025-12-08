<template>
    <MusicLayout>
        <template #title> Tracks </template>

        <template #actions>
            <Link
                href="/tracks/form"
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
};
</script>
