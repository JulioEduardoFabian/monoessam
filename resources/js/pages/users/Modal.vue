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
    form.post(route('users'), {
        onSuccess: () => {
            open.value = false;
            form.reset();
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger>Añadir usuario</DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Agregar Usuario</DialogTitle>
                <Input v-model="form.name" type="text" placeholder="Nombre" />
                <Input v-model="form.email" type="email" placeholder="Email" />
                <Input v-model="form.password" type="password" placeholder="Contraseña" />
            </DialogHeader>
            <DialogFooter @click="submit"> Agregar </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
