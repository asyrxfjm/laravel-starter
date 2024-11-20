<script setup lang="ts">
import { Button } from '@/Components/ui/button';
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
import { useForm } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm as veeForm } from 'vee-validate';
import { ref } from 'vue';
import * as z from 'zod';

const confirmingUserDeletion = ref(false);

const formSchema = toTypedSchema(
    z.object({
        password: z.string().min(8).max(50),
    }),
);

const { handleSubmit, setFieldError } = veeForm({
    validationSchema: formSchema,
});

const form = useForm({
    password: '',
});

const onEnter = handleSubmit(() => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onError: (errors) => {
            console.log('errors', errors);

            for (const [key, value] of Object.entries(errors)) {
                setFieldError(key as 'password', value);

                const firstError = Object.keys(errors)[0];

                form.reset(firstError as 'password');

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

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium">Delete Account</h2>

            <p class="mt-1 text-sm">
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Before deleting your account, please
                download any data or information that you wish to retain.
            </p>
        </header>

        <Dialog :open="confirmingUserDeletion">
            <DialogTrigger as-child @click="confirmingUserDeletion = true">
                <Button variant="destructive">Delete Account</Button>
            </DialogTrigger>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>
                        Are you sure you want to delete your account?
                    </DialogTitle>
                    <DialogDescription>
                        Once your account is deleted, all of its resources and
                        data will be permanently deleted. Please enter your
                        password to confirm you would like to permanently delete
                        your account.
                    </DialogDescription>
                </DialogHeader>
                <FormField v-slot="{ componentField }" name="password">
                    <FormItem>
                        <FormControl>
                            <Input
                                type="password"
                                v-bind="componentField"
                                v-model="form.password"
                                @keyup.enter="onEnter"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <DialogFooter>
                    <Button variant="secondary" @click="closeModal">
                        Cancel
                    </Button>
                    <Button variant="destructive"> Delete Account </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </section>
</template>
