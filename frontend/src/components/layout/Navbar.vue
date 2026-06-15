<script setup lang="ts">
  import { RouterLink } from 'vue-router';
  import AppLogo from '@/components/layout/AppLogo.vue';
  import UserMenu from '@/components/layout/UserMenu.vue';
</script>

<template>
  <nav class="relative z-20 flex items-center border-b border-border bg-surface px-8 py-1">
    <RouterLink to="/rooms">
      <AppLogo size="md" />
    </RouterLink>

    <ul class="mx-auto flex gap-1">
      <li>
        <RouterLink
          to="/rooms"
          class="rounded-lg px-3 py-1.5 text-sm text-text-muted transition-colors duration-200 hover:bg-elevated hover:text-text-primary"
          active-class="bg-elevated text-text-primary"
        >
          Rooms
        </RouterLink>
      </li>
      <li>
        <RouterLink
          to="/bookings"
          class="rounded-lg px-3 py-1.5 text-sm text-text-muted transition-colors duration-200 hover:bg-elevated hover:text-text-primary"
          active-class="bg-elevated text-text-primary"
        >
          Bookings
        </RouterLink>
      </li>
    </ul>

    <UserMenu />
  </nav>
</template>
