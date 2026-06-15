import { ref, readonly } from 'vue'
import api from '@/api/axios'
import type { Booking, BookingFormData, PaginatedResponse } from '@/types'
import { extractErrorMessage, parseValidationErrors } from '@/utils/errors'

export function useBookings() {
  const bookings = ref<Booking[]>([])
  const loading = ref(false)
  const errors = ref<Record<string, string[]>>({})
  const generalError = ref<string | null>(null)

  async function fetchBookings(): Promise<void> {
    loading.value = true
    resetErrors()

    try {
      const response = await api.get<PaginatedResponse<Booking>>('/bookings')
      bookings.value = response.data.data
    } catch (err) {
      setGeneralError(err, 'Failed to load bookings. Please try again.')
    } finally {
      loading.value = false
    }
  }

  async function createBooking(data: BookingFormData): Promise<boolean> {
    loading.value = true
    resetErrors()

    try {
      await api.post('/bookings', data)
      return true
    } catch (err) {
      handleBookingError(err, 'Failed to create booking. Please try again.')
      return false
    } finally {
      loading.value = false
    }
  }

  async function cancelBooking(id: number): Promise<void> {
    generalError.value = null

    try {
      await api.patch(`/bookings/${id}/cancel`)
      await fetchBookings()
    } catch (err) {
      setGeneralError(err, 'Failed to cancel booking. Please try again.')
    }
  }

  function resetErrors(): void {
    errors.value = {}
    generalError.value = null
  }

  function setGeneralError(err: unknown, fallback: string): void {
    generalError.value = extractErrorMessage(err, fallback)
  }

  function handleBookingError(err: unknown, fallback: string): void {
    const fieldErrors = parseValidationErrors(err)
    if (fieldErrors) {
      errors.value = fieldErrors
      return
    }
    generalError.value = extractErrorMessage(err, fallback)
  }

  const state = {
    bookings: readonly(bookings),
    loading: readonly(loading),
    errors: readonly(errors),
    generalError: readonly(generalError)
  }

  const actions = {
    fetchBookings,
    createBooking,
    cancelBooking,
    resetErrors
  }

  return { ...state, ...actions }
}
