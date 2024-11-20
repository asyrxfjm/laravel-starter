<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardFooter } from '@/Components/ui/card';
import {
    FormControl,
    FormField,
    FormItem,
    FormMessage,
} from '@/Components/ui/form';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm as veeForm } from 'vee-validate';
import * as z from 'zod';

const props = defineProps<{
    email: string;
    token: string;
}>();

const formSchema = toTypedSchema(
    z
        .object({
            email: z.string().default(props.email),
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
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const onSubmit = handleSubmit(() => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
        onError: (errors) => {
            for (const [key, value] of Object.entries(errors)) {
                setFieldError(key as 'email', value);
            }
        },
    });
});
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <form @submit.prevent="onSubmit">
            <Card>
                <CardContent class="space-y-4 pt-5">
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormControl>
                                <Label>Email</Label>
                                <Input
                                    type="email"
                                    placeholder="your@email.com"
                                    v-bind="componentField"
                                    v-model="form.email"
                                    autocomplete="username"
                                    disabled
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="password">
                        <FormItem>
                            <FormControl>
                                <Label>Password</Label>
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
                            <FormControl>
                                <Label>Password Confirmation</Label>
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
                    <Button
                        type="submit"
                        class="w-full"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Reset Password
                    </Button>
                </CardFooter>
            </Card>
            <!-- <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </PrimaryButton>
            </div> -->
        </form>
    </GuestLayout>
</template>
