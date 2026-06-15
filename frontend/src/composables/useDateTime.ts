export function useDateTime() {
  function formatDateTime(value: string): string {
    if (!value) return '—'
    const date = new Date(value)
    if (isNaN(date.getTime())) return '—'
    return (
      date.toLocaleDateString('pl-PL', { day: '2-digit', month: '2-digit' }) +
      ' ' +
      date.toLocaleTimeString('pl-PL', { hour: '2-digit', minute: '2-digit' })
    )
  }

  function calculateDuration(start: string, end: string): string | null {
    const diffMs = new Date(end).getTime() - new Date(start).getTime()
    if (!diffMs || diffMs <= 0) return null
    const hours = Math.floor(diffMs / 3_600_000)
    const minutes = Math.floor((diffMs % 3_600_000) / 60_000)
    const formatter = new Intl.DurationFormat('pl-PL', { style: 'short' })
    return formatter.format({ hours, minutes })
  }

  return { formatDateTime, calculateDuration }
}
