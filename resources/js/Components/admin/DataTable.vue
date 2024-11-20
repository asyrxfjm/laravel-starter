<script setup lang="ts" generic="TData, TValue">
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table';
import { Link as PaginateLink } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import type { ColumnDef } from '@tanstack/vue-table';
import { FlexRender, getCoreRowModel, useVueTable } from '@tanstack/vue-table';
import { useDebounceFn } from '@vueuse/core';
import { ref, watch } from 'vue';
import Pagination from '../Pagination.vue';

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
    links: PaginateLink[];
    filters: Filters;
    allowCreate: boolean;
    searchRoute: string;
}>();

let search = ref(props.filters.search);

const table = useVueTable({
    get data() {
        return props.data;
    },
    get columns() {
        return props.columns;
    },
    getCoreRowModel: getCoreRowModel(),
});

const triggerSearch = useDebounceFn(() => {
    router.get(
        props.searchRoute,
        {
            search: search.value,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
}, 500);

watch(search, () => {
    triggerSearch();
});
</script>

<template>
    <div>
        <div
            class="flex flex-col items-start justify-between gap-y-3 pb-4 md:flex-row md:items-center md:gap-y-0"
        >
            <Input
                class="md:max-w-xs"
                placeholder="Search by email, full name"
                v-model="search"
            />
            <Button v-if="allowCreate" as-child variant="secondary">
                <Link
                    :href="
                        route('users.create', {
                            role: 'Admin',
                        })
                    "
                >
                    Create a new Admin
                </Link>
            </Button>
        </div>
        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow
                        v-for="headerGroup in table.getHeaderGroups()"
                        :key="headerGroup.id"
                    >
                        <TableHead
                            v-for="header in headerGroup.headers"
                            :key="header.id"
                        >
                            <FlexRender
                                v-if="!header.isPlaceholder"
                                :render="header.column.columnDef.header"
                                :props="header.getContext()"
                            />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <TableRow
                            v-for="row in table.getRowModel().rows"
                            :key="row.id"
                            :data-state="
                                row.getIsSelected() ? 'selected' : undefined
                            "
                        >
                            <TableCell
                                v-for="cell in row.getVisibleCells()"
                                :key="cell.id"
                                class="text-nowrap"
                            >
                                <FlexRender
                                    :render="cell.column.columnDef.cell"
                                    :props="cell.getContext()"
                                />
                            </TableCell>
                        </TableRow>
                    </template>
                    <template v-else>
                        <TableRow>
                            <TableCell
                                :colspan="columns.length"
                                class="h-24 text-center"
                            >
                                No results.
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>
        <Pagination :links="links" :current-page="filters.page" />
    </div>
</template>
