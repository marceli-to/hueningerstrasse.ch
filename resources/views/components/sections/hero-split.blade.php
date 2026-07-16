@props([
  'bg' => 'bg-white',
  'align' => 'start',
])

<section class="{{ $bg }} py-40 md:py-56 lg:py-64">
  <div class="lg:grid lg:grid-cols-2 {{ $align === 'center' ? 'lg:items-center' : 'lg:items-start' }}">

    {{-- Text: aligned to the container's left edge; the image gets the outer bleed --}}
    <div class="px-24 mb-32 lg:mb-0 lg:pr-48 xl:pr-64 xl:pl-0 xl:ml-[calc((100vw_-_80rem)_/_2_+_24px)]" data-reveal>
      {{ $slot }}
    </div>

    {{-- Image: runs out to the right edge of the viewport --}}
    @isset($aside)
      {{ $aside }}
    @endisset

  </div>
</section>
