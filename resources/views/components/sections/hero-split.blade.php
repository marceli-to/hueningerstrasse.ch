@props([
  'bg' => 'bg-white',
  'align' => 'start',
])

<section class="{{ $bg }} pb-40 md:pb-56 lg:pb-64">
  <div class="lg:grid lg:grid-cols-2 lg:gap-x-[6vw] xl:gap-x-[9vw] {{ $align === 'center' ? 'lg:items-center' : 'lg:items-start' }}">

    {{-- Text: aligned to the container's left edge; the image gets the outer bleed --}}
    <div class="px-24 pt-22 md:pt-34 mb-32 lg:mb-0 xl:pl-0 xl:pr-0 xl:ml-[calc((100vw_-_80rem)_/_2_+_24px)]" data-reveal>
      {{ $slot }}
    </div>

    {{-- Image: runs out to the right edge of the viewport --}}
    @isset($aside)
      {{ $aside }}
    @endisset

  </div>
</section>
