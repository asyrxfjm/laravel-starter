<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import {
	Breadcrumb,
	BreadcrumbList,
	BreadcrumbItem,
	BreadcrumbSeparator,
	BreadcrumbLink
} from '@/Components/ui/breadcrumb';

defineProps<{
	mustVerifyEmail?: boolean;
	status?: string;
}>();
</script>

<template>
	<Head title="Profile" />

	<AuthenticatedLayout>
		<template #header>
			<Breadcrumb>
				<BreadcrumbList>
					<BreadcrumbItem>
						<BreadcrumbLink :href="route('dashboard')"> Dashboard </BreadcrumbLink>
					</BreadcrumbItem>
					<BreadcrumbSeparator />
					<BreadcrumbItem>
						<BreadcrumbPage> My Profile </BreadcrumbPage>
					</BreadcrumbItem>
				</BreadcrumbList>
			</Breadcrumb>
		</template>
		<div class="flex flex-col h-full space-y-6">
			<UpdateProfileInformationForm />
			<UpdatePasswordForm />
			<DeleteUserForm />
		</div>
	</AuthenticatedLayout>
</template>
