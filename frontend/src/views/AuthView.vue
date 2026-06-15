<script setup lang="ts">
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import { useAuth } from '@/composables/useAuth';
  import AppLogo from '@/components/layout/AppLogo.vue';
  import BaseAlert from '@/components/base/BaseAlert.vue';
  import LoginForm from '@/components/auth/LoginForm.vue';
  import RegisterForm from '@/components/auth/RegisterForm.vue';
  import type { LoginFormData } from '@/components/auth/LoginForm.vue';
  import type { RegisterFormData } from '@/components/auth/RegisterForm.vue';

  const router = useRouter();
  const { login, register, loading, errors, generalError, resetErrors } = useAuth();

  const isLogin = ref(true);

  function switchMode(mode: boolean): void {
    isLogin.value = mode;
    resetErrors();
  }

  async function handleLogin({ email, password }: LoginFormData): Promise<void> {
    const ok = await login(email, password);
    if (ok) router.push('/rooms');
  }

  async function handleRegister({
    name,
    email,
    password,
    passwordConfirmation
  }: RegisterFormData): Promise<void> {
    const ok = await register(name, email, password, passwordConfirmation);
    if (ok) router.push('/rooms');
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
          @click="switchMode(true)"
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
          @click="switchMode(false)"
        >
          Register
        </button>
      </div>

      <div class="p-6">
        <div class="mb-6">
          <AppLogo size="lg" :subtitle="true" />
        </div>

        <BaseAlert v-if="generalError" :message="generalError" class="mb-4" />

        <LoginForm v-if="isLogin" :loading="loading" :errors="errors" @submit="handleLogin" />
        <RegisterForm v-else :loading="loading" :errors="errors" @submit="handleRegister" />
      </div>
    </div>
  </div>
</template>
