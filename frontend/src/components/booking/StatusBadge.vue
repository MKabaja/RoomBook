<script setup lang="ts">
import { computed } from 'vue'
import type { BookingStatus } from '@/types'

type StatusBadgeProps = {
  status: BookingStatus
}

const props = defineProps<StatusBadgeProps>()

const classes = computed((): string => {
  const map: Record<BookingStatus, string> = {
    pending: 'bg-warning/10 text-warning',
    confirmed: 'bg-success/10 text-success',
    cancelled: 'bg-text-secondary/10 text-text-secondary'
  }
  return map[props.status]
})
</script>

<template>
  <span
    :class="[
      'inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 font-mono text-xs font-medium',
      classes
    ]"
  >
    <span class="size-1.5 rounded-full bg-current"></span>
    {{ status }}
  </span>
</template>
