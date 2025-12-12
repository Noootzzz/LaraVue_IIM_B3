<template>
    <MusicLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Edit3 class="h-8 w-8 text-purple-500" />
                <span class="text-white"
                    >Modifier la clé : {{ apiKey.slug }}</span
                >
            </div>
        </template>

        <template #actions>
            <Link
                :href="route('api-keys.index')"
                class="flex items-center gap-2 rounded-xl bg-white/5 px-4 py-2 font-semibold text-white backdrop-blur-md transition-all hover:scale-105 hover:bg-white/10 hover:text-purple-400"
            >
                <ArrowLeft class="h-5 w-5" />
                <span>Retour</span>
            </Link>
        </template>

        <div class="mx-auto max-w-4xl py-6">
            <form @submit.prevent="submit">
                <div
                    class="relative overflow-hidden rounded-3xl border border-white/5 bg-[#191922]/50 p-8 shadow-2xl backdrop-blur-xl"
                >
                    <div
                        class="pointer-events-none absolute top-0 right-0 -mt-20 -mr-20 h-64 w-64 rounded-full bg-purple-500/20 blur-3xl"
                    ></div>
                    <div
                        class="pointer-events-none absolute bottom-0 left-0 -mb-20 -ml-20 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl"
                    ></div>

                    <div class="group relative z-10 mb-8">
                        <label
                            for="name"
                            class="mb-3 block text-sm font-bold tracking-wider text-gray-400 uppercase transition-colors group-focus-within:text-purple-400"
                        >
                            Nom de la clé
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            placeholder="Ex: Application Mobile"
                            class="block w-full rounded-xl border-2 border-transparent bg-[#121216] p-4 text-xl text-white placeholder-gray-600 shadow-inner transition-all focus:border-purple-500/50 focus:bg-[#191922] focus:ring-4 focus:ring-purple-500/10 focus:outline-none"
                            :class="{
                                'border-red-500/50 focus:border-red-500':
                                    form.errors.name,
                            }"
                        />
                        <p
                            v-if="form.errors.name"
                            class="mt-2 flex items-center gap-2 text-sm text-red-400"
                        >
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-red-500"
                            ></span>
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div
                        class="relative z-10 flex items-center justify-between border-t border-white/5 pt-6"
                    >
                        <div class="text-sm text-gray-500">
                            Clé créée le
                            {{
                                new Date(apiKey.created_at).toLocaleDateString()
                            }}
                        </div>

                        <button
                            type="submit"
                            class="group relative flex items-center gap-2 overflow-hidden rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-3 font-bold text-white shadow-lg shadow-purple-500/30 transition-all hover:scale-105 hover:shadow-purple-500/50 disabled:cursor-not-allowed disabled:opacity-50"
                            :disabled="form.processing"
                        >
                            <span>Mettre à jour</span>
                            <Save
                                class="h-5 w-5 transition-transform group-hover:scale-110"
                            />
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </MusicLayout>
</template>

<script>
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, Edit3, Save } from 'lucide-vue-next';

export default {
    name: 'EditApiKey',
    components: {
        MusicLayout,
        Link,
        ArrowLeft,
        Save,
        Edit3,
    },
    props: {
        apiKey: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.apiKey.name,
            }),
        };
    },
    methods: {
        submit() {
            this.form.put(route('api-keys.update', this.apiKey));
        },
    },
};
</script>
