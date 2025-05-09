<script setup lang="ts">
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

const mines = ref([]);
const open = ref(false);

const form = useForm({
    mine: '',
    unit: '',
    cafe: '',
});

const submit = () => {
    /* form.post(route('users'), {
        onSuccess: () => {
            open.value = false;
            form.reset();
        },
    }); */
};

const searchMine = () => {
    if (form.name == []) {
        mines.value = [];
    }
    axios
        .get('/search-mine/' + form.mine)
        .then((result) => {
            mines.value = result.data;
        })
        .catch((err) => {
            console.log(err);
        });
};

const insertMine = () => {};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger>Añadir Lugar</DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <div class=""></div>
                <DialogTitle>Agregar Lugar</DialogTitle>
                <div className="flex z-40 w-full max-w-sm items-center space-x-2">
                    <Input v-model="form.mine" type="text" placeholder="Mina" @keyup="searchMine" />
                    <Button type="submit" @click="insertMine">+</Button>
                </div>
                <ul class="h-5 w-full">
                    <li class="rounded border p-1" v-for="mine in mines" :key="mine.id">{{ mine.name }}</li>
                </ul>
                <div className="flex w-full max-w-sm items-center space-x-2">
                    <Input v-model="form.unit" type="text" placeholder="Unidad" @keyup="searchUnit" />
                    <Button type="submit" @click="insertUnit">+</Button>
                </div>
                <div className="flex w-full max-w-sm items-center space-x-2">
                    <Input v-model="form.cafe" type="text" placeholder="Cafetería" @keyup="searchCafe" />
                    <Button type="submit" @click="insertCafe">+</Button>
                </div>
            </DialogHeader>
            <DialogFooter @click="submit"> Agregar </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
