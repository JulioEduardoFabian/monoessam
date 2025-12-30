<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import FileUploadItem from '../sections/FileUploadItem.vue';

interface Props {
    filesRequired: any[];
    showAlert: boolean;
    alertMessage: string;
    form: any;
}

interface Emits {
    (e: 'upload-file', event: Event, label: string, files: any[]): void;
    (e: 'upload-date', selectedDate: string, index: number): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const handleUpload = (event: Event, label: string) => {
    emit('upload-file', event, label, props.form.files);
};

const dateUpload = (selectedDate: string, index: number) => {
    emit('upload-date', selectedDate, index);
};
</script>

<template>
    <div class="space-y-4">
        <!-- Alerta informativa -->
        <div class="mb-4 flex items-center rounded-lg border border-amber-200 bg-amber-50 p-3 text-sm text-amber-800" role="alert">
            <svg
                class="mr-3 inline h-4 w-4 flex-shrink-0"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 20 20"
            >
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
                />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Atención!</span>
                Asegúrese de que los archivos sean legibles (PDF o JPG) y que pesen menos de 10MB.
            </div>
        </div>

        <!-- Alerta de error -->
        <Alert v-if="showAlert" variant="destructive" class="relative mb-4">
            <button class="absolute top-3 right-3 text-sm" @click="$emit('update:showAlert', false)">✕</button>
            <AlertTitle>Error</AlertTitle>
            <AlertDescription>{{ alertMessage }}</AlertDescription>
        </Alert>

        <!-- Lista de archivos -->
        <div class="space-y-4">
            <FileUploadItem
                v-for="(file, index) in filesRequired"
                :key="index"
                :file="file"
                :index="index"
                @upload="handleUpload"
                @uploadDate="dateUpload"
            />
        </div>
    </div>
</template>
