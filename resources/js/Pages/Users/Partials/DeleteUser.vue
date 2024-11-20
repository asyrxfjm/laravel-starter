<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog';
import {
    FormControl,
    FormField,
    FormItem,
    FormMessage,
} from '@/Components/ui/form';
import { Input } from '@/Components/ui/input';
import { User } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm as veeForm } from 'vee-validate';
import { ref } from 'vue';
import { z } from 'zod';

const props = defineProps<{
    user: User;
}>();

const confirmingUserDeletion = ref(false);

const formSchema = toTypedSchema(
    z
        .object({
            email: z.string().email(),
        })
        .refine((data) => data.email === props.user.email, {
            message: 'Email does not match',
            path: ['email'],
        }),
);

const { handleSubmit, setFieldError } = veeForm({
    validationSchema: formSchema,
    initialValues: {
        email: props.user.email,
    },
});

const submit = handleSubmit(() => {
    form.delete(route('users.destroy', props.user.id), {
        preserveScroll: true,
        onError: (errors) => {
            console.log('errors', errors);

            for (const [key, value] of Object.entries(errors)) {
                setFieldError(key as 'email', value);

                const firstError = Object.keys(errors)[0];

                form.reset(firstError as 'email');

                const el: HTMLInputElement | null = document.querySelector(
                    `[name="${firstError}"]`,
                );

                el?.scrollIntoView({
                    behavior: 'smooth',
                });

                el?.focus();
            }
        },
        onFinish: () => {
            form.reset();
        },
    });
});

const form = useForm({
    email: '',
});

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>
                <h2 class="text-lg">Delete Account</h2>
            </CardTitle>
            <CardDescription>
                Once the account is deleted, all of its resources and data will
                be permanently deleted. Before deleting the account, please
                download any data or information that you wish to retain.
            </CardDescription>
        </CardHeader>
        <CardContent>
            <Dialog :open="confirmingUserDeletion">
                <DialogTrigger as-child @click="confirmingUserDeletion = true">
                    <Button variant="destructive">Delete Account</Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>
                            Are you sure you want to delete this account?
                        </DialogTitle>
                        <DialogDescription>
                            Once the account is deleted, all of its resources
                            and data will be permanently deleted. Please enter
                            <b>
                                <i>{{ user.email }}</i>
                            </b>
                            to confirm you would like to permanently delete the
                            account.
                        </DialogDescription>
                    </DialogHeader>
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormControl>
                                <Input
                                    id="email"
                                    type="text"
                                    v-bind="componentField"
                                    v-model="form.email"
                                    @keyup.enter="submit"
                                    autocomplete="off"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <DialogFooter>
                        <Button variant="secondary" @click="closeModal">
                            Cancel
                        </Button>
                        <Button variant="destructive" @click="submit">
                            Delete Account
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </CardContent>
    </Card>
</template>
