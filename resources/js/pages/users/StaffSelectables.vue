<script lang="ts" setup>
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';

interface Props {
    users: Array<any>;
}

const props = defineProps<Props>();
</script>
<template>
    <div>
        <p>PERSONAL</p>
        <div
            class="my-2 flex cursor-pointer flex-row items-center gap-3 rounded-sm p-3 text-white"
            :class="[user.type == 2 ? 'bg-green-500' : user.type == 3 ? 'bg-red-500' : 'bg-gray-500']"
            v-for="user in props.users"
            :key="user.id"
        >
            <Avatar>
                <AvatarImage src="https://github.com/shadcn.png" alt="@shadcn" />
                <AvatarFallback>CN</AvatarFallback>
            </Avatar>
            <p>{{ user.name }}</p>
        </div>
    </div>
</template>
