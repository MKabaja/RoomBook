<script setup lang="ts">
import { ref } from 'vue'
import BaseForm from '@/components/base/BaseForm.vue'
import BaseInput from '@/components/base/BaseInput.vue'
import BaseButton from '@/components/base/BaseButton.vue'

type RegisterFormProps = {
  loading: boolean
  errors: Record<string, readonly string[]>
}

export type RegisterFormData = {
  name: string
  email: string
  password: string
  passwordConfirmation: string
}

const props = withDefaults(defineProps<RegisterFormProps>(), {
  loading: false,
  errors: () => ({})
})

const emit = defineEmits<{ submit: [data: RegisterFormData] }>()

const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')

function handleSubmit(): void {
  emit('submit', {
    name: name.value,
    email: email.value,
    password: password.value,
    passwordConfirmation: passwordConfirmation.value
  })
}
</script>

<template>
  <BaseForm class="flex flex-col gap-4" @submit="handleSubmit">
    <BaseInput
      v-model="name"
      label="Full name"
      placeholder="John Smith"
      :error="props.errors['name']?.[0]"
    />
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
    <BaseInput
      v-model="passwordConfirmation"
      label="Confirm password"
      type="password"
      placeholder="••••••••"
      :error="props.errors['password_confirmation']?.[0]"
    />
    <BaseButton
      :label="props.loading ? 'Creating account…' : 'Create account'"
      :variant="props.loading ? 'disabled' : 'primary'"
      class="mt-2 w-full"
    />
  </BaseForm>
</template>
