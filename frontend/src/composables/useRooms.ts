import { ref, readonly } from 'vue'
import api from '@/api/axios'
import type { Room } from '@/types'
import { extractErrorMessage } from '@/utils/errors'

export function useRooms() {
  const rooms = ref<Room[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  async function fetchRooms(): Promise<void> {
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

  const state = {
    rooms: readonly(rooms),
    loading: readonly(loading),
    error: readonly(error)
  }

  const actions = {
    fetchRooms
  }

  return { ...state, ...actions }
}
