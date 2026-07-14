<button
  @click="menu = !menu"
  :aria-expanded="menu"
  aria-label="Menü"
  class="relative z-70 w-44 h-44 cursor-pointer flex items-center justify-center text-ink {{ $class ?? '' }}">
  <x-icons.burger x-show="!menu" class="w-26 h-auto" />
  <x-icons.cross x-show="menu" x-cloak class="w-20 h-auto" />
</button>
