<template>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Tracks</h1>
        <ul>
            <li 
            v-for="track in tracks"
            :key="track.id"
            class="mb-2 p-4 border rounded">
                <h2 class="text-xl font-semibold">{{ track.title }}</h2>
                <p>{{ track.description }}</p>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'Index', 
        props: {
            tracks: Array,
        },
    };
</script>