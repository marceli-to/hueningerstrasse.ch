@props(['title'])
<button
  @click="active = active === id ? null : id"
  class="flex items-center justify-between w-full py-10 md:py-15 text-left cursor-pointer text-2xl md:text-3xl uppercase"
  :aria-expanded="active === id">
  <span>{{ $title }}</span>
  <span class="shrink-0 transition-transform duration-300" :class="{ 'rotate-180': active === id }">
    <x-icons.chevron-down class="w-30 h-auto" />
  </span>
</button>
