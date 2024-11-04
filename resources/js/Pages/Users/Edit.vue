<script setup lang="ts">
import {
	Breadcrumb,
	BreadcrumbList,
	BreadcrumbItem,
	BreadcrumbSeparator,
	BreadcrumbLink,
	BreadcrumbPage
} from '@/Components/ui/breadcrumb';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import UpdateUserProfile from './Partials/UpdateUserProfile.vue';
import DeleteUser from './Partials/DeleteUser.vue';

defineProps<{
	user: User;
}>();
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
							<Link :href="route('users.index')"> Users </Link>
						</BreadcrumbLink>
					</BreadcrumbItem>
					<BreadcrumbSeparator />
					<BreadcrumbItem>
						<BreadcrumbPage> Edit User </BreadcrumbPage>
					</BreadcrumbItem>
				</BreadcrumbList>
			</Breadcrumb>
		</template>

		<UpdateUserProfile :user="user" />

		<DeleteUser :user="user" />
	</AuthenticatedLayout>
</template>
