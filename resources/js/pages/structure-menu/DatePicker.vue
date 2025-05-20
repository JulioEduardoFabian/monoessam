<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { RangeCalendar } from '@/components/ui/range-calendar';
import { cn } from '@/lib/utils';
import { CalendarDate, DateFormatter, getLocalTimeZone } from '@internationalized/date';
import { CalendarIcon } from 'lucide-vue-next';
import type { DateRange } from 'reka-ui';
import { type Ref, ref, watch } from 'vue';
import DateCard from './DateCard.vue';

const props = defineProps<{
    breakfasts?: [];
}>();

const df = new DateFormatter('en-US', {
    dateStyle: 'medium',
});

const value = ref({
    start: new CalendarDate(2025, 5, 20),
    end: new CalendarDate(2025, 5, 20).add({ days: 7 }),
}) as Ref<DateRange>;

// Array para almacenar las fechas del rango
const dateRangeArray = ref<Array<{ date: Date; formatted: string }>>([]);

// Función para generar el array de fechas
const generateDateRangeArray = (range: DateRange) => {
    if (!range.start || !range.end) return [];

    const start = range.start;
    const end = range.end;
    const dates = [];

    let current = start;
    while (current.compare(end) <= 0) {
        const date = current.toDate(getLocalTimeZone());
        dates.push({
            date: date,
            formatted: df.format(date),
            dishes: [],
        });
        current = current.add({ days: 1 });
    }

    return dates;
};

// Watcher para actualizar el array cuando cambia el rango
watch(
    value,
    (newValue) => {
        dateRangeArray.value = generateDateRangeArray(newValue);

        // Opcional: emitir el array si es necesario
        // emit('date-range-update', dateRangeArray.value);

        // Para ver el resultado en consola
        //console.log('Date range array:', dateRangeArray.value);
    },
    { deep: true, immediate: true },
);
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button variant="outline" :class="cn('w-[280px] justify-start text-left font-normal', !value && 'text-muted-foreground')">
                <CalendarIcon class="mr-2 h-4 w-4" />
                <template v-if="value.start">
                    <template v-if="value.end">
                        {{ df.format(value.start.toDate(getLocalTimeZone())) }} - {{ df.format(value.end.toDate(getLocalTimeZone())) }}
                    </template>

                    <template v-else>
                        {{ df.format(value.start.toDate(getLocalTimeZone())) }}
                    </template>
                </template>
                <template v-else> Pick a date </template>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <RangeCalendar v-model="value" initial-focus :number-of-months="2" @update:start-value="(startDate) => (value.start = startDate)" />
        </PopoverContent>
    </Popover>

    <div class="h-auto w-full">
        <div class="grid grid-cols-3 gap-4">
            <DateCard :dateRangeArray="dateRangeArray" />
        </div>
    </div>
</template>
