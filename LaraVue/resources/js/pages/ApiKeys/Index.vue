<template>
    <MusicLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Key class="h-8 w-8 text-purple-500" />
                <span class="text-white">Mes Clés API</span>
            </div>
        </template>

        <div class="mx-auto max-w-4xl py-6">
            <div
                class="relative overflow-hidden rounded-3xl border border-white/5 bg-[#191922]/50 p-8 shadow-2xl backdrop-blur-xl"
            >
                <div
                    class="pointer-events-none absolute top-0 right-0 -mt-20 -mr-20 h-64 w-64 rounded-full bg-purple-500/10 blur-3xl"
                ></div>
                <div
                    class="pointer-events-none absolute bottom-0 left-0 -mb-20 -ml-20 h-64 w-64 rounded-full bg-indigo-500/10 blur-3xl"
                ></div>

                <div class="relative z-10 mb-10">
                    <h3 class="mb-4 text-lg font-semibold text-white">
                        Générer une nouvelle clé
                    </h3>

                    <form
                        @submit.prevent="createKey"
                        class="flex flex-col gap-4 sm:flex-row"
                    >
                        <div class="group flex-1">
                            <input
                                v-model="form.name"
                                type="text"
                                placeholder="Nom de la clé"
                                class="block w-full rounded-xl border-2 border-transparent bg-[#121216] p-4 text-white placeholder-gray-600 shadow-inner transition-all focus:border-purple-500/50 focus:bg-[#191922] focus:ring-4 focus:ring-purple-500/10 focus:outline-none"
                                :class="{
                                    'border-red-500/50': form.errors.name,
                                }"
                            />
                            <p
                                v-if="form.errors.name"
                                class="mt-2 flex items-center gap-2 text-sm text-red-400"
                            >
                                <AlertCircle class="h-4 w-4" />
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="group relative flex items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-4 font-bold text-white shadow-lg shadow-purple-500/30 transition-all hover:scale-105 hover:shadow-purple-500/50 disabled:cursor-not-allowed disabled:opacity-50"
                            :disabled="form.processing"
                        >
                            <Plus
                                class="h-5 w-5 transition-transform group-hover:rotate-90"
                            />
                            <span>Générer</span>
                        </button>
                    </form>
                </div>

                <div
                    class="my-8 h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent"
                ></div>

                <div class="relative z-10">
                    <h3
                        class="mb-6 flex items-center justify-between text-lg font-semibold text-white"
                    >
                        <span>Clés Actives</span>
                        <span
                            class="rounded-full bg-white/5 px-2 py-1 text-xs font-normal text-gray-400"
                            >{{ apiKeys.length }} clés</span
                        >
                    </h3>

                    <ul class="space-y-4">
                        <li
                            v-if="apiKeys.length === 0"
                            class="rounded-2xl border-2 border-dashed border-white/5 py-10 text-center text-gray-500"
                        >
                            Aucune clé API pour le moment.
                        </li>

                        <li
                            v-for="key in apiKeys"
                            :key="key.id"
                            class="group relative flex flex-col gap-4 rounded-2xl border border-white/5 bg-white/5 p-5 transition-all hover:border-purple-500/30 hover:bg-white/10 sm:flex-row sm:items-center sm:justify-between"
                        >
                            <div class="min-w-0 flex-1">
                                <div class="mb-2 flex items-center gap-3">
                                    <span
                                        class="truncate text-lg font-bold text-white"
                                        >{{ key.name }}</span
                                    >
                                    <span
                                        class="rounded-full border border-gray-700 bg-black/40 px-2 py-0.5 text-[10px] tracking-wider text-gray-500 uppercase"
                                        >{{ key.slug }}</span
                                    >
                                </div>
                                <div
                                    class="rounded-lg border border-white/5 bg-black/30 p-2 font-mono text-sm break-all text-purple-300 transition-colors select-all hover:text-purple-200"
                                >
                                    {{ key.key }}
                                </div>
                            </div>

                            <div class="flex items-center gap-2 sm:self-center">
                                <Link
                                    :href="route('api-keys.edit', key)"
                                    class="rounded-lg border border-yellow-500/20 bg-yellow-500/10 p-2 text-yellow-500 transition-all hover:bg-yellow-500 hover:text-white"
                                    title="Modifier"
                                >
                                    <Edit2 class="h-4 w-4" />
                                </Link>

                                <button
                                    @click="deleteKey(key)"
                                    class="rounded-lg border border-red-500/20 bg-red-500/10 p-2 text-red-500 transition-all hover:bg-red-500 hover:text-white"
                                    title="Supprimer"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </MusicLayout>
</template>

<script>
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { AlertCircle, Edit2, Key, Plus, Trash2 } from 'lucide-vue-next';

export default {
    name: 'Index',
    components: {
        MusicLayout,
        Link,
        AlertCircle,
        Edit2,
        Key,
        Plus,
        Trash2,
    },
    props: {
        apiKeys: Array,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
            }),
        };
    },
    methods: {
        createKey() {
            this.form.post(route('api-keys.store'), {
                onSuccess: () => this.form.reset(),
            });
        },
        deleteKey(apiKey) {
            if (confirm('Voulez-vous vraiment supprimer cette clé API ?')) {
                this.$inertia
                    .form({})
                    .delete(route('api-keys.destroy', apiKey));
            }
        },
    },
};
</script>
