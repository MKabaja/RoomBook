<script setup lang="ts">
type AlertVariant = 'error' | 'warning' | 'success'

type AlertProps = {
  message: string
  variant?: AlertVariant
}

withDefaults(defineProps<AlertProps>(), {
  variant: 'error'
})

const styles: Record<AlertVariant, string> = {
  error: 'border-error/30 bg-error/10 text-error',
  warning: 'border-warning/30 bg-warning/10 text-warning',
  success: 'border-success/30 bg-success/10 text-success'
}
</script>

<template>
  <div :class="['rounded-lg border px-4 py-3 text-sm', styles[variant]]">
    {{ message }}
  </div>
</template>
