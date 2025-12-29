<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { ref } from 'vue';
import AlertErrors from '../users/AlertErrors.vue';
import { useFileUpload } from './composables/useFileUpload';
import { useImageUpload } from './composables/useImageUpload';
import { useStaffForm } from './composables/useStaffForm';
import AttachmentsTab from './tabs/AttachmentsTab.vue';
import FinancialDataTab from './tabs/FinancialDataTab.vue';
import PersonalDataTab from './tabs/PersonalDataTab.vue';
import SizesTab from './tabs/SizesTab.vue';

interface Props {
    cafes: any[];
    roles: any[];
}

const props = defineProps<Props>();

const isOpen = ref(false);
const activeTab = ref('personal');

const { form, errorsSend, showErrors, prendasFijas, handleSubmit, selectCafe, selectRole, handleDateFile: dateUpload } = useStaffForm();

const { fileInput, imagePreview, triggerFileInput, handleImageUpload, removeImage } = useImageUpload();

const { filesRequired, showAlert, alertMessage, handleFileUpload: uploadFile } = useFileUpload();

const nextTab = () => {
    const tabs = ['personal', 'adjuntos', 'financiero', 'tallas'];
    const currentIndex = tabs.indexOf(activeTab.value);
    if (currentIndex < tabs.length - 1) {
        activeTab.value = tabs[currentIndex + 1];
    }
};

const prevTab = () => {
    const tabs = ['personal', 'adjuntos', 'financiero', 'tallas'];
    const currentIndex = tabs.indexOf(activeTab.value);
    if (currentIndex > 0) {
        activeTab.value = tabs[currentIndex - 1];
    }
};

const onSubmit = () => {
    console.log(filesRequired);

    handleSubmit(() => {
        isOpen.value = false;
        activeTab.value = 'personal';
    }, filesRequired);
};
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogTrigger as-child>
            <Button variant="default" class="cursor-pointer bg-blue-600 text-white hover:bg-blue-700"> Nuevo Personal </Button>
        </DialogTrigger>

        <DialogContent class="flex h-[90vh] flex-col gap-0 overflow-hidden p-0 sm:max-w-5xl">
            <input type="file" ref="fileInput" @change="handleImageUpload" accept="image/*" class="hidden" />

            <DialogHeader class="z-10 border-b bg-white px-6 py-4">
                <DialogTitle class="text-xl font-bold text-zinc-800 md:text-2xl"> Ficha de Registro de Colaborador </DialogTitle>
                <DialogDescription> Complete los datos del proceso de alta en las secciones a continuación. </DialogDescription>
                <AlertErrors :show="showErrors" :errors="errorsSend" />
            </DialogHeader>

            <div class="flex-1 overflow-y-auto bg-gray-50/50 px-6 py-4">
                <Tabs v-model="activeTab" class="w-full">
                    <TabsList class="mb-6 grid w-full grid-cols-4 bg-zinc-100 p-1">
                        <TabsTrigger value="personal" class="text-xs md:text-sm">1. Personal</TabsTrigger>
                        <TabsTrigger value="adjuntos" class="text-xs md:text-sm">2. Adjuntos</TabsTrigger>
                        <TabsTrigger value="financiero" class="text-xs md:text-sm">3. Financiero</TabsTrigger>
                        <TabsTrigger value="tallas" class="text-xs md:text-sm">4. Tallas</TabsTrigger>
                    </TabsList>

                    <TabsContent value="personal" class="mt-0">
                        <PersonalDataTab
                            :form="form"
                            :cafes="cafes"
                            :image-preview="imagePreview"
                            @trigger-upload="triggerFileInput"
                            @remove-image="removeImage"
                            @select-cafe="selectCafe"
                        />
                    </TabsContent>

                    <TabsContent value="adjuntos" class="mt-0">
                        <AttachmentsTab
                            :files-required="filesRequired"
                            :show-alert="showAlert"
                            :alert-message="alertMessage"
                            :form="form"
                            @upload-file="uploadFile"
                            @upload-date="dateUpload"
                        />
                    </TabsContent>

                    <TabsContent value="financiero" class="mt-0">
                        <FinancialDataTab :form="form" :roles="roles" @select-role="selectRole" @upload-file="uploadFile" />
                    </TabsContent>

                    <TabsContent value="tallas" class="mt-0">
                        <SizesTab :prendas="prendasFijas" />
                    </TabsContent>
                </Tabs>
            </div>

            <DialogFooter class="z-10 flex w-full flex-row items-center justify-between border-t bg-white px-6 py-4">
                <div>
                    <Button v-if="activeTab !== 'personal'" @click="prevTab" variant="outline" type="button"> ← Anterior </Button>
                </div>
                <div>
                    <Button v-if="activeTab !== 'tallas'" @click="nextTab" type="button" class="bg-blue-600 text-white hover:bg-blue-700">
                        Siguiente →
                    </Button>
                    <Button v-else @click="onSubmit" type="button" class="bg-green-600 text-white hover:bg-green-700"> Finalizar Registro </Button>
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
