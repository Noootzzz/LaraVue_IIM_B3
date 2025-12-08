<template>
    <MusicLayout>
        <template #title> Create Track </template>

        <template #actions>
            <Link
                href="/tracks"
                class="rounded bg-gray-500 px-4 py-2 font-bold text-white hover:bg-gray-700"
            >
                Back
            </Link>
        </template>

        <template #content>
            <div>Form will be here</div>
        </template>
    </MusicLayout>
</template>

<script>
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';

export default {
    name: 'Form',
    components: {
        MusicLayout,
        Link,
    },
};
</script>
