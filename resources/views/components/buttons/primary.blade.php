@props([
  'href' => '',
  'tag' => 'a',
  'class' => '',
  'target' => '_self',
  'rel' => '',
  'title' => '',
  'type' => 'button',
  'iconPosition' => 'after',
  'icon' => true,
])

@php
  $base = 'inline-flex items-center gap-10 bg-bordeaux hover:bg-ink text-white transition-colors font-bold uppercase tracking-wide text-sm md:text-lg leading-none py-14 px-20 group cursor-pointer';
@endphp

@if($tag === 'button')
<button type="{{ $type }}" class="{{ $base }} {{ $class }}" aria-label="{{ $title }}">
  {{ $slot }}
</button>
@else
<a href="{{ $href }}" class="{{ $base }} {{ $class }}" target="{{ $target }}" rel="{{ $rel }}" aria-label="{{ $title }}">
  {{ $slot }}
</a>
@endif
