<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { AlertCircle, AlertTriangle, CheckCircle, Info, Phone, User } from 'lucide-vue-next';

interface Props {
    form: any;
}

defineProps<Props>();
</script>

<template>
    <div class="space-y-5">
        <!-- Header de sección -->
        <div class="mb-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-600">
                    <AlertTriangle class="h-5 w-5" />
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-zinc-900">Contacto de Emergencia</h3>
                    <p class="mt-1 text-sm text-zinc-500">Registre la información del contacto para emergencias</p>
                </div>
            </div>
        </div>

        <!-- Contenedor del formulario -->
        <div class="rounded-xl border border-red-200 bg-gradient-to-br from-red-50/30 to-white p-5 shadow-sm">
            <!-- Indicador visual -->
            <div class="mb-4 flex items-center justify-between border-b border-red-100 pb-4">
                <div class="flex items-center gap-2">
                    <div class="flex h-6 w-6 items-center justify-center rounded-full bg-red-100 text-red-600">
                        <AlertCircle class="h-3 w-3" />
                    </div>
                    <span class="text-sm font-medium text-red-700">Información crítica para emergencias</span>
                </div>
                <div v-if="form.contactname && form.contactcell" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5">
                    <CheckCircle class="h-3.5 w-3.5 text-emerald-600" />
                    <span class="text-xs font-medium text-emerald-700">Completo</span>
                </div>
                <div v-else class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5">
                    <AlertCircle class="h-3.5 w-3.5 text-amber-600" />
                    <span class="text-xs font-medium text-amber-700">Incompleto</span>
                </div>
            </div>

            <!-- Campos del formulario -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <!-- Nombre -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-medium text-zinc-700">
                        <div class="flex h-5 w-5 items-center justify-center rounded-md bg-red-100 text-red-600">
                            <User class="h-3 w-3" />
                        </div>
                        Nombre del contacto *
                    </label>
                    <Input
                        v-model="form.contactname"
                        class="h-10 border-zinc-200 bg-white focus:border-red-300 focus:ring-red-300"
                        placeholder="Ej: María López"
                    />
                    <div v-if="!form.contactname" class="flex items-center gap-1.5">
                        <Info class="h-3.5 w-3.5 text-amber-500" />
                        <span class="text-xs text-amber-600">Este campo es obligatorio para emergencias</span>
                    </div>
                </div>

                <!-- Celular -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-medium text-zinc-700">
                        <div class="flex h-5 w-5 items-center justify-center rounded-md bg-red-100 text-red-600">
                            <Phone class="h-3 w-3" />
                        </div>
                        Celular de contacto *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-sm text-zinc-400">+51</span>
                        </div>
                        <Input
                            v-model="form.contactcell"
                            class="h-10 border-zinc-200 bg-white pl-14 focus:border-red-300 focus:ring-red-300"
                            placeholder="987654321"
                            type="tel"
                        />
                        <div v-if="form.contactcell" class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <a
                                :href="`tel:+51${form.contactcell}`"
                                class="flex h-7 w-7 items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200"
                                title="Probar llamada"
                            >
                                <PhoneOutgoing class="h-3.5 w-3.5" />
                            </a>
                        </div>
                    </div>
                    <div v-if="!form.contactcell" class="flex items-center gap-1.5">
                        <Info class="h-3.5 w-3.5 text-amber-500" />
                        <span class="text-xs text-amber-600">Número telefónico requerido</span>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="mt-6 rounded-lg bg-gradient-to-r from-red-50/50 to-white p-4">
                <div class="flex items-start gap-3">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                        <Info class="h-3.5 w-3.5" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-800">¿Por qué es importante esta información?</p>
                        <ul class="mt-2 space-y-1.5">
                            <li class="flex items-start gap-2">
                                <div class="mt-0.5 h-1.5 w-1.5 rounded-full bg-red-400"></div>
                                <span class="text-xs text-zinc-600">Será contactada solo en situaciones de emergencia médica o laboral</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="mt-0.5 h-1.5 w-1.5 rounded-full bg-red-400"></div>
                                <span class="text-xs text-zinc-600">Asegúrese de que el contacto esté disponible las 24 horas</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="mt-0.5 h-1.5 w-1.5 rounded-full bg-red-400"></div>
                                <span class="text-xs text-zinc-600">Verifique que los datos sean correctos y actualizados</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
