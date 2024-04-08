@props(['for' => '', 'class' => ''])
<label for="{{ $for }}" class="ml-4 lg:ml-6 cursor-pointer select-none {{ $class }}">
  {{ $slot }}
</label>