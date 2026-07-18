<body
  class="antialiased bg-white font-sans font-light text-ink text-xl md:text-2xl leading-[1.4] flex flex-col min-h-screen"
  x-data="{ menu: false }">
  {{ $slot }}
  @stack('scripts')
</body>
