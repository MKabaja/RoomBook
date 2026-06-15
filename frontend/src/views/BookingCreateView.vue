<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useRooms } from '@/composables/useRooms'
import { useBookingForm } from '@/composables/useBookingForm'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseInput from '@/components/base/BaseInput.vue'
import BookingSummary from '@/components/booking/BookingSummary.vue'
import SectionHeader from '@/components/sections/SectionHeader.vue'

const route = useRoute()
const router = useRouter()

const { rooms, fetchRooms } = useRooms()

const roomId = computed(() => {
  const id = route.query.roomId
  return typeof id === 'string' ? Number(id) : null
})

const room = computed(() => rooms.value.find((r) => r.id === roomId.value) ?? null)

const { startsAt, endsAt, participantsCount, duration, loading, errors, generalError, submit } =
  useBookingForm(roomId)

async function handleSubmit() {
  const success = await submit()
  if (success) router.push('/bookings')
}

onMounted(fetchRooms)
</script>

<template>
  <main class="mx-auto max-w-6xl px-6 py-8">
    <SectionHeader title="New reservation" subtitle="Fill in the booking details">
      <template #action>
        <BaseButton variant="ghost" size="sm" label="← Back to rooms" @click="router.push('/rooms')" />
      </template>
    </SectionHeader>

    <div class="flex items-start gap-5">
      <div class="min-w-0 flex-1">
        <div
          v-if="room"
          class="mb-5 inline-flex items-center gap-2 rounded-lg border border-primary/30 bg-primary-muted px-3 py-2 text-sm"
        >
          <span class="size-1.5 rounded-full bg-primary"></span>
          <span class="text-text-secondary">Room:</span>
          <strong class="text-text-primary">{{ room.name }}</strong>
          <span class="text-text-secondary">· max {{ room.capacity }} people</span>
        </div>

        <BaseAlert v-if="generalError" :message="generalError" class="mb-4" />

        <div class="overflow-hidden rounded-xl border border-border bg-surface">
          <div class="border-b border-border px-5 py-4">
            <h2 class="text-sm font-semibold">Booking details</h2>
          </div>
          <form class="p-5" @submit.prevent="handleSubmit">
            <div class="mb-4 grid grid-cols-2 gap-3">
              <BaseInput
                v-model="startsAt"
                label="Start date & time"
                type="datetime-local"
                :error="errors['starts_at']?.[0]"
              />
              <BaseInput
                v-model="endsAt"
                label="End date & time"
                type="datetime-local"
                :error="errors['ends_at']?.[0]"
              />
            </div>

            <div class="mb-5">
              <BaseInput
                v-model="participantsCount"
                label="Number of participants"
                type="number"
                placeholder="e.g. 8"
                :error="errors['participants_count']?.[0]"
              />
              <p v-if="room" class="mt-1 text-xs text-text-muted">
                Maximum {{ room.capacity }} people
              </p>
            </div>

            <BaseButton
              :variant="loading ? 'disabled' : 'accent'"
              label="Book the room"
              class="w-full"
            />
          </form>
        </div>
      </div>

      <BookingSummary
        class="w-80 shrink-0"
        :room="room"
        :starts-at="startsAt"
        :ends-at="endsAt"
        :duration="duration"
        :participants-count="participantsCount"
      />
    </div>
  </main>
</template>
