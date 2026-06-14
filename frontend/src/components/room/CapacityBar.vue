<script setup lang="ts">
type CapacityBarProps = {
  value: number
  max: number
}

defineProps<CapacityBarProps>()
</script>

<template>
  <progress :value="value" :max="max" class="progress-bar h-0.5" />
</template>
