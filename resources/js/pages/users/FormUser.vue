<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Cafe } from '@/types';
import axios from 'axios';
import { X } from 'lucide-vue-next';
import { ref } from 'vue';
import InputSearchSelectable from './InputSearchSelectable.vue';

interface Props {
    cafes: Cafe[];
}

const props = defineProps<Props>();

// Estado para controlar si el modal está abierto
const isOpen = ref(false);
const activeTab = ref('personal');
const fileInput = ref<HTMLInputElement | null>(null);
const imagePreview = ref<string | null>(null);
const selectedFile = ref<File | null>(null);
// Datos del formulario
const formData = ref({
    // Personal
    nombre: '',
    apellidos: '',
    documento: '',
    codColaborador: '',
    fechaNacimiento: '',
    edad: 0,
    email: '',
    estadoCivil: '',
    sexo: '',
    nacionalidad: '',
    celular: '',
    lugarNacimiento: { pais: '', dpto: '', prov: '', dist: '' },
    // Contacto Emergencia
    emergenciaNombre: '',
    emergenciaParentesco: '',
    emergenciaTelefono: '',
    // Domicilio
    tipoDomicilio: 'permanente',
    domicilio: { tipoVia: '', nombreVia: '', numero: '', interior: '', urb: '', ref: '' },
    contactoDomicilio: { pais: '', dpto: '', prov: '', dist: '' },
    // Estudios
    gradoEstudios: '',
    institucion: '',
    titulo: '',
    especialidad: '',
    colegiatura: '',
    // Laboral
    tipoContrato: '',
    regimenLaboral: '',
    cargo: '',
    area: '',
    sede: '',
    tipoRegimen: '',
    operaciones: '',
    // Control
    puntosControl: ['VICTOR 3'],
    prendas: [] as string[],
    // Adjuntos
    adjuntos: {},
    fechaIngreso: '',
    fechaFinContract: '',
    children: 0,
    cafeId: 0,
});

const prendasFijas = ref([
    { label: 'Chaqueta Blanca', talla: '' },
    { label: 'Pantalón', talla: '' },
    { label: 'Camisa/Blusa', talla: '' },
    { label: 'Zapato', talla: '' },
    { label: 'Botas Blancas', talla: '' },
    { label: 'Overall', talla: '' },
    { label: 'Casaca', talla: '' },
    { label: 'Guantes', talla: '' },
    { label: 'Guardapolvo', talla: '' },
    { label: 'Chaleco', talla: '' },
    { label: 'Polo', talla: '' },
    { label: 'Cafarena', talla: '' },
    { label: 'Lentes', talla: '' },
]);

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

const handleSubmit = () => {
    axios
        .post('/staff', formData.value)
        .then((result) => {
            console.log('Formulario enviado:', formData.value);
            isOpen.value = false; // Cerrar modal al guardar
        })
        .catch((err) => {
            console.error(err);
        });
};

const handleCheckboxChange = (prenda, checked) => {
    if (checked) {
        // Si se marca, agregar objeto con nombre y talla vacía
        if (!formData.value.prendas.some((p) => p === prenda)) {
            formData.value.prendas.push({
                nombre: prenda,
                talla: '', // Espacio en blanco para la talla
            });
        }
    } else {
        // Si se desmarca, eliminar el objeto
        const index = formData.value.prendas.findIndex((p) => p.nombre === prenda);
        if (index > -1) {
            formData.value.prendas.splice(index, 1);
        }
    }
};

const controlCheck = () => {
    console.log('test');
};

// Método para actualizar talla específica
const actualizarTalla = (index, event) => {
    formData.value.prendas[index].talla = event.target.value;
};

// Método para eliminar prenda
const eliminarPrenda = (index) => {
    formData.value.prendas.splice(index, 1);
};

// Método para verificar si una prenda está seleccionada (para el checkbox)
const isPrendaSelected = (nombrePrenda) => {
    return formData.value.prendas.some((p) => p.nombre === nombrePrenda);
};

const triggerFileInput = () => {
    fileInput.value?.click();
};

const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        // Validar tipo de archivo
        if (!file.type.startsWith('image/')) {
            alert('Por favor, selecciona solo archivos de imagen');
            return;
        }

        // Validar tamaño (ej: máximo 5MB)
        const maxSize = 5 * 1024 * 1024; // 5MB en bytes
        if (file.size > maxSize) {
            alert('La imagen es demasiado grande. Máximo 5MB');
            return;
        }

        selectedFile.value = file;

        // Crear preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);

        // Emitir evento si es necesario
        // emit('image-uploaded', file);
    }
};

const removeImage = () => {
    imagePreview.value = null;
    selectedFile.value = null;

    // Resetear input file
    if (fileInput.value) {
        fileInput.value.value = '';
    }

    // Emitir evento si es necesario
    // emit('image-removed');
};

const selectCafe = (cafe: Cafe) => {
    formData.value.cafeId = cafe.id;
};

const MAX_FILE_SIZE = 9 * 1024 * 1024; // 5MB example
const showAlert = ref(false);
const alertMessage = ref('');
const handleFileUpload = (event: any) => {
    const files = event.target.files;
    if (files.length > 0) {
        const file = files[0];
        if (file.size > MAX_FILE_SIZE) {
            alertMessage.value = 'El archivo es demasiado grande. El máximo es 9MB.';
            showAlert.value = true;

            event.target.value = null; // limpiar input
        }
    }
};
</script>

<template>
    <Dialog v-model:open="isOpen">
        <!-- Botón que abre el Modal -->
        <DialogTrigger as-child>
            <Button variant="default" class="bg-blue-600 text-white hover:bg-blue-700">Nuevo Personal</Button>
        </DialogTrigger>

        <!-- Contenido del Modal -->
        <!-- 'max-w-5xl' para hacerlo ancho, 'h-[90vh]' para altura casi completa, 'flex-col' para layout interno -->
        <DialogContent class="flex h-[90vh] flex-col gap-0 overflow-hidden p-0 sm:max-w-5xl">
            <!-- Encabezado Fijo -->
            <DialogHeader class="z-10 border-b bg-white px-6 py-4">
                <DialogTitle class="text-xl font-bold text-zinc-800 md:text-2xl"> Ficha de Registro de Colaborador </DialogTitle>
                <DialogDescription> Complete los datos del proceso de alta en las secciones a continuación. </DialogDescription>
            </DialogHeader>

            <!-- Cuerpo Scrolleable (Aquí va el formulario pesado) -->
            <div class="flex-1 overflow-y-auto bg-gray-50/50 px-6 py-4">
                <Tabs v-model="activeTab" class="w-full">
                    <!-- Navegación de Pestañas -->
                    <TabsList class="mb-6 grid w-full grid-cols-4 bg-zinc-100 p-1">
                        <TabsTrigger value="personal" class="text-xs md:text-sm">1. Personal</TabsTrigger>
                        <TabsTrigger value="adjuntos" class="text-xs md:text-sm">2. Adjuntos</TabsTrigger>
                        <TabsTrigger value="financiero" class="text-xs md:text-sm">3. Financiero</TabsTrigger>
                        <!--  <TabsTrigger value="laboral" class="text-xs md:text-sm">4. Laboral</TabsTrigger> -->
                        <TabsTrigger value="tallas" class="text-xs md:text-sm">4. Tallas</TabsTrigger>
                    </TabsList>

                    <!-- PESTAÑA 1: Datos Personales -->
                    <TabsContent value="personal" class="mt-0 space-y-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                            <!-- Foto -->
                            <div class="flex flex-col items-center space-y-3 rounded-lg border bg-white p-4 shadow-sm md:col-span-1">
                                <div class="relative">
                                    <img
                                        :src="imagePreview || 'https://placehold.co/150x200/52525B/FFFFFF?text=FOTO'"
                                        alt="Foto Colaborador"
                                        class="h-40 w-32 rounded-md border object-cover shadow-sm"
                                    />

                                    <!-- Botón para eliminar imagen (opcional) -->
                                    <button
                                        v-if="imagePreview"
                                        @click="removeImage"
                                        type="button"
                                        class="absolute -top-2 -right-2 rounded-full bg-red-500 p-1 text-white shadow-sm hover:bg-red-600"
                                    >
                                        <X :size="14" />
                                    </button>
                                </div>

                                <!-- Input file oculto y botón personalizado -->
                                <div class="relative w-full">
                                    <input type="file" ref="fileInput" @change="handleImageUpload" accept="image/*" class="hidden" id="file-upload" />
                                    <Button variant="outline" size="sm" class="w-full" @click="triggerFileInput" type="button">
                                        {{ imagePreview ? 'Cambiar Foto' : 'Subir Foto' }}
                                    </Button>
                                </div>
                                <Input placeholder="Cód. Colaborador" v-model="formData.codColaborador" class="text-center" />
                                <InputSearchSelectable :cafes="props.cafes" @selectCafe="selectCafe" />
                            </div>

                            <!-- Datos Texto -->
                            <div class="space-y-4 md:col-span-3">
                                <h3 class="border-b pb-2 text-lg font-semibold text-zinc-700">Datos Generales</h3>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                                    <div class="space-y-1">
                                        <Label for="nombres">Nombre Completo</Label>
                                        <Input id="nombres" v-model="formData.nombre" />
                                    </div>
                                    <div class="space-y-1">
                                        <Label for="doc">DNI / C.E.</Label>
                                        <Input id="doc" v-model="formData.documento" />
                                    </div>
                                    <div class="space-y-1">
                                        <Label for="cel">Celular</Label>
                                        <Input id="cel" v-model="formData.celular" />
                                    </div>
                                    <div class="space-y-1">
                                        <Label>F. Nacimiento</Label>
                                        <Input type="date" v-model="formData.fechaNacimiento" />
                                    </div>
                                    <div class="space-y-1">
                                        <Label for="age">Edad</Label>
                                        <Input id="age" v-model="formData.edad" />
                                    </div>
                                    <div class="space-y-1">
                                        <Label>Sexo</Label>
                                        <Select v-model="formData.sexo">
                                            <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="1">Masculino</SelectItem>
                                                <SelectItem value="2">Femenino</SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>

                                    <div class="space-y-1">
                                        <Label>Email</Label>
                                        <Input v-model="formData.email" />
                                    </div>
                                    <div class="space-y-1">
                                        <Label>Nacionalidad</Label>
                                        <Input v-model="formData.nacionalidad" />
                                    </div>
                                    <div class="space-y-1">
                                        <Label>Estado Civil</Label>
                                        <Select v-model="formData.estadoCivil">
                                            <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="1">Soltero</SelectItem>
                                                <SelectItem value="2">Casadoo</SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lugar Nacimiento -->
                        <!-- <div class="space-y-4 rounded-lg border bg-white p-4 shadow-sm">
                            <h3 class="border-b pb-2 text-sm font-semibold tracking-wider text-zinc-500 uppercase">Lugar de Nacimiento</h3>
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                                <div class="space-y-1">
                                    <Label>País</Label>
                                    <Select v-model="formData.lugarNacimiento.pais">
                                        <SelectTrigger><SelectValue placeholder="País" /></SelectTrigger>
                                        <SelectContent><SelectItem value="PE">Perú</SelectItem></SelectContent>
                                    </Select>
                                </div>
                                <div class="space-y-1">
                                    <Label>Departamento</Label>
                                    <Select v-model="formData.lugarNacimiento.dpto">
                                        <SelectTrigger><SelectValue placeholder="Dpto" /></SelectTrigger>
                                        <SelectContent><SelectItem value="L">Lima</SelectItem></SelectContent>
                                    </Select>
                                </div>
                                <div class="space-y-1">
                                    <Label>Provincia</Label>
                                    <Select v-model="formData.lugarNacimiento.prov">
                                        <SelectTrigger><SelectValue placeholder="Prov" /></SelectTrigger>
                                        <SelectContent><SelectItem value="L">Lima</SelectItem></SelectContent>
                                    </Select>
                                </div>
                                <div class="space-y-1">
                                    <Label>Distrito</Label>
                                    <Select v-model="formData.lugarNacimiento.dist">
                                        <SelectTrigger><SelectValue placeholder="Dist" /></SelectTrigger>
                                        <SelectContent><SelectItem value="M">Miraflores</SelectItem></SelectContent>
                                    </Select>
                                </div>
                            </div>
                        </div> -->

                        <!-- Emergencia -->
                        <div class="space-y-4 rounded-lg border border-red-100 bg-red-50/50 p-4">
                            <h3 class="border-b border-red-200 pb-2 text-sm font-semibold tracking-wider text-red-700 uppercase">
                                Contacto Emergencia
                            </h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="space-y-1"><Label>Nombre</Label><Input v-model="formData.emergenciaNombre" class="bg-white" /></div>

                                <div class="space-y-1"><Label>Celular</Label><Input v-model="formData.emergenciaTelefono" class="bg-white" /></div>
                            </div>
                        </div>
                    </TabsContent>

                    <!-- PESTAÑA 2: Domicilio -->
                    <TabsContent value="tallas" class="mt-0 space-y-6">
                        <div class="space-y-4 rounded-lg border bg-white p-4 shadow-sm">
                            <div class="mb-4 flex flex-col justify-between border-b pb-2 sm:flex-row sm:items-center">
                                <h3 class="text-lg font-semibold text-zinc-800">Implementos</h3>
                            </div>

                            <!-- Lista de checkboxes -->
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                                <div
                                    v-for="(prenda, index) in prendasFijas"
                                    :key="index"
                                    class="flex items-start space-x-3 rounded border border-transparent p-2 hover:border-zinc-100 hover:bg-zinc-50"
                                >
                                    <div class="space-y-1">
                                        <Label :for="'prenda-' + index" class="cursor-pointer text-sm font-normal">
                                            {{ prenda.label }}
                                        </Label>
                                        <Input class="text" placeholder="Talla" v-model="prenda.talla" />
                                    </div>
                                </div>
                            </div>

                            <!-- Prendas seleccionadas con tallas -->
                            <!-- <div class="mt-6 space-y-4">
                                <h4 class="font-medium text-zinc-700">Prendas seleccionadas con tallas:</h4>
                                <div v-if="formData.prendas.length === 0" class="text-sm text-gray-500 italic">
                                    Selecciona prendas arriba para agregar tallas
                                </div>
                                <div
                                    v-for="(prendaObj, index) in formData.prendas"
                                    :key="index"
                                    class="flex items-center justify-between rounded-lg border bg-gray-50 p-3"
                                >
                                    <div class="flex-1">
                                        <span class="font-medium">{{ prendaObj.nombre }}</span>
                                    </div>
                                    <div class="mx-4 w-32">
                                        <input
                                            type="text"
                                            v-model="prendaObj.talla"
                                            placeholder="Talla"
                                            class="w-full rounded border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:ring-blue-500"
                                        />
                                    </div>
                                    <button @click="eliminarPrenda(index)" class="p-1 text-red-500 hover:text-red-700" title="Eliminar prenda">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div> -->
                        </div>
                    </TabsContent>

                    <!-- PESTAÑA 3: Laboral -->
                    <TabsContent value="laboral" class="mt-0 space-y-6">
                        <div class="space-y-4 rounded-lg border bg-white p-4 shadow-sm">
                            <h3 class="border-b pb-2 text-lg font-semibold text-zinc-800">Información del Puesto</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="space-y-1">
                                    <Label>Contrato</Label>
                                    <Select v-model="formData.tipoContrato">
                                        <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                                        <SelectContent><SelectItem value="I">Indefinido</SelectItem></SelectContent>
                                    </Select>
                                </div>
                                <div class="space-y-1">
                                    <Label>Régimen Lab.</Label>
                                    <Select v-model="formData.regimenLaboral">
                                        <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                                        <SelectContent><SelectItem value="G">General</SelectItem></SelectContent>
                                    </Select>
                                </div>
                                <div class="space-y-1">
                                    <Label>Fecha de ingreso a Unidad</Label>
                                    <Input type="date" v-model="formData.fechaNacimiento" />
                                </div>
                                <div class="space-y-1"><Label>Área</Label><Input v-model="formData.area" /></div>
                                <div class="space-y-1">
                                    <Label>Sede</Label>
                                    <Select v-model="formData.sede">
                                        <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                                        <SelectContent><SelectItem value="Y">Yauricocha</SelectItem></SelectContent>
                                    </Select>
                                </div>
                                <div class="space-y-1"><Label>Régimen (Días)</Label><Input v-model="formData.tipoRegimen" /></div>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-white p-4 shadow-sm">
                            <h3 class="mb-3 border-b pb-2 text-lg font-semibold text-zinc-800">Accesos / Puntos de Control</h3>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div
                                    v-for="punto in ['Carolina', 'Lima', 'Yauricocha', 'VICTOR 3 - ENTRADA A UNIDAD YAURICOCHA']"
                                    :key="punto"
                                    class="flex items-start space-x-3 rounded border border-transparent p-2 hover:border-zinc-100 hover:bg-zinc-50"
                                >
                                    <Checkbox :id="punto" :value="punto" v-model:checked="formData.puntosControl" class="mt-1" />
                                    <Label :for="punto" class="cursor-pointer text-sm font-normal">
                                        {{ punto }}
                                    </Label>
                                </div>
                            </div>
                        </div>
                    </TabsContent>

                    <TabsContent value="financiero" class="mt-0 space-y-6">
                        <div class="space-y-4 rounded-lg border bg-white p-4 shadow-sm">
                            <h3 class="border-b pb-2 text-lg font-semibold text-zinc-800">Datos financieros</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="space-y-1">
                                    <Label>Entidad Bancaria</Label>
                                    <Select v-model="formData.tipoContrato">
                                        <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                                        <SelectContent><SelectItem value="I">Indefinido</SelectItem></SelectContent>
                                    </Select>
                                </div>
                                <div class="space-y-1"><Label>Número de Cuenta</Label><Input v-model="formData.area" /></div>
                                <div class="space-y-1"><Label>Número de Cuenta CI</Label><Input v-model="formData.area" /></div>
                                <div class="space-y-1">
                                    <Label>Aportación</Label>
                                    <Select v-model="formData.regimenLaboral">
                                        <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                                        <SelectContent><SelectItem value="G">General</SelectItem></SelectContent>
                                    </Select>
                                </div>
                                <div class="space-y-1">
                                    <Label>Fecha ingreso a Unidad</Label>
                                    <Input type="date" v-model="formData.fechaIngreso" />
                                </div>
                                <div class="space-y-1">
                                    <Label>Fecha de Fin de Contrato</Label>
                                    <Input type="date" v-model="formData.fechaFinContract" />
                                </div>
                                <!--  <div class="space-y-1"><Label>Cargo</Label><Input v-model="formData.cargo" /></div>

                                <div class="space-y-1">
                                    <Label>Sede</Label>
                                    <Select v-model="formData.sede">
                                        <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                                        <SelectContent><SelectItem value="Y">Yauricocha</SelectItem></SelectContent>
                                    </Select>
                                </div>
                                <div class="space-y-1"><Label>Régimen (Días)</Label><Input v-model="formData.tipoRegimen" /></div> -->
                            </div>
                        </div>
                        <div class="space-y-4 rounded-lg border bg-white p-4 shadow-sm">
                            <h3 class="border-b pb-2 text-lg font-semibold text-zinc-800">Carga Familiar</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="space-y-1"><Label>Número de Hijos</Label><Input v-model="formData.children" /></div>
                                <div class="space-y-1">
                                    <Label>DNIs en PDF</Label>
                                    <Input type="file" class="w-[1/3] text-xs file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200" />
                                </div>
                            </div>
                        </div>
                    </TabsContent>

                    <!-- PESTAÑA 4: Adjuntos -->
                    <TabsContent value="adjuntos" class="mt-0 space-y-4">
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
                            <div><span class="font-medium">Atención!</span> Asegúrese de que los archivos sean legibles (PDF o JPG).</div>
                        </div>

                        <Alert v-if="showAlert" variant="destructive" class="relative mb-4">
                            <button class="absolute top-3 right-3 text-sm" @click="showAlert = false">✕</button>

                            <AlertTitle>Error</AlertTitle>
                            <AlertDescription>
                                {{ alertMessage }}
                            </AlertDescription>
                        </Alert>

                        <div class="grid grid-cols-1 gap-2">
                            <div
                                v-for="(doc, index) in [
                                    'CV Documentado',
                                    'Certificado Único Laboral (CUL)',
                                    'Certificado de Estudios',
                                    'Certificados de Trabajo',
                                    'DNI escaneado',
                                    'Antecedentes Penales y Policiales',
                                    'Carné de sanidad',
                                    'Carné de vacunación contra el COVID',
                                    'Examen Medico Ocupacional (EMO)',
                                    'SCTR',
                                    'Contrato',
                                ]"
                                :key="index"
                                class="flex items-center justify-between rounded-lg border bg-white p-3 shadow-sm"
                            >
                                <span class="text-sm font-medium text-zinc-700">{{ doc }}</span>
                                <Input
                                    type="file"
                                    class="w-[350px] text-xs file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200"
                                    accept="application/pdf, image/jpeg"
                                    @change="handleFileUpload"
                                />
                            </div>
                        </div>
                    </TabsContent>
                </Tabs>
            </div>

            <!-- Footer Fijo -->
            <DialogFooter class="z-10 flex w-full flex-row items-center justify-between border-t bg-white px-6 py-4 sm:justify-between">
                <!-- Botón Izquierda (Anterior) -->
                <div>
                    <Button v-if="activeTab !== 'personal'" @click="prevTab" variant="outline" type="button"> ← Anterior </Button>
                </div>

                <!-- Botón Derecha (Siguiente / Guardar) -->
                <div>
                    <Button v-if="activeTab !== 'tallas'" @click="nextTab" type="button" class="bg-blue-600 text-white hover:bg-blue-700">
                        Siguiente →
                    </Button>
                    <Button v-else @click="handleSubmit" type="button" class="bg-green-600 text-white hover:bg-green-700">
                        Finalizar Registro
                    </Button>
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
