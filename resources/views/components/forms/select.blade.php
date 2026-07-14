@props(['id', 'label' => null, 'name' => null, 'options' => []])

<div class="w-full">
  @if($label)
    <label for="{{ $id }}" class="block font-bold uppercase tracking-wide text-md text-ink mb-8">
      {{ $label }}
    </label>
  @endif

  <div class="relative">
    <select
      id="{{ $id }}"
      name="{{ $name ?? $id }}"
      {{ $attributes->merge(['class' => 'block w-full appearance-none bg-bordeaux text-white px-16 py-12 pr-44 text-sm md:text-lg cursor-pointer outline-none focus-visible:ring-2 focus-visible:ring-ink/40']) }}>
      @foreach($options as $value => $text)
        <option value="{{ $value }}">{{ $text }}</option>
      @endforeach
    </select>
    <x-icons.chevron-down class="pointer-events-none absolute right-12 top-1/2 w-24 h-24 -translate-y-1/2 text-white" />
  </div>
</div>
