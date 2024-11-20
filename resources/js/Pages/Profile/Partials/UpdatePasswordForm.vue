<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card';
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/Components/ui/form';
import { Input } from '@/Components/ui/input';
import { useForm } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm as veeForm } from 'vee-validate';
import * as z from 'zod';

const formSchema = toTypedSchema(
    z
        .object({
            current_password: z.string().min(8).max(50),
            password: z.string().min(8).max(50),
            password_confirmation: z.string().min(8).max(50),
        })
        .refine((data) => data.password === data.password_confirmation, {
            message: 'Password must match',
            path: ['password_confirmation'],
        }),
);

const { handleSubmit, setFieldError } = veeForm({
    validationSchema: formSchema,
});

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const onSubmit = handleSubmit(() => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            for (const [key, value] of Object.entries(errors)) {
                setFieldError(
                    key as
                        | 'current_password'
                        | 'password'
                        | 'password_confirmation',
                    value,
                );

                const firstError = Object.keys(errors)[0];

                form.reset(firstError as 'current_password' | 'password');

                const el: HTMLInputElement | null = document.querySelector(
                    `[name="${firstError}"]`,
                );

                el?.scrollIntoView({
                    behavior: 'smooth',
                });

                el?.focus();
            }
        },
    });
});
</script>

<template>
    <form @submit.prevent="onSubmit">
        <Card>
            <CardHeader>
                <CardTitle>
                    <h2 class="text-lg">Update Password</h2>
                </CardTitle>
                <CardDescription>
                    Ensure your account is using a long, random password to stay
                    secure.
                </CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
                <FormField v-slot="{ componentField }" name="current_password">
                    <FormItem>
                        <FormLabel for="current_password">
                            Current Password
                        </FormLabel>
                        <FormControl>
                            <Input
                                type="password"
                                v-bind="componentField"
                                v-model="form.current_password"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="password">
                    <FormItem>
                        <FormLabel for="password">Password</FormLabel>
                        <FormControl>
                            <Input
                                type="password"
                                v-bind="componentField"
                                v-model="form.password"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField
                    v-slot="{ componentField }"
                    name="password_confirmation"
                >
                    <FormItem>
                        <FormLabel for="password_confirmation">
                            Confirm Password
                        </FormLabel>
                        <FormControl>
                            <Input
                                type="password"
                                v-bind="componentField"
                                v-model="form.password_confirmation"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </CardContent>
            <CardFooter>
                <div class="flex items-center gap-4">
                    <Button :disabled="form.processing">Save</Button>

                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p
                            v-if="form.recentlySuccessful"
                            class="text-sm text-success"
                        >
                            Saved.
                        </p>
                    </Transition>
                </div>
            </CardFooter>
        </Card>
    </form>
</template>
