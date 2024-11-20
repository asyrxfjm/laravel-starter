<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ToggleDarkMenu from '@/Components/ToggleDarkMenu.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="relative flex min-h-screen flex-col items-center justify-center bg-gray-100 pt-6 dark:bg-black sm:pt-0"
    >
        <div class="absolute right-5 top-5">
            <ToggleDarkMenu />
        </div>

        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 dark:text-white" />
            </Link>
        </div>

        <div class="mt-6 w-full overflow-hidden px-6 sm:max-w-md">
            <slot />
        </div>
    </div>
</template>
