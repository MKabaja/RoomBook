<script setup lang="ts">
import type { Booking } from '@/types'
import { useDateTime } from '@/composables/useDateTime'
import StatusBadge from '@/components/booking/StatusBadge.vue'
import BaseButton from '@/components/base/BaseButton.vue'

type BookingRowProps = {
  booking: Booking
}

const props = defineProps<BookingRowProps>()
const emit = defineEmits<{ cancel: [id: number] }>()

const { formatDateTime } = useDateTime()
</script>

<template>
  <tr class="border-b border-border transition-colors last:border-0 hover:bg-white/[0.02]">
    <td class="px-4 py-3.5 text-sm font-medium">
      {{ props.booking.room?.name ?? '—' }}
    </td>
    <td class="px-4 py-3.5">
      <div class="font-mono text-xs text-text-secondary">{{ formatDateTime(props.booking.starts_at) }}</div>
      <div class="font-mono text-xs text-text-secondary">{{ formatDateTime(props.booking.ends_at) }}</div>
    </td>
    <td class="px-4 py-3.5">
      <span class="font-mono text-xs">
        {{ props.booking.participants_count }} / {{ props.booking.room?.capacity ?? '—' }}
      </span>
    </td>
    <td class="px-4 py-3.5">
      <StatusBadge :status="props.booking.status" />
    </td>
    <td class="px-4 py-3.5">
      <BaseButton
        :variant="props.booking.status === 'cancelled' ? 'disabled' : 'danger'"
        size="sm"
        label="Cancel"
        @click="emit('cancel', props.booking.id)"
      />
    </td>
  </tr>
</template>
