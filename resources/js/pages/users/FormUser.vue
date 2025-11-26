<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { ref } from 'vue';

const activeTab = ref('personal');

// Placeholder para simular la data del formulario
const formData = ref({
    // Personal
    nombres: '',
    apellidos: '',
    documento: '',
    codColaborador: '',
    fechaNacimiento: '',
    sexo: '',
    nacionalidad: '',
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
    puntosControl: ['VICTOR 3'], // Por defecto, como ejemplo
    // Adjuntos (solo simulación)
    adjuntos: {},
});

const nextTab = () => {
    const tabs = ['personal', 'domicilio', 'laboral', 'adjuntos'];
    const currentIndex = tabs.indexOf(activeTab.value);
    if (currentIndex < tabs.length - 1) {
        activeTab.value = tabs[currentIndex + 1];
    }
};

const prevTab = () => {
    const tabs = ['personal', 'domicilio', 'laboral', 'adjuntos'];
    const currentIndex = tabs.indexOf(activeTab.value);
    if (currentIndex > 0) {
        activeTab.value = tabs[currentIndex - 1];
    }
};
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-4 md:p-10">
        <h1 class="mb-6 text-center text-2xl font-extrabold text-zinc-800 md:text-3xl">Ficha de Registro de Colaborador</h1>
        <Card class="mx-auto max-w-4xl shadow-xl">
            <CardHeader class="border-b">
                <CardTitle class="text-xl">Proceso de Alta</CardTitle>
                <CardDescription>Complete los datos del colaborador en las cuatro secciones a continuación.</CardDescription>
            </CardHeader>

            <CardContent class="p-4 md:p-6">
                <Tabs v-model="activeTab" class="w-full">
                    <!-- Barra de Navegación de Pestañas (UX Responsive) -->
                    <TabsList class="sticky top-0 z-10 mb-6 grid h-auto w-full grid-cols-4 rounded-lg border bg-white p-1 shadow-sm">
                        <TabsTrigger value="personal" class="py-2 text-[10px] sm:text-xs md:text-sm">1. Personal</TabsTrigger>
                        <TabsTrigger value="domicilio" class="py-2 text-[10px] sm:text-xs md:text-sm">2. Domicilio</TabsTrigger>
                        <TabsTrigger value="laboral" class="py-2 text-[10px] sm:text-xs md:text-sm">3. Laboral</TabsTrigger>
                        <TabsTrigger value="adjuntos" class="py-2 text-[10px] sm:text-xs md:text-sm">4. Adjuntos</TabsTrigger>
                    </TabsList>

                    <!-- PESTAÑA 1: Datos Personales e Identificación -->
                    <TabsContent value="personal" class="space-y-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                            <!-- Foto y Datos Generales -->
                            <div class="flex flex-col items-center space-y-3 rounded-lg border bg-zinc-50 p-4 md:col-span-1">
                                <img
                                    src="https://placehold.co/150x200/52525B/FFFFFF?text=FOTO"
                                    alt="Foto Colaborador"
                                    class="h-40 w-32 rounded-md object-cover shadow-md"
                                />
                                <Button variant="outline" class="w-full">Subir Foto</Button>
                                <Input placeholder="Cód. Colaborador" v-model="formData.codColaborador" />
                            </div>

                            <div class="space-y-4 md:col-span-3">
                                <h3 class="border-b pb-2 text-lg font-semibold">Datos Generales</h3>
                                <!-- Los campos se apilan en móvil y usan 3 columnas en desktop -->
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                                    <div class="space-y-1">
                                        <Label for="nombres">Nombres</Label>
                                        <Input id="nombres" v-model="formData.nombres" placeholder="Nombres" />
                                    </div>
                                    <div class="space-y-1">
                                        <Label for="apellidos">Apellidos</Label>
                                        <Input id="apellidos" v-model="formData.apellidos" placeholder="Apellidos" />
                                    </div>
                                    <div class="space-y-1">
                                        <Label for="doc">DNI / C.E. / Pasaporte</Label>
                                        <Input id="doc" v-model="formData.documento" placeholder="Número de Documento" />
                                    </div>

                                    <div class="space-y-1">
                                        <Label for="nacimiento">F. Nacimiento</Label>
                                        <Input id="nacimiento" type="date" v-model="formData.fechaNacimiento" />
                                    </div>
                                    <div class="space-y-1">
                                        <Label for="sexo">Sexo</Label>
                                        <Select v-model="formData.sexo">
                                            <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                                            <SelectContent
                                                ><SelectItem value="M">Masculino</SelectItem
                                                ><SelectItem value="F">Femenino</SelectItem></SelectContent
                                            >
                                        </Select>
                                    </div>
                                    <div class="space-y-1">
                                        <Label for="nacionalidad">Nacionalidad</Label>
                                        <Input id="nacionalidad" v-model="formData.nacionalidad" placeholder="Nacionalidad" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lugar de Nacimiento -->
                        <div class="space-y-4 rounded-lg border p-4">
                            <h3 class="border-b pb-2 text-lg font-semibold">Lugar de Nacimiento</h3>
                            <!-- Los campos usan 2 columnas en móvil y 4 en desktop -->
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                                <div class="space-y-1">
                                    <Label>País</Label
                                    ><Select v-model="formData.lugarNacimiento.pais"
                                        ><SelectTrigger><SelectValue placeholder="País" /></SelectTrigger
                                        ><SelectContent><SelectItem value="PE">Perú</SelectItem></SelectContent></Select
                                    >
                                </div>
                                <div class="space-y-1">
                                    <Label>Departamento</Label
                                    ><Select v-model="formData.lugarNacimiento.dpto"
                                        ><SelectTrigger><SelectValue placeholder="Departamento" /></SelectTrigger
                                        ><SelectContent><SelectItem value="L">Lima</SelectItem></SelectContent></Select
                                    >
                                </div>
                                <div class="space-y-1">
                                    <Label>Provincia</Label
                                    ><Select v-model="formData.lugarNacimiento.prov"
                                        ><SelectTrigger><SelectValue placeholder="Provincia" /></SelectTrigger
                                        ><SelectContent><SelectItem value="L">Lima</SelectItem></SelectContent></Select
                                    >
                                </div>
                                <div class="space-y-1">
                                    <Label>Distrito</Label
                                    ><Select v-model="formData.lugarNacimiento.dist"
                                        ><SelectTrigger><SelectValue placeholder="Distrito" /></SelectTrigger
                                        ><SelectContent><SelectItem value="M">Miraflores</SelectItem></SelectContent></Select
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Contacto de Emergencia -->
                        <div class="space-y-4 rounded-lg border border-red-200 bg-red-50 p-4">
                            <h3 class="border-b pb-2 text-lg font-semibold text-red-700">Contacto de Emergencia</h3>
                            <!-- Los campos usan 1 columna en móvil y 3 en desktop -->
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="space-y-1">
                                    <Label for="em_nombre">Nombre Contacto</Label><Input id="em_nombre" v-model="formData.emergenciaNombre" />
                                </div>
                                <div class="space-y-1">
                                    <Label for="em_parentesco">Parentesco</Label><Input id="em_parentesco" v-model="formData.emergenciaParentesco" />
                                </div>
                                <div class="space-y-1">
                                    <Label for="em_tel">Teléfono</Label><Input id="em_tel" v-model="formData.emergenciaTelefono" type="tel" />
                                </div>
                            </div>
                        </div>
                    </TabsContent>

                    <!-- PESTAÑA 2: Domicilio y Estudios -->
                    <TabsContent value="domicilio" class="space-y-6">
                        <!-- Contacto (Domicilio) -->
                        <h3 class="border-b pb-2 text-xl font-semibold text-zinc-800">Contacto y Domicilio</h3>
                        <div class="mb-4 flex flex-col items-start space-y-2 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4">
                            <Label for="tipoDom" class="whitespace-nowrap">Tipo de Domicilio:</Label>
                            <Select v-model="formData.tipoDomicilio">
                                <SelectTrigger class="w-full sm:w-[200px]"><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                                <SelectContent
                                    ><SelectItem value="temporal">Temporal</SelectItem
                                    ><SelectItem value="permanente">Permanente</SelectItem></SelectContent
                                >
                            </Select>
                            <span class="text-sm text-gray-500"
                                >({{
                                    formData.tipoDomicilio === 'temporal' ? 'Llenar también Domicilio Permanente' : 'Llenar Domicilio Permanente'
                                }})</span
                            >
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div class="space-y-1">
                                <Label>Tipo Vía</Label><Input v-model="formData.domicilio.tipoVia" placeholder="Av., Jr., Calle" />
                            </div>
                            <div class="space-y-1">
                                <Label>Nombre Vía</Label><Input v-model="formData.domicilio.nombreVia" placeholder="Nombre de la vía" />
                            </div>
                            <div class="space-y-1"><Label>N° / Int</Label><Input v-model="formData.domicilio.numero" placeholder="N°" /></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                            <div class="space-y-1">
                                <Label>Urb. / Sector</Label><Input v-model="formData.domicilio.urb" placeholder="Urbanización" />
                            </div>
                            <div class="space-y-1">
                                <Label>Referencia</Label><Input v-model="formData.domicilio.ref" placeholder="Referencia cercana" />
                            </div>
                            <div class="space-y-1">
                                <Label>País</Label
                                ><Select v-model="formData.contactoDomicilio.pais"
                                    ><SelectTrigger><SelectValue placeholder="País" /></SelectTrigger
                                    ><SelectContent><SelectItem value="PE">Perú</SelectItem></SelectContent></Select
                                >
                            </div>
                            <div class="space-y-1">
                                <Label>Departamento</Label
                                ><Select v-model="formData.contactoDomicilio.dpto"
                                    ><SelectTrigger><SelectValue placeholder="Departamento" /></SelectTrigger
                                    ><SelectContent><SelectItem value="L">Lima</SelectItem></SelectContent></Select
                                >
                            </div>
                        </div>

                        <!-- Nivel de Estudios -->
                        <div class="mt-6 border-t pt-6">
                            <h3 class="border-b pb-2 text-xl font-semibold text-zinc-800">Nivel de Estudios</h3>
                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4">
                                <div class="space-y-1">
                                    <Label>Grado/Nivel</Label><Input v-model="formData.gradoEstudios" placeholder="Nivel/Grado de Estudios" />
                                </div>
                                <div class="space-y-1 sm:col-span-2 md:col-span-2">
                                    <Label>Institución Educativa</Label
                                    ><Input v-model="formData.institucion" placeholder="Nombre completo de la institución" />
                                </div>
                                <div class="space-y-1">
                                    <Label>Colegiatura</Label><Input v-model="formData.colegiatura" placeholder="N° Colegiatura (si aplica)" />
                                </div>
                            </div>
                            <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div class="space-y-1">
                                    <Label>Título Obtenido</Label><Input v-model="formData.titulo" placeholder="Título o Grado Académico" />
                                </div>
                                <div class="space-y-1">
                                    <Label>Especialidad</Label><Input v-model="formData.especialidad" placeholder="Especialidad o Carrera" />
                                </div>
                            </div>
                        </div>
                    </TabsContent>

                    <!-- PESTAÑA 3: Datos Laborales y Control -->
                    <TabsContent value="laboral" class="space-y-6">
                        <!-- Datos Laborales -->
                        <h3 class="border-b pb-2 text-xl font-semibold text-zinc-800">Datos Laborales</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div class="space-y-1">
                                <Label>Tipo de Contrato</Label
                                ><Select v-model="formData.tipoContrato"
                                    ><SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger
                                    ><SelectContent><SelectItem value="I">Indefinido</SelectItem></SelectContent></Select
                                >
                            </div>
                            <div class="space-y-1">
                                <Label>Régimen Laboral</Label
                                ><Select v-model="formData.regimenLaboral"
                                    ><SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger
                                    ><SelectContent><SelectItem value="G">General</SelectItem></SelectContent></Select
                                >
                            </div>
                            <div class="space-y-1"><Label>Cargo / Puesto</Label><Input v-model="formData.cargo" placeholder="Cargo o Puesto" /></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                            <div class="space-y-1"><Label>Área</Label><Input v-model="formData.area" placeholder="Área" /></div>
                            <div class="space-y-1">
                                <Label>Sede / Unidad</Label
                                ><Select v-model="formData.sede"
                                    ><SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger
                                    ><SelectContent><SelectItem value="Y">Yauricocha</SelectItem></SelectContent></Select
                                >
                            </div>
                            <div class="space-y-1">
                                <Label>Tipo de Régimen</Label><Input v-model="formData.tipoRegimen" placeholder="Ej: 14x7, 7x7" />
                            </div>
                            <div class="space-y-1">
                                <Label>Operaciones</Label><Input v-model="formData.operaciones" placeholder="Operaciones General" />
                            </div>
                        </div>

                        <!-- Puntos de Control -->
                        <div class="mt-6 border-t pt-6">
                            <h3 class="border-b pb-2 text-xl font-semibold text-zinc-800">Puntos de Control</h3>
                            <p class="mb-4 text-sm text-gray-500">Seleccione los puntos por donde el colaborador puede pasar o laborar.</p>
                            <!-- Los checkboxes se adaptan usando 2 columnas en móvil y 4 en desktop -->
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                                <div
                                    v-for="punto in ['Carolina', 'Lima', 'Yauricocha', 'VICTOR 3 - ENTRADA A UNIDAD YAURICOCHA']"
                                    :key="punto"
                                    class="flex items-start space-x-2"
                                >
                                    <Checkbox :id="punto" :value="punto" v-model:checked="formData.puntosControl" class="mt-1" />
                                    <Label
                                        :for="punto"
                                        class="flex-1 text-sm leading-tight font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                    >
                                        {{ punto.split(' - ')[0] }}
                                        <p v-if="punto.includes('-')" class="text-xs text-gray-500">{{ punto.split(' - ')[1] }}</p>
                                    </Label>
                                </div>
                            </div>
                        </div>
                    </TabsContent>

                    <!-- PESTAÑA 4: Documentos Requeridos (Adjuntos) -->
                    <TabsContent value="adjuntos" class="space-y-6">
                        <h3 class="border-b pb-2 text-xl font-semibold text-zinc-800">Adjuntar Documentos Requeridos</h3>
                        <p class="text-sm font-medium text-red-600">
                            ⚠️ Todos los documentos listados a continuación son obligatorios para finalizar el registro.
                        </p>

                        <div class="space-y-3">
                            <!-- Helper component for document upload (simulated) -->
                            <div
                                v-for="(doc, index) in [
                                    'Antecedentes Policiales y Penales',
                                    'Certificado de Comunero',
                                    'Certificados de Estudio',
                                    'Certificados de Trabajo',
                                    'Copia DNI / Carnet de Extranjería',
                                    'Cuadro de Distribución de Personal',
                                    'Curriculum Vitae y Resumen de Experiencia.pdf',
                                    'Declaración Jurada de Domicilio',
                                ]"
                                :key="index"
                                class="flex flex-col items-start justify-between space-y-2 rounded-lg border p-3 transition-colors hover:bg-zinc-50 sm:flex-row sm:items-center sm:space-y-0"
                            >
                                <div class="flex flex-col">
                                    <Label class="font-semibold">{{ doc.split('.')[0] }}</Label>
                                    <span class="text-xs text-gray-500"
                                        >Documento: {{ doc.includes('.') ? doc.split('.')[1].toUpperCase() : doc.toUpperCase() }}</span
                                    >
                                </div>
                                <div class="flex items-center space-x-3">
                                    <Input type="file" class="h-9 w-[150px] text-xs sm:w-[200px]" />
                                    <Button size="sm" variant="secondary" class="bg-green-500 text-white hover:bg-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                fill-rule="evenodd"
                                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L10 11.586l1.293-1.293a1 1 0 111.414 1.414l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        Subir
                                    </Button>
                                    <!-- Aquí iría el ícono de descarga si ya existe -->
                                </div>
                            </div>
                        </div>
                    </TabsContent>

                    <!-- Controles de Navegación del Formulario -->
                    <div class="mt-6 flex justify-between border-t pt-6">
                        <Button v-if="activeTab !== 'personal'" @click="prevTab" variant="outline"> ← Anterior </Button>
                        <div v-else></div>
                        <!-- Placeholder para centrar el botón siguiente -->

                        <Button v-if="activeTab !== 'adjuntos'" @click="nextTab" class="bg-blue-600 hover:bg-blue-700"> Siguiente → </Button>

                        <Button v-else type="submit" class="bg-green-600 hover:bg-green-700"> Guardar Registro Final </Button>
                    </div>
                </Tabs>
            </CardContent>
        </Card>
    </div>
</template>

<style scoped>
/* Ajustes específicos de layout si fueran necesarios, aunque Tailwind lo maneja */
</style>
