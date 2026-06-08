<script setup lang="ts">
  import { ref } from 'vue'

  const count = ref(0)
</script>

<template>
  <div class="min-h-screen bg-bg flex items-center justify-center">
    <div
      class="bg-surface border border-border rounded-xl p-10 flex flex-col items-center gap-6 shadow-md"
    >
      <h1 class="text-3xl font-bold text-text-primary font-sans">RoomBook</h1>
      <p class="text-text-secondary">Tailwind v4 + theme variables działają poprawnie</p>

      <div class="flex gap-3">
        <span class="px-3 py-1 rounded-full text-xs font-medium bg-primary-muted text-primary-light"
          >primary</span
        >
        <span class="px-3 py-1 rounded-full text-xs font-medium bg-success/10 text-success"
          >success</span
        >
        <span class="px-3 py-1 rounded-full text-xs font-medium bg-error/10 text-error">error</span>
        <span class="px-3 py-1 rounded-full text-xs font-medium bg-accent/10 text-accent"
          >accent</span
        >
      </div>

      <button
        class="px-6 py-2 bg-primary hover:bg-primary-hover text-text-primary rounded-lg font-medium transition-colors cursor-pointer"
        @click="count++"
      >
        Kliknięto {{ count }} razy
      </button>

      <p class="text-text-muted text-sm font-mono">DM Sans + DM Mono</p>
    </div>
  </div>
</template>
