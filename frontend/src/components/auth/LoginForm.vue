<script setup lang="ts">
import { ref } from 'vue'
import BaseForm from '@/components/base/BaseForm.vue'
import BaseInput from '@/components/base/BaseInput.vue'
import BaseButton from '@/components/base/BaseButton.vue'

type LoginFormProps = {
  loading: boolean
  errors: Record<string, readonly string[]>
}

export type LoginFormData = {
  email: string
  password: string
}

const props = withDefaults(defineProps<LoginFormProps>(), {
  loading: false,
  errors: () => ({})
})

const emit = defineEmits<{ submit: [data: LoginFormData] }>()

const email = ref('')
const password = ref('')

function handleSubmit(): void {
  emit('submit', { email: email.value, password: password.value })
}
</script>

<template>
  <BaseForm class="flex flex-col gap-4" @submit="handleSubmit">
    <BaseInput
      v-model="email"
      label="Email address"
      type="email"
      placeholder="john@company.com"
      :error="props.errors['email']?.[0]"
    />
    <BaseInput
      v-model="password"
      label="Password"
      type="password"
      placeholder="••••••••"
      :error="props.errors['password']?.[0]"
    />
    <BaseButton
      :label="props.loading ? 'Signing in…' : 'Sign in'"
      :variant="props.loading ? 'disabled' : 'primary'"
      class="mt-2 w-full"
    />
  </BaseForm>
</template>
