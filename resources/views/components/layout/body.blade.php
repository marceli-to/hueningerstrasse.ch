<body
  class="antialiased bg-white font-sans text-ink text-md md:text-lg leading-[1.55] flex flex-col min-h-screen"
  x-data="{ menu: false }">
  {{ $slot }}
  @stack('scripts')
</body>
