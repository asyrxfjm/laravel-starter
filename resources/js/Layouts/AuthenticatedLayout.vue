<script setup lang="ts">
import NavHeader from '@/Components/layout/NavHeader.vue';
import Sidebar from '@/Components/layout/Sidebar.vue';
import { Toaster } from '@/Components/ui/toast';
</script>

<template>
    <div class="flex min-h-screen w-full flex-col">
        <Toaster />
        <Sidebar class="fixed left-0 top-0 z-50" />
        <NavHeader class="fixed top-0 z-40 w-full" />
        <div
            class="ml-0 mt-14 flex flex-1 flex-col lg:ml-[220px] xl:ml-[280px]"
        >
            <div class="px-6 pt-6 font-semibold lg:px-6 lg:pt-6">
                <slot name="header" />
            </div>
            <main
                class="flex flex-1 flex-col gap-4 px-6 py-4 lg:gap-6 lg:px-6 lg:py-6"
            >
                <div
                    class="flex flex-1 flex-col gap-4 rounded-lg border px-6 py-4 shadow-sm lg:px-6 lg:py-6"
                >
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
