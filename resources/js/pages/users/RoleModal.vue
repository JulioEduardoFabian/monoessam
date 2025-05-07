<script setup lang="ts">
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const open = ref(false);

const form = useForm({
    name: '',
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('roles'), {
        onSuccess: () => {
            open.value = false;
            form.reset();
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger>Añadir Rol</DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Agregar Rol</DialogTitle>
                <Input v-model="form.name" type="text" placeholder="Nombre" />
            </DialogHeader>
            <DialogFooter @click="submit"> Agregar </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
