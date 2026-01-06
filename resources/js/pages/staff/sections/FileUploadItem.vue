<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Paperclip } from 'lucide-vue-next';
import { ref } from 'vue';

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
    (e: 'uploadDate', selectedDate: string): void;
}

const props = defineProps<Props>();

const emit = defineEmits<Emits>();

const nameFile = ref(null);

const manageFile = (event: Event) => {
    nameFile.value = (event.target as HTMLInputElement).files[0]?.name || '';
    emit('upload', event, props.file.label);
};

const manageFileDate = (event: Event) => {
    const selectedDate = (event.target as HTMLInputElement).value;
    emit('uploadDate', selectedDate, props.index);
};
</script>

<template>
    <div
        class="group rounded-xl border border-zinc-200 bg-gradient-to-br from-white to-zinc-50/30 p-5 shadow-sm transition-all duration-300 hover:border-zinc-300 hover:shadow-lg"
    >
        <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <!-- Label y estado con icono mejorado -->
            <div class="flex items-center gap-4">
                <div
                    class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-md transition-transform duration-300 group-hover:scale-105"
                >
                    <Paperclip class="h-5 w-5 text-white" :stroke-width="2.5" />
                    <div
                        class="absolute -inset-1 rounded-xl bg-blue-500/20 opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-100"
                    ></div>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-zinc-900">{{ file.label }}</h3>
                    <p class="mt-0.5 flex items-center gap-1.5 text-xs text-zinc-500">
                        <span class="inline-block h-1 w-1 rounded-full bg-zinc-400"></span>
                        Formatos: PDF, JPEG
                    </p>
                </div>
            </div>

            <!-- Controles mejorados -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-3">
                <!-- Input File con diseño moderno -->
                <div class="relative">
                    <Input type="file" :id="`file-${index}`" class="hidden" accept="application/pdf, image/jpeg" @change="manageFile($event)" />
                    <label
                        :for="`file-${index}`"
                        class="group/btn relative flex cursor-pointer items-center gap-2.5 overflow-hidden rounded-lg border-2 border-zinc-200 bg-white px-5 py-2.5 text-sm font-medium text-zinc-700 transition-all duration-300 hover:border-blue-500 hover:bg-blue-50 hover:text-blue-700 active:scale-[0.98]"
                        :class="nameFile ? 'border-green-300 bg-green-50 text-green-700' : ''"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-500/0 via-blue-500/5 to-blue-500/0 opacity-0 transition-opacity duration-300 group-hover/btn:opacity-100"
                        ></div>
                        <i :class="nameFile ? 'ri-file-check-line' : 'ri-upload-cloud-line'" class="relative text-base"></i>
                        <span class="relative max-w-[180px] truncate">
                            {{ nameFile == null ? 'Seleccionar archivo' : nameFile }}
                        </span>
                    </label>
                </div>

                <!-- Input Date mejorado -->
                <div v-if="file.expirationDate === null" class="min-w-[200px]">
                    <label class="mb-1.5 block text-xs font-semibold tracking-wide text-zinc-600 uppercase"> Fecha de expiración </label>
                    <div class="relative">
                        <Input
                            type="date"
                            class="w-full rounded-lg border-2 border-zinc-200 bg-white px-3 py-2.5 text-sm font-medium text-zinc-700 transition-all duration-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                            @change="manageFileDate($event)"
                        />
                        <i class="ri-calendar-line pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-zinc-400"></i>
                    </div>
                </div>
                <div v-else-if="!file.expirationDate" class="flex items-center gap-2 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2">
                    <i class="ri-error-warning-line text-amber-600"></i>
                    <span class="text-sm font-medium text-amber-700">Sin fecha de expiración</span>
                </div>
                <div v-else class="flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2.5">
                    <i class="ri-calendar-check-line text-emerald-600"></i>
                    <span class="text-sm font-semibold text-emerald-700">{{ file.expirationDate }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
