<script setup lang="ts">
type SectionHeaderProps = {
  title: string
  subtitle?: string
}

defineProps<SectionHeaderProps>()
</script>

<template>
  <header class="mb-6">
    <h1 class="text-lg font-semibold tracking-tight text-text-primary">{{ title }}</h1>
    <p v-if="subtitle" class="mt-0.5 text-xs text-text-secondary">{{ subtitle }}</p>
  </header>
</template>
