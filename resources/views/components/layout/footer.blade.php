@if (!Route::is('page.privacy') && !Route::is('page.imprint'))
<x-layout.section class="relative !p-0">
  <x-misc.map />
</x-layout.section>
@endif
<footer>
  @if (!Route::is('page.privacy') && !Route::is('page.imprint'))
  <div class="bg-white px-15 py-20 md:px-25 md:py-30">
    <x-layout.inner>
      <x-layout.grid>
        <x-layout.span class="md:col-span-8">
          <h3>Kontakt</h3>
          <div class="md:flex md:gap-x-45">
            <div class="mb-20 md:mb-0">
              Apleona Schweiz AG<br>
              Kornhausgasse 7<br>
              4051 Basel
            </div>
            <div>
              Alessia Lavacca<br>
              <a href="tel:+41 61 205 22 32">+41 61 205 22 32</a><br>
              <a href="mailto:alessia.lavacca@apleona.com" target="_blank" rel="noopener">alessia.lavacca@apleona.com</a>
            </div>
          </div>
        </x-layout.span>
        <x-layout.span class="md:col-span-4 sm:flex sm:items-end md:items-center sm:justify-end">
          <x-icons.logo-apleona class="w-150 md:w-180 xl:w-220 h-auto" />
        </x-layout.span>
      </x-layout.grid>
    </x-layout.inner>
  </div>
  @endif
  <div class="bg-forest text-white font-bold tracking-wide text-sm md:text-base py-10 px-15 md:px-25">
    <x-layout.inner>
      <nav>
        <ul class="flex gap-x-15 lg:gap-x-25">
          <li>
            <a href="{{ route('page.imprint') }}" title="Impressum">Impressum</a>
          </li>
          <li>
            <a href="{{ route('page.privacy') }}" title="Datenschutz">Datenschutz</a>
          </li>
          <li>
            <a href="https://stoz.ch" target="_blank" title="stoz.ch" rel="noopener">design by stoz</a>
          </li>
        </ul>
      </nav>
    </x-layout.inner>
  </div>
</footer>
@livewireScripts
@vite('resources/js/app.js')
</body>
</html>
<!-- made with ❤ by stoz.ch & marceli.to -->