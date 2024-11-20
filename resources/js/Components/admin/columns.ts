import { User } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import Action from './Action.vue';

export const columns: ColumnDef<User>[] = [
    {
        accessorKey: 'email',
        header: () => {
            return h('div', {}, 'Email');
        },
        cell: ({ row }) => {
            const user = row.original;

            return h('div', {}, user.email);
        },
    },
    {
        accessorKey: 'name',
        header: () => {
            return h('div', {}, 'Name');
        },
        cell: ({ row }) => {
            const user = row.original;

            return h('div', {}, user.name);
        },
    },
    {
        id: 'actions',
        cell: ({ row }) => {
            const user = row.original;

            return h(
                'div',
                { class: ' text-right' },
                h(Action, {
                    user,
                }),
            );
        },
    },
];
