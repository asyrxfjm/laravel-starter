<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ToggleDarkMenu from '@/Components/ToggleDarkMenu.vue';
import { Button } from '@/Components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import { Sheet, SheetContent, SheetTrigger } from '@/Components/ui/sheet';
import { Link, usePage } from '@inertiajs/vue3';
import { CircleUser, Home, Menu, Users2 } from 'lucide-vue-next';

const page = usePage();

const user = page.props.auth.user;
const componentName = page.component;
</script>

<template>
    <header
        class="flex h-16 items-center gap-1 border-b bg-muted/40 px-4 backdrop-blur-md lg:h-[60px] lg:px-6"
    >
        <Sheet>
            <SheetTrigger as-child>
                <Button
                    variant="outline"
                    size="icon"
                    class="shrink-0 lg:hidden"
                >
                    <Menu class="h-5 w-5" />
                    <span class="sr-only">Toggle navigation menu</span>
                </Button>
            </SheetTrigger>
            <SheetContent side="left" class="flex flex-col">
                <nav class="grid gap-2 text-lg font-medium">
                    <Link
                        :href="route('dashboard')"
                        class="flex items-center gap-2 text-lg font-semibold"
                    >
                        <ApplicationLogo
                            class="h-8 w-8 fill-current dark:text-white"
                        />
                        <span>KotakHitam</span>
                    </Link>
                    <Link
                        :href="route('dashboard')"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all hover:text-primary"
                        :class="{
                            'bg-muted': componentName.includes('Dashboard'),
                            'text-muted-foreground':
                                !componentName.includes('Dashboard'),
                        }"
                    >
                        <Home class="h-4 w-4" />
                        Dashboard
                    </Link>
                    <Link
                        :href="route('users.index')"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all hover:text-primary"
                        :class="{
                            'bg-muted': componentName.includes('User'),
                            'text-muted-foreground':
                                !componentName.includes('User'),
                        }"
                    >
                        <Users2 class="h-4 w-4" />
                        Users
                    </Link>
                </nav>
            </SheetContent>
        </Sheet>
        <div class="w-full flex-1"></div>
        <ToggleDarkMenu />
        <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <Button variant="secondary" size="icon" class="rounded-full">
                    <CircleUser class="h-5 w-5" />
                    <span class="sr-only">Toggle user menu</span>
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuLabel> {{ user.name }} </DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuItem as-child>
                    <Link :href="route('profile.edit')">Profile</Link>
                </DropdownMenuItem>
                <DropdownMenuItem>Settings</DropdownMenuItem>
                <DropdownMenuItem>Support</DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem as-child>
                    <Link :href="route('logout')" method="post"> Logout</Link>
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    </header>
</template>
