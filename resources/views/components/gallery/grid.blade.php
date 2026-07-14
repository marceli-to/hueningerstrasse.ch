@props([
  'id' => 'gallery',
  'images' => [],
])

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12 md:gap-16 lg:gap-24" data-reveal>
  @foreach($images as $index => $image)
    <a
      href="{{ $image }}.jpg"
      data-lightbox="{{ $id }}"
      data-lightbox-index="{{ $index }}"
      class="block relative aspect-square overflow-hidden group">
      <picture class="block w-full h-full">
        <source srcset="{{ $image }}.avif" type="image/avif">
        <source srcset="{{ $image }}.webp" type="image/webp">
        <img
          src="{{ $image }}.jpg"
          alt=""
          loading="lazy"
          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
      </picture>
    </a>
  @endforeach
</div>
