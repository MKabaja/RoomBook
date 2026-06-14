import type { User } from '@/types'

export function getUserInitials(user: User | null): string {
  if (!user) return '?'
  return (
    user.name
      .split(' ')
      .filter((n) => n.length > 0)
      .map((n) => n[0])
      .join('')
      .toUpperCase()
      .slice(0, 2) || '?'
  )
}
