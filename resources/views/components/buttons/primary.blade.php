@props([
  'href' => '',
  'tag' => 'a',
  'class' => '',
  'target' => '_self',
  'rel' => '',
  'title' => '',
  'type' => 'button',
])

@php
  $base = 'inline-flex items-center gap-10 bg-bordeaux hover:bg-ink text-white transition-colors font-bold uppercase tracking-wide text-[20.7px] md:text-[23px] leading-none pt-10 pb-11 px-13 rounded-[2px] group cursor-pointer';
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
