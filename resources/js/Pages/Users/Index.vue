<script setup lang="ts">
import { columns } from '@/Components/users/columns';
import DataTable from '@/Components/users/DataTable.vue';
import {
	Breadcrumb,
	BreadcrumbList,
	BreadcrumbItem,
	BreadcrumbSeparator,
	BreadcrumbLink,
	BreadcrumbPage
} from '@/Components/ui/breadcrumb';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { PaginateMeta, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
	users: PaginateMeta<User>;
	filters: Filters;
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
						<BreadcrumbPage>Users</BreadcrumbPage>
					</BreadcrumbItem>
					<BreadcrumbSeparator />
					<BreadcrumbItem>
						<BreadcrumbPage>All</BreadcrumbPage>
					</BreadcrumbItem>
				</BreadcrumbList>
			</Breadcrumb>
		</template>

		<DataTable
			:columns="columns"
			:data="users.data"
			:links="users.links"
			:filters="filters"
		/>
	</AuthenticatedLayout>
</template>
