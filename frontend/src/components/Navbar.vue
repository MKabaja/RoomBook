<script setup lang="ts">
  import { useRouter } from 'vue-router';
  import { RouterLink } from 'vue-router';
  import AppLogo from '@/components/AppLogo.vue';
  import BaseButton from '@/components/BaseButton.vue';
  import { useAuthStore } from '@/stores/auth';
  import { getUserInitials } from '@/utils/strings';

  const router = useRouter();
  const authStore = useAuthStore();

  async function handleLogout() {
    await authStore.logout();
    router.push('/auth');
  }
</script>

<template>
  <nav class="flex items-center px-8 py-3 bg-surface border-b border-border">
    <RouterLink to="/rooms">
      <AppLogo size="md" />
    </RouterLink>

    <ul class="flex mx-auto gap-1">
      <li>
        <RouterLink
          to="/rooms"
          class="px-3 py-1.5 rounded-lg text-sm text-text-muted transition-colors duration-200 hover:text-text-primary hover:bg-elevated"
          active-class="text-text-primary bg-elevated "
        >
          Rooms
        </RouterLink>
      </li>
      <li>
        <RouterLink
          to="/bookings"
          class="px-3 py-1.5 rounded-lg text-sm text-text-muted transition-colors duration-200 hover:text-text-primary hover:bg-elevated"
          active-class="text-text-primary bg-elevated"
        >
          Bookings
        </RouterLink>
      </li>
    </ul>

    <div class="flex items-center gap-3">
      <div class="flex items-center gap-2">
        <div
          class="w-8 h-8 rounded-full bg-primary-muted border border-primary/30 flex items-center justify-center text-xs font-semibold text-primary-light"
        >
          {{ getUserInitials(authStore.user) }}
        </div>
        <span class="text-sm text-text-secondary">{{ authStore.user?.name }}</span>
      </div>
      <BaseButton variant="ghost" size="sm" label="Log out" @click="handleLogout" />
    </div>
  </nav>
</template>
