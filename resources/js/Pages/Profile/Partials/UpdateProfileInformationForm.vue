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
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm as veeForm } from 'vee-validate';
import * as z from 'zod';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

const formSchema = toTypedSchema(
    z.object({
        name: z.string().min(2).max(50),
        email: z.string().min(2).max(50).email(),
    }),
);

const { handleSubmit, setFieldError } = veeForm({
    validationSchema: formSchema,
    initialValues: {
        name: user.name,
        email: user.email,
    },
});

const form = useForm({
    name: user.name,
    email: user.email,
});

const onSubmit = handleSubmit(() => {
    form.patch(route('profile.update'), {
        onError: (errors) => {
            for (const [key, value] of Object.entries(errors)) {
                setFieldError(key as 'email' | 'name', value);
            }
        },
    });
});
</script>

<template>
    <form @submit.prevent="onSubmit">
        <Card>
            <CardHeader>
                <CardTitle class="text-lg">Profile Information</CardTitle>
                <CardDescription>
                    Update your account's profile information and email address.
                </CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
                <FormField v-slot="{ componentField }" name="name">
                    <FormItem>
                        <FormLabel for="name">Name</FormLabel>
                        <FormControl>
                            <Input
                                type="text"
                                v-bind="componentField"
                                v-model="form.name"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="email">
                    <FormItem>
                        <FormLabel for="email">Email</FormLabel>
                        <FormControl>
                            <Input
                                type="email"
                                v-bind="componentField"
                                v-model="form.email"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <div v-if="mustVerifyEmail && user.email_verified_at === null">
                    <p class="mt-2 text-sm text-gray-800">
                        Your email address is unverified.
                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div
                        v-show="status === 'verification-link-sent'"
                        class="mt-2 text-sm font-medium text-green-600"
                    >
                        A new verification link has been sent to your email
                        address.
                    </div>
                </div>
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
