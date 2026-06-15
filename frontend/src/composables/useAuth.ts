import { ref, readonly } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { extractErrorMessage, parseValidationErrors } from '@/utils/errors'

export function useAuth() {
  const authStore = useAuthStore()

  const loading = ref(false)
  const errors = ref<Record<string, string[]>>({})
  const generalError = ref<string | null>(null)

  async function login(email: string, password: string): Promise<boolean> {
    loading.value = true
    resetErrors()

    try {
      await authStore.login(email, password)
      return true
    } catch (err) {
      handleAuthError(err)
      return false
    } finally {
      loading.value = false
    }
  }

  async function register(
    name: string,
    email: string,
    password: string,
    passwordConfirmation: string
  ): Promise<boolean> {
    loading.value = true
    resetErrors()

    try {
      await authStore.register(name, email, password, passwordConfirmation)
      return true
    } catch (err) {
      handleAuthError(err)
      return false
    } finally {
      loading.value = false
    }
  }

  function resetErrors(): void {
    errors.value = {}
    generalError.value = null
  }

  function handleAuthError(err: unknown): void {
    const fieldErrors = parseValidationErrors(err)
    if (fieldErrors) {
      errors.value = fieldErrors
      return
    }
    generalError.value = extractErrorMessage(err, 'Something went wrong. Please try again.')
  }

  const state = {
    loading: readonly(loading),
    errors: readonly(errors),
    generalError: readonly(generalError)
  }

  const actions = { login, register, resetErrors }

  return { ...state, ...actions }
}
