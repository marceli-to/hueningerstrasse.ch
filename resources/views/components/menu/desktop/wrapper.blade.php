<div class="{{ $class ?? '' }}">
  <nav>
    <ul class="flex items-baseline gap-x-28 md:gap-x-26 lg:gap-x-36">
      <x-menu.desktop.item href="{{ route('page.project') }}"    active="{{ request()->routeIs('page.project') }}"    title="Projekt" />
      <x-menu.desktop.item href="{{ route('page.location') }}"   active="{{ request()->routeIs('page.location') }}"   title="Lage" />
      <x-menu.desktop.item href="{{ route('page.commercial') }}" active="{{ request()->routeIs('page.commercial') }}" title="Gewerbe" />
      {{-- <x-menu.desktop.item href="{{ route('page.living') }}"     active="{{ request()->routeIs('page.living') }}"     title="Wohnen"     /> --}}
      <x-menu.desktop.item href="{{ route('page.contact') }}"    active="{{ request()->routeIs('page.contact') }}"    title="Kontakt" />
    </ul>
  </nav>
</div>
