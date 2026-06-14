<script setup lang="ts">
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import { useAuthStore } from '@/stores/auth';
  import { getUserInitials } from '@/utils/strings';

  const router = useRouter();
  const authStore = useAuthStore();
  const isOpen = ref(false);

  function toggle() {
    isOpen.value = !isOpen.value;
  }

  function close() {
    isOpen.value = false;
  }

  async function logout() {
    close();
    await authStore.logout();
    router.push('/auth');
  }
</script>

<template>
  <div class="relative">
    <Transition
      enter-from-class="opacity-0"
      enter-active-class="transition-opacity duration-200"
      leave-active-class="transition-opacity duration-150"
      leave-to-class="opacity-0"
    >
      <div v-if="isOpen" class="fixed inset-0 z-10 bg-black/30 backdrop-blur-sm" @click="close" />
    </Transition>

    <button
      @click="toggle"
      class="flex items-center gap-2 rounded-lg px-2 py-1.5 transition-colors hover:bg-elevated"
    >
      <div
        class="flex h-8 w-8 items-center justify-center rounded-full border border-primary/30 bg-primary-muted text-xs font-semibold text-primary-light"
      >
        {{ getUserInitials(authStore.user) }}
      </div>
      <span class="hidden text-sm text-text-secondary sm:block">{{ authStore.user?.name }}</span>
    </button>

    <div
      v-if="isOpen"
      class="absolute right-0 top-full z-50 mt-2 w-52 overflow-hidden rounded-xl border border-border bg-elevated shadow-md"
    >
      <div class="border-b border-border px-4 py-3">
        <p class="text-sm font-semibold text-text-primary">{{ authStore.user?.name }}</p>
        <p class="mt-0.5 text-xs text-text-muted">{{ authStore.user?.email }}</p>
      </div>
      <div class="p-1">
        <button
          @click="logout"
          class="w-full rounded-lg px-3 py-2 text-left text-sm text-error transition-colors hover:bg-error/10"
        >
          Log out
        </button>
      </div>
    </div>
  </div>
</template>
