import axios from 'axios'

export function extractErrorMessage(err: unknown, fallback: string): string {
  if (axios.isAxiosError(err) && err.response?.data?.message) {
    return err.response.data.message
  }
  return fallback
}

export function parseValidationErrors(err: unknown): Record<string, string[]> | null {
  if (axios.isAxiosError(err) && err.response?.status === 422) {
    return err.response.data.errors ?? {}
  }
  return null
}
