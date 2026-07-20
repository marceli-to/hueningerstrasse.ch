<body
  class="antialiased bg-white font-sans font-light text-ink text-xl md:text-2xl leading-[1.4] flex flex-col min-h-screen"
  x-data="{ menu: false }">
  {{ $slot }}

  {{-- Alpine kommt aus Livewire. Livewire spielt sein Script aber nur auf Seiten
       aus, die eine Livewire-Komponente rendern (hier nur /kontakt). Ohne den
       expliziten Aufruf fehlt Alpine auf allen anderen Seiten: Mobile-Menü und
       der einblendende Header-Hintergrund auf der Startseite bleiben tot. --}}
  @livewireScripts

  @stack('scripts')
</body>
