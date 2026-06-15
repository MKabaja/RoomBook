<script setup lang="ts">
import type { Room } from '@/types'
import { useDateTime } from '@/composables/useDateTime'

type BookingSummaryProps = {
  room: Room | null
  startsAt: string
  endsAt: string
  duration: string | null
  participantsCount: string
}

const props = defineProps<BookingSummaryProps>()

const { formatDateTime } = useDateTime()
</script>

<template>
  <div class="sticky top-5 rounded-xl border border-border bg-surface p-5">
    <p class="mb-4 font-mono text-xs uppercase tracking-widest text-text-secondary">Summary</p>

    <div class="divide-y divide-border">
      <div class="flex justify-between py-2 text-sm">
        <span class="text-text-secondary">Room</span>
        <span class="font-medium">{{ props.room?.name ?? '—' }}</span>
      </div>
      <div class="flex justify-between py-2 text-sm">
        <span class="text-text-secondary">From</span>
        <span class="font-mono text-xs font-medium">{{ formatDateTime(props.startsAt) }}</span>
      </div>
      <div class="flex justify-between py-2 text-sm">
        <span class="text-text-secondary">To</span>
        <span class="font-mono text-xs font-medium">{{ formatDateTime(props.endsAt) }}</span>
      </div>
      <div class="flex justify-between py-2 text-sm">
        <span class="text-text-secondary">Duration</span>
        <span class="font-medium">{{ props.duration ?? '—' }}</span>
      </div>
      <div class="flex justify-between py-2 text-sm">
        <span class="text-text-secondary">Participants</span>
        <span class="font-mono text-xs font-medium">
          {{ props.participantsCount || '—' }} / {{ props.room?.capacity ?? '—' }}
        </span>
      </div>
      <div class="flex items-center justify-between py-2 text-sm">
        <span class="text-text-secondary">Status</span>
        <span class="inline-flex items-center gap-1.5 rounded-full bg-warning/10 px-2.5 py-0.5 font-mono text-xs font-medium text-warning">
          <span class="size-1.5 rounded-full bg-current"></span>
          pending
        </span>
      </div>
    </div>
  </div>
</template>
