@props([
  'href',
  'active' => false,
  'title' => null,
])
<li>
  <a
    href="{{ $href }}"
    aria-label="{{ $title }}"
    @if($active) aria-current="page" @endif
    class="font-bold text-lg md:text-xl lg:text-2xl uppercase tracking-wide leading-none transition-colors hover:text-bordeaux {{ filter_var($active, FILTER_VALIDATE_BOOLEAN) ? 'text-bordeaux' : 'text-ink' }}">
    {{ $title }}
  </a>
</li>
