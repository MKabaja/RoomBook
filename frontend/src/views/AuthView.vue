<script setup lang="ts">
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import { useAuthStore } from '@/stores/auth';
  import BaseForm from '@/components/BaseForm.vue';
  import BaseInput from '@/components/BaseInput.vue';
  import BaseButton from '@/components/BaseButton.vue';
  import AppLogo from '@/components/AppLogo.vue';
  import BaseAlert from '@/components/BaseAlert.vue';

  const router = useRouter();
  const authStore = useAuthStore();

  const isLogin = ref(true);

  const name = ref('');
  const email = ref('');
  const password = ref('');
  const passwordConfirmation = ref('');

  const isLoading = ref(false);
  const errors = ref<Record<string, string[]>>({});
  const generalError = ref<string | null>(null);

  function fieldError(field: string): string | undefined {
    return errors.value[field]?.[0];
  }

  async function handleSubmit() {
    errors.value = {};
    generalError.value = null;
    isLoading.value = true;
    try {
      if (isLogin.value) {
        await authStore.login(email.value, password.value);
      } else {
        await authStore.register(
          name.value,
          email.value,
          password.value,
          passwordConfirmation.value
        );
      }
      router.push('/rooms');
    } catch (err: any) {
      if (err.response?.status === 422) {
        errors.value = err.response.data.errors ?? {};
      } else {
        generalError.value = err.response?.data?.message ?? 'Something went wrong. Please try again.'
      }
    } finally {
      isLoading.value = false;
    }
  }

  function switchMode() {
    isLogin.value = !isLogin.value;
    errors.value = {};
    generalError.value = null;
  }
</script>

<template>
  <div
    class="flex min-h-screen items-center justify-center bg-[radial-gradient(ellipse_at_50%_0%,rgba(99,102,241,0.08)_0%,transparent_60%)] bg-bg px-4"
  >
    <div class="w-full max-w-95 overflow-hidden rounded-2xl border border-border bg-surface">
      <div class="grid grid-cols-2 border-b border-border">
        <button
          :class="[
            'py-3.5 text-[13px] font-medium transition-colors',
            isLogin
              ? 'bg-surface2 text-text-primary shadow-[inset_0_-2px_0_var(--color-primary)]'
              : 'text-text-secondary hover:text-text-primary'
          ]"
          @click="switchMode"
        >
          Sign in
        </button>
        <button
          :class="[
            'py-3.5 text-[13px] font-medium transition-colors',
            !isLogin
              ? 'bg-surface2 text-text-primary shadow-[inset_0_-2px_0_var(--color-primary)]'
              : 'text-text-secondary hover:text-text-primary'
          ]"
          @click="switchMode"
        >
          Register
        </button>
      </div>

      <div class="p-6">
        <div class="mb-6">
          <AppLogo size="lg" :subtitle="true" />
        </div>

        <BaseAlert v-if="generalError" :message="generalError" />

        <BaseForm class="flex flex-col gap-4" @submit="handleSubmit">
          <BaseInput
            v-if="!isLogin"
            v-model="name"
            label="Full name"
            placeholder="John Smith"
            :error="fieldError('name')"
          />
          <BaseInput
            v-model="email"
            label="Email address"
            type="email"
            placeholder="john@company.com"
            :error="fieldError('email')"
          />
          <BaseInput
            v-model="password"
            label="Password"
            type="password"
            placeholder="••••••••"
            :error="fieldError('password')"
          />
          <BaseInput
            v-if="!isLogin"
            v-model="passwordConfirmation"
            label="Confirm password"
            type="password"
            placeholder="••••••••"
            :error="fieldError('password_confirmation')"
          />

          <BaseButton
            :label="isLogin ? 'Sign in' : 'Create account'"
            :variant="isLoading ? 'disabled' : 'primary'"
            class="mt-2 w-full"
          />
        </BaseForm>
      </div>
    </div>
  </div>
</template>
