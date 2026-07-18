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
    class="font-bold text-[18.4px] md:text-[18.7px] lg:text-[23px] uppercase tracking-wide leading-none transition-colors hover:text-bordeaux {{ filter_var($active, FILTER_VALIDATE_BOOLEAN) ? 'text-bordeaux' : 'text-ink' }}">
    {{ $title }}
  </a>
</li>
