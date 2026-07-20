@props([
  'class' => 'aspect-square md:aspect-[710/252]',
])

<x-layout.inner class="mt-56 md:mt-80">
  <div id="map" {{ $attributes->merge(['class' => 'w-full opacity-0 transition-opacity duration-700 ' . $class]) }}></div>
</x-layout.inner>