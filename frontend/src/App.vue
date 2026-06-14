<script setup lang="ts">
import { useAuthStore } from '@/stores/auth'
import Navbar from '@/components/Navbar.vue'

const authStore = useAuthStore()
</script>

<template>
  <Navbar v-if="authStore.isAuthenticated" />
  <router-view />
</template>
