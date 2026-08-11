<footer class="bg-white text-ink">

  <x-layout.inner class="py-28 md:py-39 lg:py-45">
    <div class="grid gap-x-40 gap-y-36 md:grid-cols-2 md:items-stretch">

      <div class="grid gap-x-40 gap-y-36 sm:grid-cols-2">

        <div class="text-lg md:text-xl leading-[1.5]">
          <h3 class="font-bold uppercase tracking-wide">Apleona Schweiz AG</h3>
          <p>Kornhausgasse 7<br>4051 Basel</p>
        </div>

        <div class="text-lg md:text-xl leading-[1.5]">
          <h3 class="font-bold uppercase tracking-wide">Kontakt</h3>
          <p>
            Frau Alessia Lavacca<br>
            Vermarkterin<br>
            <a href="mailto:mieten@apleona.com" class="transition-colors hover:text-bordeaux">mieten@apleona.com</a>
          </p>
        </div>

      </div>

      {{-- Unter md kleiner: 150px + 174px + 32px Abstand ergeben 356px und damit
           mehr, als die Inhaltsspalte auf dem Telefon hergibt (327px bei 375px
           Viewport, 272px bei 320px) – die Logos liefen also aus ihrer Spalte
           heraus. 110 + 128 + 24 = 262 passt auch auf dem schmalsten Geraet.
           Seitenverhaeltnis bleibt ueber h-auto erhalten, ab md sind die
           Groessen unveraendert. --}}
      <div class="flex h-full items-center justify-end gap-x-24 md:gap-x-41">
        <x-icons.logo-apleona class="w-110 md:w-180 h-auto shrink-0" />
        <x-icons.logo-medpension class="w-[128px] md:w-[209px] h-auto shrink-0" />
      </div>

    </div>
  </x-layout.inner>

  <div class="bg-sky">
    <x-layout.inner class="pt-8 pb-10 flex flex-wrap gap-x-28 gap-y-6 text-lg md:text-xl font-normal">
      <a href="{{ route('page.imprint') }}" class="transition-colors hover:text-bordeaux">Impressum</a>
      <a href="{{ route('page.privacy') }}" class="transition-colors hover:text-bordeaux">Datenschutz</a>
      <a href="https://stoz.ch" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-bordeaux">design by stoz</a>
    </x-layout.inner>
  </div>

</footer>
