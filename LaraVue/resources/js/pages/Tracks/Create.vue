<template>
    <MusicLayout>
        <template #title>Ajouter une musique</template>

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
            <div class="mx-auto max-w-4xl">
                <div
                    class="relative overflow-hidden rounded-3xl border border-border bg-card/50 p-8 shadow-2xl backdrop-blur-xl md:p-12"
                >
                    <!-- Decorative Gradients -->
                    <div
                        class="absolute top-0 right-0 -mt-20 -mr-20 h-64 w-64 rounded-full bg-purple-500/20 blur-3xl"
                    ></div>
                    <div
                        class="absolute bottom-0 left-0 -mb-20 -ml-20 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl"
                    ></div>

                    <form @submit.prevent="submit()" class="relative space-y-8">
                        <div class="grid gap-8 md:grid-cols-2">
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
                                    placeholder="Titre de la musique"
                                    :class="{
                                        'border-red-500/50 focus:border-red-500':
                                            form.errors.title,
                                    }"
                                />
                                <p
                                    class="mt-2 text-sm text-red-400"
                                    v-if="form.errors.title"
                                >
                                    {{ form.errors.title }}
                                </p>
                            </div>

                            <!-- Artist -->
                            <div class="group">
                                <label
                                    for="artist"
                                    class="mb-3 block text-sm font-bold tracking-wider text-muted-foreground uppercase transition-colors group-focus-within:text-purple-400"
                                    >Artiste</label
                                >
                                <input
                                    id="artist"
                                    v-model="form.artist"
                                    type="text"
                                    class="block w-full rounded-xl border border-border bg-input/20 p-4 text-lg text-foreground placeholder-muted-foreground shadow-inner backdrop-blur-sm transition-all focus:border-purple-500/50 focus:bg-input/40 focus:ring-4 focus:ring-purple-500/10 focus:outline-none"
                                    placeholder="Nom de l'artiste"
                                    :class="{
                                        'border-red-500/50 focus:border-red-500':
                                            form.errors.artist,
                                    }"
                                />
                                <p
                                    class="mt-2 text-sm text-red-400"
                                    v-if="form.errors.artist"
                                >
                                    {{ form.errors.artist }}
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-8 md:grid-cols-2">
                            <!-- Image Upload -->
                            <div class="group">
                                <label
                                    class="mb-3 block text-sm font-bold tracking-wider text-gray-400 uppercase transition-colors group-hover:text-purple-400"
                                >
                                    Image de couverture
                                </label>
                                <div class="relative">
                                    <input
                                        type="file"
                                        id="image"
                                        @input="
                                            form.image = $event.target.files[0]
                                        "
                                        class="peer absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0"
                                        accept="image/*"
                                    />
                                    <div
                                        class="flex h-64 flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/10 bg-black/20 transition-all peer-hover:border-purple-500/50 peer-hover:bg-black/30"
                                    >
                                        <div
                                            class="mb-4 rounded-full bg-white/5 p-4 transition-transform peer-hover:scale-110"
                                        >
                                            <Upload
                                                class="h-8 w-8 text-gray-400 peer-hover:text-purple-400"
                                            />
                                        </div>
                                        <p
                                            class="text-sm font-medium text-gray-300"
                                        >
                                            Cliquez pour upload
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            PNG, JPG (MAX. 2MB)
                                        </p>
                                        <p
                                            v-if="form.image"
                                            class="mt-4 rounded-full bg-purple-500/20 px-3 py-1 text-xs font-bold text-purple-300"
                                        >
                                            {{ form.image.name }}
                                        </p>
                                    </div>
                                </div>
                                <p
                                    class="mt-2 text-sm text-red-400"
                                    v-if="form.errors.image"
                                >
                                    {{ form.errors.image }}
                                </p>
                            </div>

                            <!-- Audio Upload -->
                            <div class="group">
                                <label
                                    class="mb-3 block text-sm font-bold tracking-wider text-gray-400 uppercase transition-colors group-hover:text-purple-400"
                                >
                                    Fichier Audio
                                </label>
                                <div class="relative">
                                    <input
                                        type="file"
                                        id="audio"
                                        @input="
                                            form.audio = $event.target.files[0]
                                        "
                                        class="peer absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0"
                                        accept="audio/*"
                                    />
                                    <div
                                        class="flex h-64 flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/10 bg-black/20 transition-all peer-hover:border-purple-500/50 peer-hover:bg-black/30"
                                    >
                                        <div
                                            class="mb-4 rounded-full bg-white/5 p-4 transition-transform peer-hover:scale-110"
                                        >
                                            <Music
                                                class="h-8 w-8 text-gray-400 peer-hover:text-purple-400"
                                            />
                                        </div>
                                        <p
                                            class="text-sm font-medium text-gray-300"
                                        >
                                            Cliquez pour upload
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            MP3, WAV (MAX. 10MB)
                                        </p>
                                        <p
                                            v-if="form.audio"
                                            class="mt-4 rounded-full bg-purple-500/20 px-3 py-1 text-xs font-bold text-purple-300"
                                        >
                                            {{ form.audio.name }}
                                        </p>
                                    </div>
                                </div>
                                <p
                                    class="mt-2 text-sm text-red-400"
                                    v-if="form.errors.audio"
                                >
                                    {{ form.errors.audio }}
                                </p>
                            </div>
                        </div>

                        <!-- Display Toggle -->
                        <div
                            class="flex items-center gap-4 rounded-xl border border-white/10 bg-black/20 p-4"
                        >
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-500/20"
                            >
                                <Eye class="h-5 w-5 text-purple-400" />
                            </div>
                            <div class="flex-1">
                                <label
                                    for="display"
                                    class="block text-sm font-bold text-white"
                                    >Visibilité</label
                                >
                                <p class="text-xs text-gray-400">
                                    Rendre cette musique visible pour tous
                                </p>
                            </div>
                            <label
                                class="relative inline-flex cursor-pointer items-center"
                            >
                                <input
                                    type="checkbox"
                                    id="display"
                                    v-model="form.display"
                                    class="peer sr-only"
                                />
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-700 peer-checked:bg-purple-600 peer-focus:ring-4 peer-focus:ring-purple-800 peer-focus:outline-none after:absolute after:top-[2px] after:left-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white"
                                ></div>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 py-4 text-lg font-bold text-white shadow-lg shadow-purple-500/30 transition-all hover:scale-[1.02] hover:shadow-purple-500/50 disabled:opacity-50"
                            :disabled="form.processing"
                        >
                            <div
                                class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-1000 group-hover:translate-x-full"
                            ></div>
                            <span
                                class="relative flex items-center justify-center gap-2"
                            >
                                <Plus class="h-5 w-5" />
                                {{
                                    form.processing
                                        ? 'Création en cours...'
                                        : 'Créer la musique'
                                }}
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </template>
    </MusicLayout>
</template>

<script>
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, Eye, Music, Plus, Upload } from 'lucide-vue-next';

export default {
    name: 'Create',
    components: {
        MusicLayout,
        Link,
        ArrowLeft,
        Upload,
        Music,
        Plus,
        Eye,
    },
    data() {
        return {
            form: this.$inertia.form({
                title: '',
                artist: '',
                image: null,
                audio: null,
                display: true,
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(route('tracks.store'));
        },
    },
};
</script>
