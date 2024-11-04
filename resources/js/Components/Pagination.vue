<template>
	<div>
		<div class="items-center justify-end hidden py-2 space-x-1 md:flex">
			<template
				v-for="link in links"
				:key="link.url"
			>
				<Button
					:size="link.active ? 'sm' : 'xs'"
					v-if="link.url"
					as-child
					:variant="link.active ? 'default' : 'ghost'"
				>
					<Link
						:href="link.url"
						preserve-scroll
						v-html="link.label"
					>
					</Link>
				</Button>
				<Button
					v-else
					v-html="link.label"
					variant="ghost"
					disabled
					size="sm"
				/>
			</template>
		</div>
		<div class="flex items-center justify-between py-2 md:hidden">
			<div>
				<Button
					size="xs"
					as-child
					variant="default"
					v-if="currentPage > 1"
				>
					<Link
						:href="links[0].url"
						preserve-scroll
						v-html="`&laquo; Previous`"
					/>
				</Button>

				<Button
					size="xs"
					v-html="`&laquo; Previous`"
					variant="ghost"
					v-else
					disabled
				>
				</Button>
			</div>
			<div>
				<Button
					size="xs"
					variant="default"
					as-child
					v-if="currentPage >= 1 && currentPage < links.length - 2"
				>
					<Link
						:href="links[Number(currentPage) + 1].url"
						preserve-scroll
						v-html="`Next &raquo;`"
					/>
				</Button>
				<Button
					size="xs"
					v-html="`Next &raquo;`"
					variant="ghost"
					v-else
					disabled
				>
				</Button>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import { Link as PaginateLink } from '@/types';
import { Button } from './ui/button';
import { Link } from '@inertiajs/vue3';

defineProps<{
	links: PaginateLink[];
	currentPage: number;
}>();
</script>
