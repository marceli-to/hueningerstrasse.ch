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
  $base = 'inline-flex items-center gap-10 bg-bordeaux hover:bg-ink text-white transition-colors font-bold uppercase tracking-wide text-[20.7px] md:text-[23px] leading-none pt-10 pb-12 px-15 rounded-[3px] group cursor-pointer';
@endphp

@if($tag === 'button')
<button type="{{ $type }}" {{ $attributes->merge(['class' => $base.' '.$class]) }} aria-label="{{ $title }}">
  {{ $slot }}
</button>
@else
<a href="{{ $href }}" target="{{ $target }}" rel="{{ $rel }}" aria-label="{{ $title }}" {{ $attributes->merge(['class' => $base.' '.$class]) }}>
  {{ $slot }}
</a>
@endif
