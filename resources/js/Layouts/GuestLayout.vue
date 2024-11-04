<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ToggleDarkMenu from '@/Components/ToggleDarkMenu.vue';
import { Link } from '@inertiajs/vue3';
import {
	Card,
	CardContent,
	CardDescription,
	CardFooter,
	CardHeader,
	CardTitle
} from '@/Components/ui/card';
</script>

<template>
	<div
		class="relative flex flex-col items-center justify-center min-h-screen pt-6 bg-gray-100 sm:pt-0 dark:bg-black"
	>
		<div class="absolute top-5 right-5">
			<ToggleDarkMenu />
		</div>

		<div>
			<Link href="/">
				<ApplicationLogo class="w-20 h-20 dark:text-white" />
			</Link>
		</div>

		<div class="w-full px-6 mt-6 overflow-hidden sm:max-w-md">
			<slot />
		</div>
	</div>
</template>
