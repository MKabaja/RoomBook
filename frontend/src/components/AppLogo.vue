<script setup lang="ts">
defineProps<{
  size?: 'sm' | 'md' | 'lg'
  subtitle?: boolean
}>()
</script>

<template>
  <div :class="subtitle ? 'text-center' : 'flex items-center gap-2'">
    <div
      :class="{
        'text-base': size === 'sm',
        'text-[16px]': size === 'md' || !size,
        'text-[22px]': size === 'lg'
      }"
      class="font-bold tracking-tight leading-none"
    >
      <span class="inline-block w-2 h-2 rounded-full bg-accent mr-1.5 mb-0.5" />
      Room<span class="text-primary">Book</span>
    </div>
    <div v-if="subtitle" class="mt-0.5 text-xs text-text-secondary">
      Room booking system
    </div>
  </div>
</template>
