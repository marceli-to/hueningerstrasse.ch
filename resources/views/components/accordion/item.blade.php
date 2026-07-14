@props(['id'])
<div x-data="{ id: '{{ $id }}' }" {{ $attributes }}>
  {{ $slot }}
</div>
