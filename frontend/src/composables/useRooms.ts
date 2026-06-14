import { ref, readonly } from 'vue'
import api from '@/api/axios'
import type { Room } from '@/types'
import { extractErrorMessage } from '@/utils/errors'

type RoomError = string | null

export function useRooms() {
  const rooms = ref<Room[]>([])
  const loading = ref(false)
  const error = ref<RoomError>(null)

  async function fetchRooms() {
    loading.value = true
    error.value = null

    try {
      const response = await api.get<Room[]>('/rooms')
      rooms.value = response.data
    } catch (err) {
      error.value = extractErrorMessage(err, 'Failed to load rooms. Please try again.')
    } finally {
      loading.value = false
    }
  }

  return {
    rooms: readonly(rooms),
    loading: readonly(loading),
    error: readonly(error),
    fetchRooms
  }
}
