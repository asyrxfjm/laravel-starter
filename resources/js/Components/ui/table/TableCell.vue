<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <td
        :class="
            cn(
                'px-4 py-2 align-middle [&:has([role=checkbox])]:pr-0',
                props.class,
            )
        "
    >
        <slot />
    </td>
</template>
