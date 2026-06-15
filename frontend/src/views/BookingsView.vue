<script setup lang="ts">
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useBookings } from '@/composables/useBookings'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BookingRow from '@/components/booking/BookingRow.vue'
import SectionHeader from '@/components/sections/SectionHeader.vue'

const router = useRouter()
const { bookings, loading, generalError, fetchBookings, cancelBooking } = useBookings()

async function handleCancel(id: number): Promise<void> {
  if (!window.confirm('Are you sure you want to cancel this booking?')) return
  await cancelBooking(id)
}

onMounted(fetchBookings)
</script>

<template>
  <main class="mx-auto max-w-6xl px-6 py-8">
    <SectionHeader title="My bookings" subtitle="History and active reservations">
      <template #action>
        <BaseButton label="+ New booking" size="sm" @click="router.push('/rooms')" />
      </template>
    </SectionHeader>

    <BaseAlert v-if="generalError" :message="generalError" class="mb-4" />

    <div v-if="loading" class="py-16 text-center text-sm text-text-muted">Loading…</div>

    <div v-else-if="bookings.length === 0" class="py-16 text-center">
      <p class="text-sm text-text-muted">No bookings yet</p>
      <p class="mt-1 text-xs text-text-muted opacity-70">Reserve a room to get started</p>
    </div>

    <div v-else class="overflow-hidden rounded-xl border border-border bg-surface">
      <table class="w-full border-collapse">
        <thead>
          <tr>
            <th
              v-for="col in ['Room', 'Date', 'Participants', 'Status', 'Actions']"
              :key="col"
              class="border-b border-border px-4 py-2.5 text-left font-mono text-[11px] font-medium uppercase tracking-widest text-text-secondary"
            >
              {{ col }}
            </th>
          </tr>
        </thead>
        <tbody>
          <BookingRow
            v-for="booking in bookings"
            :key="booking.id"
            :booking="booking"
            @cancel="handleCancel"
          />
        </tbody>
      </table>
    </div>
  </main>
</template>
