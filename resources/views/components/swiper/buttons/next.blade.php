@props([
  'class' => '',
  'arrowClass' => ''
])

<button aria-label="Weiter" class="swiper-button-next absolute top-1/2 right-20 -translate-y-1/2 z-10 cursor-pointer w-40 h-40 flex items-center justify-center text-white hover:opacity-70 transition-opacity {{ $class }}">
  <x-icons.chevron-right class="w-18 h-auto {{ $arrowClass ?? '' }}" />
</button>
