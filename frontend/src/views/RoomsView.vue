<script setup lang="ts">
  import { onMounted } from 'vue';
  import { useRooms } from '@/composables/useRooms';
  import RoomCard from '@/components/room/RoomCard.vue';
  import BaseAlert from '@/components/base/BaseAlert.vue';
  import SectionHeader from '@/components/sections/SectionHeader.vue';

  const { rooms, loading, error, fetchRooms } = useRooms();

  onMounted(fetchRooms);
</script>

<template>
  <main class="mx-auto max-w-6xl px-6 py-8">
    <SectionHeader title="Available rooms" subtitle="Select a room to make a reservation" />

    <div v-if="loading" class="flex items-center justify-center py-20 text-text-muted">
      Loading…
    </div>

    <BaseAlert v-else-if="error" :message="error" />

    <ul v-else class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <RoomCard v-for="room in rooms" :key="room.id" :room="room" />
    </ul>
  </main>
</template>
