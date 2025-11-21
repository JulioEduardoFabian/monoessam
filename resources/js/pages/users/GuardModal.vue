<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Cafe, Headquarter } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    cafes: {
        type: Array as () => Cafe[],
        required: true,
    },
    headquarters: {
        type: Array as () => Headquarter[],
        required: true,
    },
});

const open = ref(false);

const form = useForm({
    name: '',
    cafe_id: null,
    headquarter_id: null,
});

const submit = () => {
    form.post(route('areas'), {
        onSuccess: () => {
            open.value = false;
            form.reset();
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger><Button class="h-full w-auto bg-green-500 text-white hover:bg-green-600"> Agregar guardia </Button></DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Nueva guardia</DialogTitle>
                <Input v-model="form.name" type="text" placeholder="Nueva guardia" />
            </DialogHeader>

            <DialogFooter @click="submit"> Agregar </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
