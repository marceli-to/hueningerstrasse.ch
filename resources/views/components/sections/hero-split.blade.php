@props([
  'bg' => 'bg-cream',
  'class' => '',
])

<section class="{{ $bg }}">
  <x-layout.inner class="!px-0 !max-w-none">
    <div class="lg:grid lg:grid-cols-2">

      <div class="py-40 md:py-60 pl-24 pr-48 xl:pr-64 self-center xl:ml-[calc((100vw_-_80rem)_/_2_+_24px)] xl:pl-0" data-reveal>
        {{ $slot }}
      </div>

      @if(isset($aside))
        {{ $aside }}
      @endif

    </div>
  </x-layout.inner>
</section>
