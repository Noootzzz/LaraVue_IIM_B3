<template>
    <div
        class="group relative flex flex-col gap-4 transition-all duration-500 hover:-translate-y-2 hover:scale-[1.02]"
    >
        <!-- Image Container -->
        <div
            class="relative aspect-square w-full overflow-hidden rounded-2xl bg-muted shadow-lg ring-1 ring-border transition-all duration-500 group-hover:shadow-2xl group-hover:shadow-purple-500/30 group-hover:ring-purple-500/20"
        >
            <img
                class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-110 group-hover:rotate-2"
                :src="`/storage/${track.image}`"
                :alt="track.title"
            />

            <!-- Gradient Overlay -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
            ></div>

            <!-- Shine Effect -->
            <div
                class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/10 to-transparent transition-transform duration-1000 group-hover:translate-x-full"
            ></div>

            <!-- Play Button Overlay -->
            <div
                class="absolute inset-0 flex items-center justify-center opacity-0 transition-all duration-500 group-hover:opacity-100"
            >
                <button
                    @click="handleClick"
                    class="flex h-16 w-16 translate-y-4 transform items-center justify-center rounded-full bg-white/10 text-white shadow-xl shadow-black/50 backdrop-blur-md transition-all duration-300 group-hover:translate-y-0 hover:scale-110 hover:bg-white hover:text-black"
                >
                    <Play class="ml-1 h-8 w-8 fill-current" />
                </button>
            </div>

            <!-- Actions -->
            <div
                class="absolute top-3 right-3 flex translate-y-[-10px] gap-2 opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100"
            >
                <Link
                    :href="route('tracks.edit', track)"
                    v-if="$page.props.isAdmin"
                    class="rounded-full bg-black/40 p-2.5 text-white backdrop-blur-md transition-colors hover:bg-purple-600 hover:text-white"
                    title="Modifier"
                >
                    <Edit class="h-4 w-4" />
                </Link>
                <Link
                    :href="route('tracks.destroy', track)"
                    v-if="$page.props.isAdmin"
                    method="delete"
                    as="button"
                    preserve-scroll
                    class="rounded-full bg-black/40 p-2.5 text-white backdrop-blur-md transition-colors hover:bg-red-500 hover:text-white"
                    title="Supprimer"
                >
                    <Trash2 class="h-4 w-4" />
                </Link>
            </div>
        </div>

        <!-- Text Info -->
        <div class="flex flex-col gap-1 px-1">
            <h3
                class="truncate text-lg font-bold text-foreground transition-colors group-hover:text-purple-400"
                :title="track.title"
            >
                {{ track.title }}
            </h3>
            <p
                class="truncate text-sm font-medium text-muted-foreground transition-colors group-hover:text-foreground"
                :title="track.artist"
            >
                {{ track.artist }}
            </p>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { Edit, Play, Trash2 } from 'lucide-vue-next';

export default {
    name: 'Track',
    emits: ['listen'],
    props: {
        track: Object,
    },
    components: {
        Link,
        Play,
        Edit,
        Trash2,
    },
    methods: {
        handleClick() {
            this.$emit('listen', this.track);
        },
    },
};
</script>
