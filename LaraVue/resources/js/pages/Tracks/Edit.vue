<template>
    <MusicLayout>
        <template #title> Modifier la musique : {{ track.title }} </template>

        <template #actions>
            <Link
                :href="route('tracks.index')"
                class="rounded bg-gray-500 px-4 py-2 font-bold text-white hover:bg-gray-700"
            >
                Retour à la liste
            </Link>
        </template>

        <template #content>
            <form @submit.prevent="submit()" class="mx-auto max-w-md">
                <div class="mb-4">
                    <label
                        for="title"
                        class="mb-2 block text-sm font-bold text-gray-700"
                        >Titre</label
                    >
                    <input
                        id="title"
                        v-model="form.title"
                        :class="{ 'border-red-500': form.errors.title }"
                        type="text"
                        class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none"
                        placeholder="Titre de la musique"
                    />
                    <small class="text-red-500" v-if="form.errors.title">{{
                        form.errors.title
                    }}</small>
                </div>

                <div class="mb-4">
                    <label
                        for="artist"
                        class="mb-2 block text-sm font-bold text-gray-700"
                        >Artiste</label
                    >
                    <input
                        id="artist"
                        v-model="form.artist"
                        type="text"
                        class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none"
                        placeholder="Nom de l'artiste"
                        :class="{ 'border-red-500': form.errors.artist }"
                    />
                    <small class="text-red-500" v-if="form.errors.artist">{{
                        form.errors.artist
                    }}</small>
                </div>

                <div class="flex items-center justify-between">
                    <input
                        type="submit"
                        value="Modifier"
                        class="focus:shadow-outline rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700 focus:outline-none"
                        :disabled="form.processing"
                    />
                </div>
            </form>
        </template>
    </MusicLayout>
</template>

<script>
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';

export default {
    name: 'Edit',
    components: {
        MusicLayout,
        Link,
    },
    props: {
        track: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                title: this.track.title,
                artist: this.track.artist,
            }),
        };
    },
    methods: {
        submit() {
            this.form.put(route('tracks.update', { track: this.track }));
        },
    },
};
</script>
