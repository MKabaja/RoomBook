<script setup lang="ts">
  type InputType = 'text' | 'email' | 'password' | 'number' | 'datetime-local';

  type InputProps = {
    modelValue: string;
    label: string;
    type?: InputType;
    error?: string;
    placeholder?: string;
  };

  withDefaults(defineProps<InputProps>(), {
    type: 'text'
  });

  defineEmits<{
    'update:modelValue': [value: string];
  }>();
</script>

<template>
  <div class="flex flex-col gap-1.5">
    <label :for="label" class="text-xs font-medium tracking-wide text-text-secondary">
      {{ label }}
    </label>
    <input
      :id="label"
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      :class="[
        'w-full rounded-lg border bg-surface2 px-3 py-2 text-sm text-text-primary outline-none transition-colors placeholder:text-text-muted placeholder:opacity-60',
        error ? 'border-error' : 'border-border focus:border-primary'
      ]"
    />
    <span v-if="error" class="flex items-center gap-1 text-[11px] text-error"> ⚠ {{ error }} </span>
  </div>
</template>
