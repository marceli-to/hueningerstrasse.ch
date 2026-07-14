@props([
  'name' => 'gallery',
  'images' => [],
  'alt' => '',
  'class' => '',
])

<div class="relative aspect-[4/3] lg:aspect-auto lg:h-full {{ $class }}">
  <x-swiper.wrapper class="{{ $name }}-swiper">
    @foreach($images as $image)
      <x-swiper.slide>
        <picture class="block w-full h-full">
          <source srcset="{{ $image }}.webp" type="image/webp">
          <img src="{{ $image }}.jpg" alt="{{ $alt }}" loading="lazy" class="w-full h-full object-cover" />
        </picture>
      </x-swiper.slide>
    @endforeach
  </x-swiper.wrapper>
  @if(count($images) > 1)
    <x-swiper.buttons.prev class="{{ $name }}-swiper-prev" />
    <x-swiper.buttons.next class="{{ $name }}-swiper-next" />
    <div class="{{ $name }}-swiper-pagination swiper-pagination absolute bottom-16 left-0 right-0 z-10"></div>
  @endif
</div>
