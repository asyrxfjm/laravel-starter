<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
} from '@/Components/ui/card';
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/Components/ui/form';
import { Input } from '@/Components/ui/input';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm as veeForm } from 'vee-validate';
import * as z from 'zod';

defineProps<{
    canResetPassword?: boolean;
}>();

const formSchema = toTypedSchema(
    z.object({
        email: z.string().min(2).max(50).email(),
        password: z.string().min(8).max(50),
    }),
);

const { handleSubmit, setFieldError } = veeForm({
    validationSchema: formSchema,
});

const onSubmit = handleSubmit(() => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
        onError: (errors) => {
            for (const [key, value] of Object.entries(errors)) {
                setFieldError(key as 'email' | 'password', value);
            }
        },
    });
});

const form = useForm({
    email: '',
    password: '',
});
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <form @submit.prevent="onSubmit">
            <Card>
                <CardHeader>
                    <CardTitle class="text-2xl"> Login </CardTitle>
                    <CardDescription>
                        Enter your email below to login to your account
                    </CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormLabel for="email">Email</FormLabel>
                            <FormControl>
                                <Input
                                    id="email"
                                    type="email"
                                    placeholder="your@email.com"
                                    v-bind="componentField"
                                    v-model="form.email"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="password">
                        <FormItem>
                            <FormLabel for="password">
                                <div class="flex items-center justify-between">
                                    <p>Password</p>
                                    <Link :href="route('password.request')">
                                        <Button variant="link" size="xs" as="a">
                                            Forgot your password?
                                        </Button>
                                    </Link>
                                </div>
                            </FormLabel>
                            <FormControl>
                                <Input
                                    id="password"
                                    type="password"
                                    v-bind="componentField"
                                    v-model="form.password"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </CardContent>
                <CardContent>
                    <Button
                        type="submit"
                        class="w-full"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        :loading="form.processing"
                    >
                        Login
                    </Button>
                </CardContent>
                <CardContent>
                    <div class="text-center text-sm">
                        Don't have an account?
                        <Link :href="route('register')" class="underline">
                            Sign up
                        </Link>
                    </div>
                </CardContent>
            </Card>
        </form>
    </GuestLayout>
</template>
