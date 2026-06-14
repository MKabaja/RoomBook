<script setup lang="ts">
import { computed } from 'vue'

type Variants = 'primary' | 'accent' | 'danger' | 'ghost' | 'disabled'
type Sizes = 'sm' | 'md' | 'lg'

type ButtonProps = {
  href?: string
  variant?: Variants
  size?: Sizes
  label: string
  className?: string
}

const props = withDefaults(defineProps<ButtonProps>(), {
  variant: 'primary',
  size: 'md'
})

function buttonClasses(variant: Variants, size: Sizes) {
  const base = 'inline-flex items-center justify-center font-semibold rounded-lg transition duration-200 cursor-pointer'

  const variants: Record<Variants, string> = {
    primary:  'bg-primary text-white hover:bg-primary-hover shadow-sm hover:shadow-glow',
    accent:   'bg-accent text-bg hover:bg-accent-hover shadow-sm',
    danger:   'bg-error text-white hover:opacity-90 shadow-sm',
    ghost:    'bg-transparent text-text-secondary border border-border hover:border-hover hover:text-text-primary',
    disabled: 'bg-surface2 text-text-muted cursor-not-allowed opacity-60'
  }

  const sizes: Record<Sizes, string> = {
    sm: 'px-3 py-1.5 text-sm',
    md: 'px-4 py-2 text-sm',
    lg: 'px-5 py-3 text-base'
  }

  return `${base} ${variants[variant]} ${sizes[size]}`
}

const classes = computed(() => buttonClasses(props.variant, props.size))
</script>

<template>
  <a v-if="href" :class="[classes, className]" :href="href" :inert="variant === 'disabled' || undefined">{{ label }}</a>
  <button v-else :class="[classes, className]" :disabled="variant === 'disabled'">{{ label }}</button>
</template>
