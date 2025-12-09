<template>
    <div>
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">
                    <div
                        class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start"
                    >
                        <div class="flex flex-shrink-0 items-center">
                            <img
                                class="h-8 w-auto"
                                src="/images/littlelogo.png"
                            />
                        </div>
                        <div class="hidden sm:ml-6 sm:block">
                            <div class="flex space-x-4">Liens</div>
                        </div>
                    </div>
                    <div
                        class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
                    >
                        Login / Register
                    </div>
                </div>
            </div>
        </nav>

        <div
            class="fixed right-4 bottom-4 z-50 flex w-full max-w-md flex-col gap-2"
        >
            <transition-group name="list" tag="div" class="flex flex-col gap-2">
                <div
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="flex items-center gap-4 rounded-lg border border-border bg-background p-4 shadow-lg transition-all duration-300 ease-in-out"
                >
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-green-600"
                    >
                        <CheckCircle class="h-5 w-5" />
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-foreground">
                            Succès
                        </h4>
                        <p class="text-sm text-muted-foreground">
                            {{ notification.message }}
                        </p>
                    </div>
                    <button
                        @click="removeNotification(notification.id)"
                        class="rounded-md p-1 text-muted-foreground transition-colors hover:bg-accent hover:text-foreground"
                    >
                        <X class="h-4 w-4" />
                    </button>
                </div>
            </transition-group>
        </div>

        <div class="px-16">
            <div class="flex items-center justify-between">
                <h4 class="my-6 text-3xl font-bold">
                    <slot name="title" />
                </h4>
                <div>
                    <slot name="actions" />
                </div>
            </div>
            <slot name="content" />
        </div>
    </div>
</template>

<script>
import { CheckCircle, X } from 'lucide-vue-next';

export default {
    name: 'MusicLayout',
    components: {
        CheckCircle,
        X,
    },
    data() {
        return {
            notifications: [],
        };
    },
    watch: {
        '$page.props.flash.success': {
            handler(newValue) {
                if (newValue) {
                    this.addNotification(newValue);
                }
            },
            immediate: true,
        },
    },
    methods: {
        addNotification(message) {
            const id = Date.now() + Math.random();
            this.notifications.push({
                id,
                message,
            });
            setTimeout(() => {
                this.removeNotification(id);
            }, 5000);
        },
        removeNotification(id) {
            this.notifications = this.notifications.filter((n) => n.id !== id);
        },
    },
};
</script>
