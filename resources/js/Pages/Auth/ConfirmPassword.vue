<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import { CardContent, CardDescription, CardHeader } from '@/Components/ui/card';
import CardFooter from '@/Components/ui/card/CardFooter.vue';
import {
    FormControl,
    FormField,
    FormItem,
    FormMessage,
} from '@/Components/ui/form';
import { Input } from '@/Components/ui/input';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm as veeForm } from 'vee-validate';
import * as z from 'zod';

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

const onSubmit = handleSubmit(() => {
    form.post(route('password.confirm'), {
        onError: (errors) => {
            for (const [key, value] of Object.entries(errors)) {
                setFieldError(key as 'password', value);
            }
        },
    });
});
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <form @submit.prevent="onSubmit">
            <CardHeader>
                <CardTitle class="text-2xl"> Confirm Password </CardTitle>
                <CardDescription>
                    This is a secure area of the application. Please confirm
                    your password before continuing.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <FormField v-slot="{ componentField }" name="password">
                    <FormItem>
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
            </CardContent>
            <CardFooter>
                <Button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    :loading="form.processing"
                >
                    Confirm
                </Button>
            </CardFooter>
            <!-- <div>
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="block w-full mt-1"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex justify-end mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Confirm
                </PrimaryButton>
            </div> -->
        </form>
    </GuestLayout>
</template>
