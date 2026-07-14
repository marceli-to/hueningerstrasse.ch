<footer class="bg-sky text-ink">

  <x-layout.inner class="py-40 md:py-56 lg:py-64">
    <div class="grid gap-x-40 gap-y-36 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_auto] lg:items-end">

      <div class="text-sm md:text-md leading-[1.6]">
        <p class="font-bold uppercase tracking-wide mb-6">Apleona Schweiz AG</p>
        <p>Kornhausgasse 7<br>4051 Basel</p>
      </div>

      <div class="text-sm md:text-md leading-[1.6]">
        <p class="font-bold uppercase tracking-wide mb-6">Kontakt</p>
        <p>
          Frau Alessia Lavacca<br>
          Vermarkterin<br>
          <a href="mailto:mieten@apleona.com" class="transition-colors hover:text-bordeaux">mieten@apleona.com</a>
        </p>
      </div>

      <div class="flex items-center gap-x-28 md:gap-x-36">
        <x-icons.logo-apleona class="w-130 md:w-150 h-auto" />
        <x-icons.logo-medpension class="w-120 md:w-140 h-auto" />
      </div>

    </div>
  </x-layout.inner>

  <div class="border-t border-ink/15">
    <x-layout.inner class="py-14 flex flex-wrap gap-x-28 gap-y-6 text-sm">
      <a href="{{ route('page.imprint') }}" class="transition-colors hover:text-bordeaux">Impressum</a>
      <a href="{{ route('page.privacy') }}" class="transition-colors hover:text-bordeaux">Datenschutz</a>
      <a href="https://stoz.ch" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-bordeaux">design by stoz</a>
    </x-layout.inner>
  </div>

</footer>
