<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import {
	DropdownMenu,
	DropdownMenuContent,
	DropdownMenuItem,
	DropdownMenuLabel,
	DropdownMenuSeparator,
	DropdownMenuTrigger
} from '@/Components/ui/dropdown-menu';
import { User } from '@/types';
import { MoreHorizontal } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

defineProps<{
	user: User;
}>();
</script>

<template>
	<DropdownMenu>
		<DropdownMenuTrigger as-child>
			<Button
				variant="ghost"
				class="w-8 h-8 p-0"
			>
				<span class="sr-only">Open menu</span>
				<MoreHorizontal class="w-4 h-4" />
			</Button>
		</DropdownMenuTrigger>
		<DropdownMenuContent align="end">
			<DropdownMenuLabel>Actions</DropdownMenuLabel>
			<DropdownMenuSeparator />
			<DropdownMenuItem as-child>
				<Link :href="route('users.edit', user.id)"> View </Link>
			</DropdownMenuItem>
		</DropdownMenuContent>
	</DropdownMenu>
</template>
