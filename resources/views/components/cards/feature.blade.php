@props([
  'label' => '',
  'class' => '',
])

<div class="{{ $class }} flex flex-col justify-center items-center text-center">
  <div class="w-48 h-48 md:w-56 md:h-56 flex items-center justify-center">
    {{ $slot }}
  </div>
  <strong>{!! $label !!}</strong>
</div>
