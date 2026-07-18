@php
  // Startseite: Header liegt transparent über dem Hero, Hintergrund blendet erst
  // nach 30vh Scroll ein. Übrige Seiten behalten den durchgehenden sky-Balken.
  $overlay = request()->routeIs('page.project');
@endphp

<header
  @class([
    'w-full top-0 z-50',
    'sticky bg-sky' => ! $overlay,
    'fixed transition-colors duration-300' => $overlay,
  ])
  @if($overlay)
    x-data="{ scrolled: false }"
    x-init="scrolled = window.scrollY > window.innerHeight * 0.3"
    @scroll.window.passive="scrolled = window.scrollY > window.innerHeight * 0.3"
    :class="scrolled ? 'bg-sky' : 'bg-transparent'"
  @endif
>
  {{-- Menü steht direkt nach dem Logo und sitzt auf dessen Unterkante (siehe
       resources/design/…_Ansicht.pdf). Abstände dort im Verhältnis zur Logobreite:
       Logo→Menü 0.38, Menüpunkte 0.21 – hier auf w-130/150/170 umgerechnet. --}}
  <x-layout.inner class="flex items-end md:gap-x-46 lg:gap-x-65 py-24 md:py-30">

    <a href="{{ route('page.project') }}" aria-label="Hüningerstrasse 40 – Startseite" class="shrink-0 relative z-70">
      <x-icons.logo class="w-150 md:w-138 lg:w-196 h-auto block" />
    </a>

    <x-menu.desktop.wrapper class="hidden md:block translate-y-[3px]" />
    <x-menu.mobile.button class="md:hidden ml-auto" />

  </x-layout.inner>

  <x-menu.mobile.wrapper />
</header>
