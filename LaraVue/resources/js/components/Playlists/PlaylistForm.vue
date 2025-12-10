<template>
    <form @submit.prevent="submit" class="relative space-y-8">
        <div class="grid gap-8">
            <!-- Title -->
            <div class="group">
                <label
                    for="title"
                    class="mb-3 block text-sm font-bold tracking-wider text-muted-foreground uppercase transition-colors group-focus-within:text-purple-400"
                    >Titre</label
                >
                <input
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="block w-full rounded-xl border border-border bg-input/20 p-4 text-lg text-foreground placeholder-muted-foreground shadow-inner backdrop-blur-sm transition-all focus:border-purple-500/50 focus:bg-input/40 focus:ring-4 focus:ring-purple-500/10 focus:outline-none"
                    placeholder="Ma super playlist"
                    :class="{
                        'border-red-500/50 focus:border-red-500':
                            form.errors.title,
                    }"
                />
                <p class="mt-2 text-sm text-red-400" v-if="form.errors.title">
                    {{ form.errors.title }}
                </p>
            </div>
        </div>

        <div class="mb-4" v-if="tracks && tracks.length">
            <label
                class="mb-3 block text-sm font-bold tracking-wider text-muted-foreground uppercase"
                >Musiques</label
            >
            <div
                v-for="track in tracks"
                :key="track.slug"
                class="flex items-center gap-2"
            >
                <input
                    type="checkbox"
                    name="tracks"
                    :value="track.slug"
                    v-model="form.tracks"
                    :id="'tracks_' + track.slug"
                    class="focus:ring-opacity-50 rounded"
                />
                <label :for="'tracks_' + track.slug">{{ track.title }}</label>
            </div>
            <small
                class="mt-1 text-sm text-red-500"
                v-if="form.errors.tracks"
                >{{ form.errors.tracks }}</small
            >
        </div>

        <div class="flex justify-end pt-6">
            <button
                type="submit"
                :disabled="form.processing"
                class="group relative flex items-center gap-2 overflow-hidden rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-4 font-bold text-white shadow-lg shadow-purple-500/30 transition-all hover:scale-105 hover:shadow-purple-500/50 disabled:opacity-50"
            >
                <span class="relative z-10">{{
                    playlist ? 'Mettre à jour' : 'Créer la playlist'
                }}</span>
                <div
                    class="absolute inset-0 -translate-x-full bg-gradient-to-r from-indigo-600 to-purple-600 transition-transform duration-500 group-hover:translate-x-0"
                ></div>
            </button>
        </div>
    </form>
</template>

<script>
export default {
    name: 'PlaylistForm',
    props: {
        playlist: Object,
        tracks: Array,
    },
    data() {
        return {
            form: this.$inertia.form({
                title: this.playlist?.title ?? '',
                tracks: this.playlist?.tracks.map(track => track.slug) ?? [],
            }),
        };
    },
    methods: {
        submit() {
            if (this.playlist) {
                this.form.put(route('playlists.update', this.playlist));
            } else {
                this.form.post(route('playlists.store'));
            }
        },
    },
};
</script>
