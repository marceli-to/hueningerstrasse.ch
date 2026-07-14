@props([
  'title' => '',
  'items' => [],
  'bg' => 'bg-sand',
])

<section class="{{ $bg }} pb-40 pt-30 md:pb-60 md:pt-40 lg:pb-80 lg:pt-60">
  <x-layout.inner>
    <div class="max-w-4xl mx-auto" data-reveal>
      <x-headings.h2>
        {{ $title }}
      </x-headings.h2>
      <div class="text-2xl md:text-3xl uppercase">
        @foreach($items as $item)
          <div class="py-10 md:py-15 border-t border-forest @if($loop->last) border-b @endif">{{ $item }}</div>
        @endforeach
      </div>
      <div class="mt-30 flex justify-end">
        <x-buttons.primary href="{{ route('page.living') }}" class="hover:bg-cream!">
          Übersicht
          <x-icons.arrow-right class="w-16 h-auto shrink-0 group-hover:translate-x-3 transition-transform" />
        </x-buttons.primary>
      </div>
    </div>
  </x-layout.inner>
</section>
