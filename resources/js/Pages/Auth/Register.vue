<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { useForm as veeForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod';
import { Button } from '@/Components/ui/button';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/Components/ui/form';
import { Card, CardContent, CardDescription, CardHeader } from '@/Components/ui/card';
import { Input } from '@/Components/ui/input';

const form = useForm({
	name: '',
	email: '',
	password: '',
	password_confirmation: ''
});

const formSchema = toTypedSchema(
	z
		.object({
			name: z.string().min(5).max(50),
			email: z.string().min(2).max(50).email(),
			password: z.string().min(2),
			password_confirmation: z.string().min(2)
		})
		.refine((data) => data.password === data.password_confirmation, {
			message: 'Password must match',
			path: ['password_confirmation']
		})
);

const { handleSubmit, setFieldError } = veeForm({
	validationSchema: formSchema
});

const onSubmit = handleSubmit(() => {
	form.post(route('register'), {
		onFinish: () => {
			form.reset('password');
		},
		onError: (errors) => {
			for (const [key, value] of Object.entries(errors)) {
				setFieldError(
					key as 'email' | 'password' | 'name' | 'password' | 'password_confirmation',
					value
				);
			}
		}
	});
});
</script>

<template>
	<GuestLayout>
		<Head title="Register" />

		<form @submit.prevent="onSubmit">
			<Card>
				<CardHeader>
					<CardTitle class="text-2xl"> Sign Up </CardTitle>
					<CardDescription> Enter your email below to login to your account </CardDescription>
				</CardHeader>
				<CardContent class="space-y-4">
					<FormField
						v-slot="{ componentField }"
						name="name"
					>
						<FormItem>
							<FormLabel for="name">Name</FormLabel>
							<FormControl>
								<Input
									id="name"
									type="text"
									placeholder="Your name"
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
									placeholder="your@email.com"
									v-bind="componentField"
									v-model="form.email"
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					</FormField>
					<FormField
						v-slot="{ componentField }"
						name="password"
					>
						<FormItem>
							<FormLabel for="password"> Password </FormLabel>
							<FormControl>
								<Input
									id="password"
									type="password"
									v-bind="componentField"
									v-model="form.password"
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					</FormField>
					<FormField
						v-slot="{ componentField }"
						name="password_confirmation"
					>
						<FormItem>
							<FormLabel for="password"> Password Confirmation </FormLabel>
							<FormControl>
								<Input
									id="password_confirmation"
									type="password"
									v-bind="componentField"
									v-model="form.password_confirmation"
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					</FormField>
				</CardContent>
				<CardContent>
					<Button
						type="submit"
						class="w-full"
						:class="{ 'opacity-25': form.processing }"
						:disabled="form.processing"
						:loading="form.processing"
					>
						Sign Up
					</Button>
				</CardContent>
			</Card>
		</form>
	</GuestLayout>
</template>
