@props([
  'name',
  'label',
  'rows' => 6,
])

<div>
  <label for="{{ $name }}" class="sr-only">{{ $label }}</label>
  <textarea
    id="{{ $name }}"
    name="{{ $name }}"
    rows="{{ $rows }}"
    placeholder="{{ $label }}"
    @error($name) aria-invalid="true" @enderror
    {{ $attributes->class([
      'w-full px-16 py-13 text-ink placeholder:text-ink/55 outline-none focus-visible:ring-2 focus-visible:ring-bordeaux transition resize-y',
      'bg-white' => ! $errors->has($name),
      'bg-red-100 ring-1 ring-red-400' => $errors->has($name),
    ]) }}></textarea>
</div>
