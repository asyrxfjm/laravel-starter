<script setup lang="ts">
import { Toaster } from '@/Components/ui/toast';
import NavHeader from '@/Components/layout/NavHeader.vue';
import Sidebar from '@/Components/layout/Sidebar.vue';
</script>

<template>
	<div class="flex flex-col w-full min-h-screen">
		<Toaster />
		<Sidebar class="fixed top-0 left-0 z-50" />
		<NavHeader class="fixed top-0 z-40 w-full" />
		<div class="flex flex-col flex-1 ml-0 lg:ml-[220px] xl:ml-[280px] mt-14">
			<div class="px-6 pt-6 font-semibold lg:px-6 lg:pt-6">
				<slot name="header" />
			</div>
			<main class="flex flex-col flex-1 gap-4 px-6 py-4 lg:gap-6 lg:px-6 lg:py-6">
				<div
					class="flex flex-col flex-1 gap-4 px-6 py-4 border rounded-lg shadow-sm lg:px-6 lg:py-6"
				>
					<slot />
				</div>
			</main>
		</div>
	</div>
</template>
