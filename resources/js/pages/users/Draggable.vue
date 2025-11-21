<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useDraggable } from '@vue-dnd-kit/core';

interface Props {
    user: {
        id: number;
        name: string;
        type: number;
        avatar?: string;
    };
}

const props = defineProps<Props>();

const emit = defineEmits<{
    (e: 'end'): void;
}>();

const { elementRef, handleDragStart, isDragging } = useDraggable({
    id: `user-${props.user.id}`,
    data: { user: props.user },
    events: {
        onEnd: () => emit('end'),
    },
});
</script>

<template>
    <div
        ref="elementRef"
        @pointerdown="handleDragStart"
        :class="[
            'my-2 flex cursor-pointer flex-row items-center gap-3 rounded-md p-3 text-white shadow-sm transition select-none',
            {
                dragging: isDragging,
            },
            props.user.type == 2 ? 'bg-green-500' : props.user.type == 3 ? 'bg-red-500' : 'bg-gray-600',
        ]"
        tabindex="0"
        role="button"
        aria-grabbed="false"
        :aria-pressed="isDragging"
    >
        <Avatar>
            <AvatarImage :src="props.user.avatar ?? 'https://github.com/shadcn.png'" />
            <AvatarFallback>{{ props.user.name.charAt(0).toUpperCase() }}</AvatarFallback>
        </Avatar>

        <p class="font-medium tracking-wide">
            {{ props.user.name }}
        </p>
    </div>
</template>

<style scoped>
.dragging {
    opacity: 0.7;
    transform: scale(0.97);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
}
</style>
