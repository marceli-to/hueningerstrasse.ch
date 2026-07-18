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
    @error($name) aria-invalid="true" aria-describedby="{{ $name }}-error" @enderror
    {{ $attributes->class([
      'w-full px-16 py-13 text-ink placeholder:text-ink placeholder:opacity-100 outline-none focus-visible:ring-2 focus-visible:ring-bordeaux transition resize-y',
      'bg-white' => ! $errors->has($name),
      'bg-error-bg ring-1 ring-error-border' => $errors->has($name),
    ]) }}></textarea>
  @error($name)
    <p id="{{ $name }}-error" class="mt-6 text-sm text-error">{{ $message }}</p>
  @enderror
</div>
