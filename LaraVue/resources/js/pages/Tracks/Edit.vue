<template>
    <MusicLayout>
        <template #title> Modifier la musique : {{ track.title }} </template>

        <template #actions>
            <Link
                :href="route('tracks.index')"
                class="flex items-center gap-2 rounded-full bg-white/5 px-6 py-3 font-semibold text-white backdrop-blur-md transition-all hover:scale-105 hover:bg-white/10"
            >
                <ArrowLeft class="h-5 w-5" />
                <span>Retour</span>
            </Link>
        </template>

        <template #content>
            <form @submit.prevent="submit()" class="mx-auto max-w-4xl">
                <div
                    class="relative grid gap-8 overflow-hidden rounded-3xl border border-white/5 bg-[#191922]/50 p-8 shadow-2xl backdrop-blur-xl"
                >
                    <!-- Decorative Gradients -->
                    <div
                        class="pointer-events-none absolute top-0 right-0 -mt-20 -mr-20 h-64 w-64 rounded-full bg-purple-500/20 blur-3xl"
                    ></div>
                    <div
                        class="pointer-events-none absolute bottom-0 left-0 -mb-20 -ml-20 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl"
                    ></div>

                    <!-- Title -->
                    <div class="group relative z-10">
                        <label
                            for="title"
                            class="mb-3 block text-sm font-bold tracking-wider text-gray-400 uppercase transition-colors group-focus-within:text-purple-400"
                            >Titre</label
                        >
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            class="block w-full rounded-xl border-2 border-transparent bg-[#121216] p-4 text-xl text-white placeholder-gray-600 shadow-inner transition-all focus:border-purple-500/50 focus:bg-[#191922] focus:ring-4 focus:ring-purple-500/10 focus:outline-none"
                            placeholder="Titre de la musique"
                            :class="{
                                'border-red-500/50 focus:border-red-500':
                                    form.errors.title,
                            }"
                        />
                        <p
                            class="mt-2 flex items-center gap-2 text-sm text-red-400"
                            v-if="form.errors.title"
                        >
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-red-500"
                            ></span>
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <!-- Artist -->
                    <div class="group">
                        <label
                            for="artist"
                            class="mb-3 block text-sm font-bold tracking-wider text-gray-400 uppercase transition-colors group-focus-within:text-purple-400"
                            >Artiste</label
                        >
                        <input
                            id="artist"
                            v-model="form.artist"
                            type="text"
                            class="block w-full rounded-xl border-2 border-transparent bg-[#121216] p-4 text-xl text-white placeholder-gray-600 shadow-inner transition-all focus:border-purple-500/50 focus:bg-[#191922] focus:ring-4 focus:ring-purple-500/10 focus:outline-none"
                            placeholder="Nom de l'artiste"
                            :class="{
                                'border-red-500/50 focus:border-red-500':
                                    form.errors.artist,
                            }"
                        />
                        <p
                            class="mt-2 flex items-center gap-2 text-sm text-red-400"
                            v-if="form.errors.artist"
                        >
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-red-500"
                            ></span>
                            {{ form.errors.artist }}
                        </p>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end border-t border-white/5 pt-6">
                        <button
                            type="submit"
                            class="group relative overflow-hidden rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 px-10 py-4 font-bold text-white shadow-lg shadow-purple-500/30 transition-all hover:scale-105 hover:shadow-purple-500/50 disabled:cursor-not-allowed disabled:opacity-50"
                            :disabled="form.processing"
                        >
                            <span class="relative z-10 flex items-center gap-2">
                                <span>Modifier la musique</span>
                                <Save
                                    class="h-5 w-5 transition-transform group-hover:scale-110"
                                />
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </template>
    </MusicLayout>
</template>

<script>
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, Save } from 'lucide-vue-next';

export default {
    name: 'Edit',
    components: {
        MusicLayout,
        Link,
        ArrowLeft,
        Save,
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
