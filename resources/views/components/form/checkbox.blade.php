@props([
  'id',
  'error' => false,
  'multiline' => false,
])

<label for="{{ $id }}" @class([
  'flex cursor-pointer gap-12',
  'items-center' => ! $multiline,
  'items-start' => $multiline,
])>
  @if ($multiline)
    <span class="flex h-lh items-center">
  @endif
  <span class="group inline-grid size-20 grid-cols-1">
    <input
      id="{{ $id }}"
      type="checkbox"
      {{ $attributes->class([
        'col-start-1 row-start-1 appearance-none rounded-none border border-ink/30 focus-visible:outline-2 focus-visible:outline-bordeaux forced-colors:appearance-auto',
        'bg-white' => ! $error,
        'bg-red-100 border-red-400' => $error,
      ]) }}>
    <svg viewBox="0 0 14 14" fill="none" class="pointer-events-none col-start-1 row-start-1 size-7/8 self-center justify-self-center stroke-bordeaux">
      <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-not-has-checked:opacity-0" />
    </svg>
  </span>
  @if ($multiline)
    </span>
  @endif
  <span>{{ $slot }}</span>
</label>
