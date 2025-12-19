<script setup lang="ts">
import { Input } from '@/components/ui/input';

interface Props {
    file: {
        label: string;
        file: any;
        expirationDate?: null | string;
    };
    index: number;
}

interface Emits {
    (e: 'upload', event: Event, label: string): void;
}

defineProps<Props>();
const emit = defineEmits<Emits>();
</script>

<template>
    <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm transition-all hover:shadow-md">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <!-- Label y estado -->
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50">
                    <i class="ri-file-text-line text-lg text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-medium text-zinc-900">{{ file.label }}</h3>
                    <p class="text-xs text-zinc-500">Formatos aceptados: PDF, JPEG</p>
                </div>
            </div>

            <!-- Controles -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-4">
                <!-- Input File con feedback visual -->
                <div class="relative">
                    <Input
                        type="file"
                        :id="`file-${index}`"
                        class="hidden"
                        accept="application/pdf, image/jpeg"
                        @change="emit('upload', $event, file.label)"
                    />
                    <label
                        :for="`file-${index}`"
                        class="flex cursor-pointer items-center gap-2 rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm font-medium text-zinc-700 transition-all hover:bg-zinc-50 hover:shadow-sm active:scale-95"
                    >
                        <i class="ri-upload-line"></i>
                        <span>Seleccionar archivo</span>
                    </label>
                </div>

                <!-- Input Date solo si aplica -->
                <div v-if="file.expirationDate === null" class="min-w-[180px]">
                    <label class="mb-1 block text-xs font-medium text-zinc-500"> Fecha de expiración </label>
                    <Input
                        type="date"
                        class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    />
                </div>
                <div v-else class="min-w-[180px]">
                    <label class="mb-1 block text-sm font-medium text-red-500"> Sin fecha de expiración </label>
                </div>
            </div>
        </div>
    </div>
</template>
