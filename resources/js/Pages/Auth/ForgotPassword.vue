<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { FormControl, FormField, FormItem, FormMessage } from '@/Components/ui/form';
import { Card, CardContent, CardFooter } from '@/Components/ui/card';
import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';
import { Head, useForm } from '@inertiajs/vue3';
import { useForm as veeForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod';

const form = useForm({
	email: ''
});

const formSchema = toTypedSchema(
	z.object({
		email: z.string().min(2).max(50).email()
	})
);

const { handleSubmit, setFieldError } = veeForm({
	validationSchema: formSchema
});

const onSubmit = handleSubmit(() => {
	form.post(route('password.email'), {
		onError: (errors) => {
			for (const [key, value] of Object.entries(errors)) {
				setFieldError(key as 'email', value);
			}
		}
	});
});
</script>

<template>
	<GuestLayout>
		<Head title="Forgot Password" />

		<div class="mb-4 text-sm text-gray-600">
			Forgot your password? No problem. Just let us know your email address and we will email you a
			password reset link that will allow you to choose a new one.
		</div>

		<form @submit.prevent="onSubmit">
			<Card>
				<CardContent class="pt-5 space-y-6">
					<FormField
						v-slot="{ componentField }"
						name="email"
					>
						<FormItem>
							<FormControl>
								<Input
									type="email"
									placeholder="your@email.com"
									v-bind="componentField"
									v-model="form.email"
									autocomplete="username"
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					</FormField>
				</CardContent>
				<CardFooter>
					<Button
						type="submit"
						class="w-full"
						:class="{ 'opacity-25': form.processing }"
						:disabled="form.processing"
					>
						Email Password Reset Link
					</Button>
				</CardFooter>
			</Card>
		</form>
	</GuestLayout>
</template>
