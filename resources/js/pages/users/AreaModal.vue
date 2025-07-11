<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Cafe, Headquarter } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { LampDesk } from 'lucide-vue-next';
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
        <DialogTrigger
            ><Button title="Agregar Area" class="h-full w-auto bg-blue-400"><LampDesk /></Button
        ></DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Nueva Area</DialogTitle>
                <Input v-model="form.name" type="text" placeholder="Nombre" />
            </DialogHeader>
            <div class="flex flex-row">
                <Select v-model="form.cafe_id">
                    <SelectTrigger>
                        <SelectValue placeholder="Selecciona una cafetería" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Cafeterías</SelectLabel>
                            <SelectItem v-for="cafe in props.cafes" :value="cafe.id" :key="cafe.id"> {{ cafe.name }} </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <p class="p-2">o</p>
                <Select v-model="form.headquarter_id">
                    <SelectTrigger>
                        <SelectValue placeholder="Selecciona una sede" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Sedes</SelectLabel>
                            <SelectItem v-for="headquarter in headquarters" :value="headquarter.id" :key="headquarter.id">
                                {{ headquarter.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>

            <DialogFooter @click="submit"> Agregar </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
