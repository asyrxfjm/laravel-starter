<script setup lang="ts">
import { columns } from '@/Components/admin/columns';
import DataTable from '@/Components/admin/DataTable.vue';
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
import { useToast } from '@/Components/ui/toast';

const props = defineProps<{
	users: PaginateMeta<User>;
	filters: Filters;
	message?: string;
	error?: string;
}>();

const { toast } = useToast();

if (props.message) {
	toast({
		title: 'Success!',
		description: props.message,
		variant: 'success'
	});
}

if (props.error) {
	toast({
		title: 'Error!',
		description: props.error,
		variant: 'destructive'
	});
}
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
						<BreadcrumbPage>Admin</BreadcrumbPage>
					</BreadcrumbItem>
				</BreadcrumbList>
			</Breadcrumb>
		</template>

		<DataTable
			:columns="columns"
			:data="users.data"
			:links="users.links"
			:filters="filters"
			:allow-create="true"
			:search-route="route('users.admin.index')"
		/>
	</AuthenticatedLayout>
</template>
