<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useDraggable } from '@vue-dnd-kit/core';
import { ref } from 'vue';

interface Props {
    user: {
        id: number;
        name: string;
        type: number;
        avatar?: string;
    };
}

const message = ref('Drag the item to the drop zone');
const isDropped = ref(false);

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
        class="user-card"
        :class="{ dragging: isDragging, dropped: isDropped }"
        tabindex="0"
        role="button"
        aria-grabbed="false"
        :aria-pressed="isDragging"
        :title="`Arrastrar ${props.user.name}`"
    >
        <div class="user-avatar">
            <Avatar>
                <AvatarImage :src="props.user.avatar ?? 'https://github.com/shadcn.png'" :alt="`Avatar de ${props.user.name}`" />
                <AvatarFallback class="avatar-fallback">
                    {{ props.user.name.charAt(0).toUpperCase() }}
                </AvatarFallback>
            </Avatar>
        </div>

        <div class="user-info">
            <p class="user-name">
                {{ props.user.name }}
            </p>
            <span class="user-type">
                {{ props.user.type === 1 ? 'Administrador' : 'Usuario' }}
            </span>
        </div>

        <div class="drag-indicator">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M8 6h8M8 12h8M8 18h8" />
            </svg>
        </div>
    </div>
</template>

<style scoped>
.user-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    cursor: grab;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
}

.user-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
    opacity: 0;
    transition: opacity 0.25s ease;
}

.user-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.user-card:hover::before {
    opacity: 1;
}

.user-card:active {
    cursor: grabbing;
}

.user-avatar {
    flex-shrink: 0;
}

.user-info {
    flex: 1;
    min-width: 0;
}

.user-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.9rem;
    margin: 0 0 2px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-type {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 500;
}

.drag-indicator {
    color: #94a3b8;
    opacity: 0.6;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.user-card:hover .drag-indicator {
    opacity: 1;
    color: #475569;
}

/* Estados de arrastre */
.dragging {
    opacity: 0.85;
    transform: scale(0.98) rotate(1deg);
    box-shadow:
        0 8px 25px rgba(0, 0, 0, 0.15),
        0 0 0 2px #3b82f6;
    cursor: grabbing;
    border-color: #3b82f6;
}

.dragging::before {
    opacity: 1;
}

.dragging .drag-indicator {
    opacity: 1;
    color: #3b82f6;
}

.dragging .user-name {
    color: #3b82f6;
}

/* Estado cuando se ha soltado */
.dropped {
    background: #f0fdf4;
    border-color: #bbf7d0;
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.15);
}

.dropped::before {
    background: linear-gradient(to bottom, #10b981, #22c55e);
    opacity: 1;
}

/* Mejoras para el avatar */
.avatar-fallback {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    color: white;
    font-weight: 600;
}

/* Estados de focus para accesibilidad */
.user-card:focus {
    outline: none;
    box-shadow:
        0 0 0 3px rgba(59, 130, 246, 0.1),
        0 4px 12px rgba(0, 0, 0, 0.08);
    border-color: #3b82f6;
}

.user-card:focus::before {
    opacity: 1;
}

/* Responsive */
@media (max-width: 640px) {
    .user-card {
        padding: 10px 12px;
        gap: 10px;
    }

    .user-name {
        font-size: 0.85rem;
    }

    .user-type {
        font-size: 0.7rem;
    }

    .drag-indicator {
        width: 14px;
        height: 14px;
    }
}

/* Animación sutil al aparecer */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.user-card {
    animation: slideIn 0.3s ease-out;
}
</style>
