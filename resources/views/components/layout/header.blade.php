<header class="bg-sky w-full sticky top-0 z-50">
  <x-layout.inner class="flex items-center justify-between gap-x-30 py-16 md:py-20">

    <a href="{{ route('page.project') }}" aria-label="Hüningerstrasse 40 – Startseite" class="shrink-0 relative z-70">
      <x-icons.logo class="w-130 md:w-150 lg:w-170 h-auto" />
    </a>

    <x-menu.desktop.wrapper class="hidden md:block" />
    <x-menu.mobile.button class="md:hidden" />

  </x-layout.inner>

  <x-menu.mobile.wrapper />
</header>
