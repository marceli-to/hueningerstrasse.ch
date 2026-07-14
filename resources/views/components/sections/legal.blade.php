@props([
  'title' => '',
  'class' => '',
])

<section class="py-40">
  <x-layout.inner>
    <x-headings.h1>
      {{ $title }}
    </x-headings.h1>
    <div class="{{ $class }}">
      {{ $slot }}
    </div>
  </x-layout.inner>
</section>
