<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { House, User, Utensils } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const page = usePage();

const permissions = page.props.auth.permissions;

const mainNavItems: NavItem[] = [
    {
        title: 'Inicio',
        href: '/dashboard',
        icon: House,
    },
    {
        title: 'Usuarios',
        href: '/users',
        icon: User,
    },
    {
        title: 'Quebrados',
        href: '/food',
        icon: Utensils,
    },
];

permissions.forEach((permission) => {
    const newPermission = { title: permission.name, href: '/' + permission.route_name, icon: User };

    mainNavItems.push(newPermission);
});

const footerNavItems: NavItem[] = [];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
