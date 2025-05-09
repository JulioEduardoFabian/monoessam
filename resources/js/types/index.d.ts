import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Role{
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
}

export interface Permission{
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
}

export interface Area{
    id: number,
    name: string
}

export interface Mine{
    id: number,
    name: string
}

export interface Unit{
    id: number,
    name: string,
    mine_id: number
}

export interface Cafe{
    id: number,
    name: string,
    cafe_id: number
}

export type BreadcrumbItemType = BreadcrumbItem;
