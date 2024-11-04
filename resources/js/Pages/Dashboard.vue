<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Breadcrumb, BreadcrumbList, BreadcrumbItem } from '@/Components/ui/breadcrumb';
import { Head } from '@inertiajs/vue3';
</script>

<template>
	<Head title="Dashboard" />

	<AuthenticatedLayout>
		<template #header>
			<Breadcrumb>
				<BreadcrumbList>
					<BreadcrumbItem>
						<BreadcrumbPage>Dashboard</BreadcrumbPage>
					</BreadcrumbItem>
				</BreadcrumbList>
			</Breadcrumb>
		</template>
	</AuthenticatedLayout>
</template>
