<script lang="ts" setup>
import { Label } from '@/Components/ui/label';
import { cn } from '@/lib/utils';
import type { LabelProps } from 'radix-vue';
import type { HTMLAttributes } from 'vue';
import { useFormField } from './useFormField';

const props = defineProps<
    LabelProps & { class?: HTMLAttributes['class']; required?: boolean }
>();

const { error, formItemId } = useFormField();
</script>

<template>
    <Label
        :class="cn(error && 'text-destructive', props.class)"
        :for="formItemId"
    >
        <slot /> {{ props.required ? ' *' : '' }}
    </Label>
</template>
