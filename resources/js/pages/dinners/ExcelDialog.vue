<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import { useForm } from '@inertiajs/vue3';
import { Sheet } from 'lucide-vue-next';
import { ref } from 'vue';

const open = ref(false);

const form = useForm({
    file: null,
});

const handleFileChange = (event) => {
    form.file = event.target.files[0]; // Asigna el archivo seleccionado al form
};

const submit = () => {
    // Verifica que se haya seleccionado un archivo
    if (!form.file) {
        alert('Por favor selecciona un archivo');
        return;
    }

    // Crea un FormData para enviar el archivo
    const formData = new FormData();
    formData.append('file', form.file);

    // Envía el formulario
    form.post(route('dinners.excel'), {
        data: formData,
        onSuccess: () => {
            open.value = false;
            form.reset();
        },
        onError: (errors) => {
            console.error('Error al subir el archivo:', errors);
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger>
            <Button title="Agregar comensales" class="bg-green-600"><Sheet /></Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Insertar Comensales</DialogTitle>
            </DialogHeader>
            <Input type="file" @change="handleFileChange" placeholder="Selecciona un archivo Excel" class="mb-1" accept=".xlsx,.xls,.csv" />
            <DialogFooter>
                <Button @click="submit">Registrar</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
