@props([
  'href',
  'active' => false,
  'title' => null,
])
<li>
  <a
    href="{{ $href }}"
    aria-label="{{ $title }}"
    class="font-bold text-4xl uppercase tracking-wide leading-none transition-colors hover:text-bordeaux {{ filter_var($active, FILTER_VALIDATE_BOOLEAN) ? 'text-bordeaux' : 'text-ink' }}">
    {{ $title }}
  </a>
</li>
