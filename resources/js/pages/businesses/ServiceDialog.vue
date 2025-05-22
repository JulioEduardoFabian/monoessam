<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { CirclePlus } from 'lucide-vue-next';
import { ref } from 'vue';

const open = ref(false);

const submit = () => {
    // Assuming you have a function to handle the form submission
    // You can use the form data here
    console.log('Form submitted');
};
</script>
<template>
    <Dialog v-model:open="open">
        <DialogTrigger
            ><Button title="Agregar Servicio" class="h-full w-auto bg-blue-400"><CirclePlus /></Button
        ></DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Insertar Servicio </DialogTitle>
            </DialogHeader>
            <DialogFooter @click="submit"> Agregar </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
