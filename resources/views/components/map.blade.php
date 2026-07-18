@props([
  'class' => 'aspect-square md:aspect-[710/252]',
])

<x-layout.inner>
  <div id="map" {{ $attributes->merge(['class' => 'w-full opacity-0 transition-opacity duration-700 ' . $class]) }}></div>
</x-layout.inner>