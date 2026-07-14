<div class="{{ $class ?? '' }}">
  <nav>
    <ul class="flex items-center gap-x-24 lg:gap-x-40">
      <x-menu.desktop.item href="{{ route('page.project') }}"    active="{{ request()->routeIs('page.project') }}"    title="Projekt" />
      <x-menu.desktop.item href="{{ route('page.location') }}"   active="{{ request()->routeIs('page.location') }}"   title="Lage" />
      <x-menu.desktop.item href="{{ route('page.commercial') }}" active="{{ request()->routeIs('page.commercial') }}" title="Gewerbe" />
      <x-menu.desktop.item href="{{ route('page.living') }}"     active="{{ request()->routeIs('page.living') }}"     title="Wohnungen" />
      <x-menu.desktop.item href="{{ route('page.contact') }}"    active="{{ request()->routeIs('page.contact') }}"    title="Kontakt" />
    </ul>
  </nav>
</div>
