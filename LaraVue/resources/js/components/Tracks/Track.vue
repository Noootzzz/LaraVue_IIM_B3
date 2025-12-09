<template>
    <div class="max-w-sm cursor-pointer overflow-hidden rounded shadow-lg">
        <div class="relative h-1/2 w-full">
            <img class="h-full w-full" :src="`/storage/${track.image}`" />
            <button
                @click="handleClick"
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transform rounded-full bg-white px-4 py-2 font-bold text-black"
            >
                Play
            </button>
        </div>
        <div class="px-6 py-4">
            <div class="mb-2 text-xl font-bold">{{ track.title }}</div>
            <small class="text-base text-gray-700">
                {{ track.artist }}
            </small>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Track',
    emits: ['listen'],
    props: {
        track: Object,
    },
    methods: {
        handleClick() {
            this.$emit('listen', this.track);
        },
    },
};
</script>
