<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/Components/ui/accordion';
import { Link, usePage } from '@inertiajs/vue3';
import { Home, Users2 } from 'lucide-vue-next';
const page = usePage();

const componentName = page.component;
const roles = page.props.auth.user.roles;
const sectionName = componentName.split('/')[0];
console.log(sectionName);
</script>

<template>
    <div
        class="hidden min-h-full border-r bg-muted/40 backdrop-blur lg:block lg:min-w-[220px] xl:min-w-[280px]"
    >
        <div class="flex h-full max-h-screen flex-col gap-2">
            <div
                class="flex h-16 items-center border-b px-4 md:h-[60px] lg:px-6"
            >
                <Link
                    :href="route('dashboard')"
                    class="flex items-center gap-2 font-semibold"
                >
                    <ApplicationLogo
                        class="h-7 w-7 fill-current dark:text-white"
                    />
                    <span class="">AppName</span>
                </Link>
            </div>
            <div class="flex-1">
                <nav class="grid items-start px-2 text-sm font-medium lg:px-4">
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
                    <div class="cursor-default px-3 pb-2 pt-4">Directory</div>
                    <Accordion
                        type="single"
                        class="w-full"
                        collapsible
                        :default-value="sectionName"
                    >
                        <AccordionItem
                            key="Users"
                            value="Users"
                            class="border-b-0"
                        >
                            <AccordionTrigger
                                class="rounded-lg px-3 py-2"
                                :class="{
                                    'bg-muted text-primary':
                                        sectionName === 'Users',
                                    'text-muted-foreground':
                                        sectionName !== 'Users',
                                }"
                            >
                                <div class="flex items-center gap-3">
                                    <Users2 class="h-4 w-4" />
                                    Users
                                </div>
                            </AccordionTrigger>
                            <AccordionContent key="Users">
                                <div class="flex flex-col pl-3">
                                    <Link
                                        :href="route('users.index')"
                                        class="rounded py-2 pl-8"
                                        :class="{
                                            'text-muted-foreground':
                                                !componentName.includes(
                                                    'Users/Index',
                                                ),
                                        }"
                                    >
                                        All
                                    </Link>
                                    <Link
                                        :href="route('users.admin.index')"
                                        class="rounded py-2 pl-8"
                                        :class="{
                                            'text-muted-foreground':
                                                !componentName.includes(
                                                    'Users/Admin/Index',
                                                ),
                                        }"
                                    >
                                        Admin
                                    </Link>
                                </div>
                            </AccordionContent>
                        </AccordionItem>
                    </Accordion>
                    <!-- <Link
						:href="route('departments.index')"
						class="flex items-center gap-3 px-3 py-2 transition-all rounded-lg hover:text-primary"
						:class="{
							'bg-muted': componentName.includes('Departments'),
							'text-muted-foreground': !componentName.includes('Departments')
						}"
					>
						<Building2 class="w-4 h-4" />
						Departments
					</Link> -->
                </nav>
            </div>
        </div>
    </div>
</template>
