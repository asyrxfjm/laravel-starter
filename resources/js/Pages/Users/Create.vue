<script setup lang="ts">
import {
	Breadcrumb,
	BreadcrumbItem,
	BreadcrumbLink,
	BreadcrumbList,
	BreadcrumbPage,
	BreadcrumbSeparator
} from '@/Components/ui/breadcrumb';
import {
	Card,
	CardContent,
	CardDescription,
	CardFooter,
	CardHeader,
	CardTitle
} from '@/Components/ui/card';
import {
	Select,
	SelectContent,
	SelectGroup,
	SelectItem,
	SelectTrigger,
	SelectValue
} from '@/Components/ui/select';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/Components/ui/form';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useForm as veeForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';

const props = defineProps<{
	roles: string[];
	selectedRole?: string;
}>();

const formSchema = toTypedSchema(
	z.object({
		name: z.string().max(50),
		email: z.string().max(50).email(),
		role: z.enum(['Admin', 'Student', 'Staff'])
	})
);

const { handleSubmit, setFieldError } = veeForm({
	validationSchema: formSchema,
	initialValues: {
		role: props.selectedRole as 'Admin' | 'Student' | 'Staff'
	}
});

const form = useForm({
	name: '',
	email: '',
	role: props.selectedRole
});

const onSubmit = handleSubmit(() => {
	form.post(route('users.store'), {
		onError: (errors) => {
			for (const [key, value] of Object.entries(errors)) {
				setFieldError(key as 'email' | 'name' | 'role', value);
			}
		}
	});
});
</script>

<template>
	<Head title="Users" />

	<AuthenticatedLayout>
		<template #header>
			<Breadcrumb>
				<BreadcrumbList>
					<BreadcrumbItem>
						<BreadcrumbLink as-child>
							<Link :href="route('dashboard')">Dashboard</Link>
						</BreadcrumbLink>
					</BreadcrumbItem>
					<BreadcrumbSeparator />
					<BreadcrumbItem>
						<BreadcrumbLink as-child>
							<Link :href="route('users.index')">Users</Link>
						</BreadcrumbLink>
					</BreadcrumbItem>
					<BreadcrumbSeparator />
					<BreadcrumbItem>
						<BreadcrumbPage>Create a new {{ props.selectedRole ?? 'User' }}</BreadcrumbPage>
					</BreadcrumbItem>
				</BreadcrumbList>
			</Breadcrumb>
		</template>
		<form @submit.prevent="onSubmit">
			<Card>
				<CardHeader>
					<CardTitle>
						<h2 class="text-lg">Create a new User</h2>
					</CardTitle>
					<CardDescription> Create a brand new user account. </CardDescription>
				</CardHeader>
				<CardContent class="space-y-4">
					<FormField
						v-slot="{ componentField }"
						name="name"
					>
						<FormItem>
							<FormLabel for="name">Full Name</FormLabel>
							<FormControl>
								<Input
									id="name"
									type="text"
									v-bind="componentField"
									v-model="form.name"
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					</FormField>
					<FormField
						v-slot="{ componentField }"
						name="email"
					>
						<FormItem>
							<FormLabel for="email">Email</FormLabel>
							<FormControl>
								<Input
									id="email"
									type="email"
									v-bind="componentField"
									v-model="form.email"
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					</FormField>
					<FormField
						v-slot="{ componentField }"
						name="role"
					>
						<FormItem>
							<FormLabel>Role</FormLabel>
							<Select
								v-bind="componentField"
								v-model="form.role"
							>
								<FormControl>
									<SelectTrigger>
										<SelectValue placeholder="Select a role" />
									</SelectTrigger>
								</FormControl>
								<SelectContent>
									<SelectGroup>
										<SelectItem
											v-for="role in roles"
											:value="role"
											:key="role"
										>
											{{ role }}
										</SelectItem>
									</SelectGroup>
								</SelectContent>
							</Select>
							<FormMessage />
						</FormItem>
					</FormField>
				</CardContent>
				<CardFooter>
					<div class="flex items-center gap-4">
						<Button :disabled="form.processing">Save</Button>

						<Transition
							enter-active-class="transition ease-in-out"
							enter-from-class="opacity-0"
							leave-active-class="transition ease-in-out"
							leave-to-class="opacity-0"
						>
							<p
								v-if="form.recentlySuccessful"
								class="text-sm text-gray-600"
							>
								Saved.
							</p>
						</Transition>
					</div>
				</CardFooter>
			</Card>
		</form>
	</AuthenticatedLayout>
</template>
