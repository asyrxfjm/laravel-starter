import { User } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import Action from './Action.vue';
import { Badge } from '../ui/badge';

export const columns: ColumnDef<User>[] = [
	{
		accessorKey: 'email',
		header: () => {
			return h('div', {}, 'Email');
		},
		cell: ({ row }) => {
			const user = row.original;

			return h('div', {}, user.email);
		}
	},
	{
		accessorKey: 'name',
		header: () => {
			return h('div', {}, 'Name');
		},
		cell: ({ row }) => {
			const user = row.original;

			return h('div', {}, user.name);
		}
	},
	{
		accessorKey: 'roles',
		header: () => 'Roles',
		cell: ({ row }) => {
			const roles = row.original.roles;
			if (!roles) {
				return;
			}

			return h(Badge, { class: 'space-x-2' }, () => {
				return roles.map((role) => {
					return h('span', {}, role.name);
				});
			});
		}
	},
	{
		id: 'actions',
		cell: ({ row }) => {
			const user = row.original;

			return h(
				'div',
				{ class: ' text-right' },
				h(Action, {
					user
				})
			);
		}
	}
];
