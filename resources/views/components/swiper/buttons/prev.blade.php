@props([
  'class' => '',
  'arrowClass' => ''
])

<button aria-label="Zurück" class="swiper-button-prev absolute top-1/2 left-20 -translate-y-1/2 z-10 cursor-pointer w-40 h-40 flex items-center justify-center border border-white/70 rounded-full bg-black/20 text-white backdrop-blur-sm hover:bg-black/40 transition-colors {{ $class }}">
  <x-icons.arrow-right class="w-16 h-auto rotate-180 {{ $arrowClass ?? '' }}" />
</button>
