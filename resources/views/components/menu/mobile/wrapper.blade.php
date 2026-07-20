<div
  x-cloak
  x-show="menu"
  x-transition.opacity
  @keydown.escape.window="menu = false"
  class="fixed inset-0 z-60 flex items-center justify-center w-full h-dvh bg-sky md:hidden">
  <nav>
    <ul class="flex flex-col gap-y-32 items-center">
      <x-menu.mobile.item href="{{ route('page.project') }}"    active="{{ request()->routeIs('page.project') }}"    title="Projekt" />
      <x-menu.mobile.item href="{{ route('page.location') }}"   active="{{ request()->routeIs('page.location') }}"   title="Lage" />
      <x-menu.mobile.item href="{{ route('page.commercial') }}" active="{{ request()->routeIs('page.commercial') }}" title="Gewerbe" />
      {{-- <x-menu.mobile.item href="{{ route('page.living') }}"     active="{{ request()->routeIs('page.living') }}"     title="Wohnen"     /> --}}
      <x-menu.mobile.item href="{{ route('page.contact') }}"    active="{{ request()->routeIs('page.contact') }}"    title="Kontakt" />
    </ul>
  </nav>
</div>
