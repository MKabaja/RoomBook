import { ref, computed } from 'vue'
import type { Ref } from 'vue'
import { useBookings } from '@/composables/useBookings'
import { useDateTime } from '@/composables/useDateTime'

export function useBookingForm(roomId: Ref<number | null>) {
  const { calculateDuration } = useDateTime()
  const { loading, errors, generalError, createBooking, resetErrors } = useBookings()

  const startsAt = ref('')
  const endsAt = ref('')
  const participantsCount = ref('')

  const duration = computed(() => calculateDuration(startsAt.value, endsAt.value))

  async function submit(): Promise<boolean> {
    if (!roomId.value || !startsAt.value || !endsAt.value) return false

    return createBooking({
      room_id: roomId.value,
      starts_at: new Date(startsAt.value).toISOString(),
      ends_at: new Date(endsAt.value).toISOString(),
      participants_count: Number(participantsCount.value)
    })
  }

  return {
    startsAt,
    endsAt,
    participantsCount,
    duration,
    loading,
    errors,
    generalError,
    submit,
    resetErrors
  }
}
