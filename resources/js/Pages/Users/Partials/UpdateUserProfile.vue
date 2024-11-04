<script setup lang="ts">
import { User } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { useForm as veeForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useToast } from '@/Components/ui/toast/use-toast';
import {
	Card,
	CardContent,
	CardDescription,
	CardFooter,
	CardHeader,
	CardTitle
} from '@/Components/ui/card';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/Components/ui/form';
import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';

const props = defineProps<{
	user: User;
}>();

const { toast } = useToast();

const formSchema = toTypedSchema(
	z.object({
		name: z.string().min(2).max(50),
		email: z.string().min(2).max(50).email()
	})
);

const { handleSubmit, setFieldError } = veeForm({
	validationSchema: formSchema,
	initialValues: {
		name: props.user.name,
		email: props.user.email
	}
});

const onSubmit = handleSubmit(() => {
	form.put(route('users.update', props.user.id), {
		onError: (errors) => {
			for (const [key, value] of Object.entries(errors)) {
				setFieldError(key as 'email' | 'name', value);
			}
		},
		onFinish: () => {
			toast({
				title: 'Success!',
				description: 'User updated successfully.',
				variant: 'success'
			});
		}
	});
});

const form = useForm({
	name: props.user.name,
	email: props.user.email
});
</script>

<template>
	<form @submit.prevent="onSubmit">
		<Card>
			<CardHeader>
				<CardTitle>
					<h2 class="text-lg">Account</h2>
				</CardTitle>
				<CardDescription>
					Update the user account's profile information and email address.
				</CardDescription>
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
								type="email"
								v-bind="componentField"
								v-model="form.email"
							/>
						</FormControl>
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
							class="text-sm text-success"
						>
							Saved.
						</p>
					</Transition>
				</div>
			</CardFooter>
		</Card>
	</form>
</template>
