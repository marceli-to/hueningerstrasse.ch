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
    class="font-bold text-sm lg:text-lg uppercase tracking-wide leading-none transition-colors hover:text-bordeaux {{ filter_var($active, FILTER_VALIDATE_BOOLEAN) ? 'text-bordeaux' : 'text-ink' }}">
    {{ $title }}
  </a>
</li>
