@props([
  'image' => '',
  'alt' => '',
  'height' => 'h-[58vh] md:h-[72vh] xl:h-[78vh]',
  'class' => '',
])

<figure class="w-full {{ $class }}">
  <picture class="block w-full">
    <source srcset="/img/{{ $image }}.webp" type="image/webp">
    <img
      src="/img/{{ $image }}.jpg"
      alt="{{ $alt }}"
      class="w-full {{ $height }} object-cover">
  </picture>
</figure>
