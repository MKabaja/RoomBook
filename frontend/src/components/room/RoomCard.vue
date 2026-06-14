<script setup lang="ts">
  import { useRouter } from 'vue-router';
  import type { Room } from '@/types';
  import CapacityBar from '@/components/room/CapacityBar.vue';
  import IconUsers from '@/components/icons/IconUsers.vue';
  import IconRoom from '@/components/icons/IconRoom.vue';

  type RoomCardProps = {
    room: Room;
  };

  const props = defineProps<RoomCardProps>();
  const router = useRouter();

  const MAX_CAPACITY = 30;

  function reserve() {
    router.push({ path: '/bookings/create', query: { roomId: props.room.id } });
  }
</script>

<template>
  <li
    class="group relative overflow-hidden rounded-xl border border-border bg-surface p-5 transition-all duration-200 hover:-translate-y-0.5 hover:border-primary"
  >
    <div
      class="absolute inset-x-0 top-0 h-0.5 bg-primary opacity-0 transition-opacity duration-200 group-hover:opacity-100"
    />

    <div
      class="mb-3.5 flex h-10 w-10 items-center justify-center rounded-xl bg-primary-muted text-primary-light"
    >
      <IconRoom :size="32" />
    </div>

    <div class="mb-1.5 text-base font-semibold text-text-primary">{{ room.name }}</div>

    <div class="mb-3.5 flex items-center gap-1.5 text-xs text-text-secondary">
      <IconUsers />
      Capacity: <strong class="text-text-primary">{{ room.capacity }} people</strong>
    </div>

    <CapacityBar :value="room.capacity" :max="MAX_CAPACITY" class="mb-4" />

    <div class="flex items-center">
      <button
        @click="reserve"
        class="inline-flex items-center rounded-lg bg-primary px-3 py-1.5 text-sm font-semibold text-white transition-colors duration-200 hover:bg-primary-hover"
      >
        Reserve →
      </button>
    </div>
  </li>
</template>
