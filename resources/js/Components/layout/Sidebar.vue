<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Building2, Home, Users2 } from 'lucide-vue-next';
import {
	Accordion,
	AccordionContent,
	AccordionItem,
	AccordionTrigger
} from '@/Components/ui/accordion';
const page = usePage();

const componentName = page.component;
const roles = page.props.auth.user.roles;
const sectionName = componentName.split('/')[0];
console.log(sectionName);
</script>

<template>
	<div
		class="hidden border-r bg-muted/40 lg:block backdrop-blur lg:min-w-[220px] xl:min-w-[280px] min-h-full"
	>
		<div class="flex flex-col h-full max-h-screen gap-2">
			<div class="flex h-16 items-center border-b px-4 md:h-[60px] lg:px-6">
				<Link
					:href="route('dashboard')"
					class="flex items-center gap-2 font-semibold"
				>
					<ApplicationLogo class="fill-current w-7 h-7 dark:text-white" />
					<span class="">AppName</span>
				</Link>
			</div>
			<div class="flex-1">
				<nav class="grid items-start px-2 text-sm font-medium lg:px-4">
					<Link
						:href="route('dashboard')"
						class="flex items-center gap-3 px-3 py-2 transition-all rounded-lg hover:text-primary"
						:class="{
							'bg-muted': componentName.includes('Dashboard'),
							'text-muted-foreground': !componentName.includes('Dashboard')
						}"
					>
						<Home class="w-4 h-4" />
						Dashboard
					</Link>
					<div class="px-3 pt-4 pb-2 cursor-default">Directory</div>
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
								class="px-3 py-2 rounded-lg"
								:class="{
									'text-primary bg-muted': sectionName === 'Users',
									'text-muted-foreground': sectionName !== 'Users'
								}"
							>
								<div class="flex items-center gap-3">
									<Users2 class="w-4 h-4" />
									Users
								</div>
							</AccordionTrigger>
							<AccordionContent key="Users">
								<div class="flex flex-col pl-3">
									<Link
										:href="route('users.index')"
										class="py-2 pl-8 rounded"
										:class="{
											'text-muted-foreground': !componentName.includes('Users/Index')
										}"
									>
										All
									</Link>
									<Link
										:href="route('users.admin.index')"
										class="py-2 pl-8 rounded"
										:class="{
											'text-muted-foreground': !componentName.includes('Users/Admin/Index')
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
