<template>
    <MusicLayout>
        <template #title>
            Tracks
        </template>

        <template #actions>
            
        </template>

        <template #content>
            <div class="p-4">
                <h1 class="mb-4 text-2xl font-bold">Tracks</h1>
                <ul>
                    <li
                        v-for="track in tracks"
                        :key="track.id"
                        class="mb-2 rounded border p-4"
                    >
                        {{ track.title }} - {{ track.artist }}
                    </li>
                </ul>
            </div>
        </template>
    </MusicLayout>
</template>

<script>
import MusicLayout from '@/layouts/MusicLayout.vue';

export default {
    name: 'Index',
    props: {
        tracks: Array,
    },
    components: {
        MusicLayout,
    },
};
</script>
