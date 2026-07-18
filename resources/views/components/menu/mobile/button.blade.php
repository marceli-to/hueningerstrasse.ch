<button
  @click="menu = !menu"
  :aria-expanded="menu"
  aria-label="Menü"
  class="relative z-70 w-44 h-44 cursor-pointer flex items-center justify-center text-ink {{ $class ?? '' }}">
  <span x-show="!menu"><x-icons.burger class="w-26 h-auto" /></span>
  <span x-show="menu" x-cloak><x-icons.cross class="w-26 h-auto" /></span>
</button>
