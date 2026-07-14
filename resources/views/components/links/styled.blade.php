@props([
  'href' => '',
  'target' => '_self',
  'rel' => '',
  'class' => 'text-bordeaux transition-colors hover:text-ink',
])

<a href="{{ $href }}" target="{{ $target }}" rel="{{ $rel }}" class="{{ $class }}">{{ $slot }}</a>
