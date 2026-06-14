<script setup lang="ts">
defineProps<{
  class?: string
}>()

defineEmits<{
  submit: []
}>()
</script>

<template>
  <form :class="class" @submit.prevent="$emit('submit')">
    <slot />
  </form>
</template>
