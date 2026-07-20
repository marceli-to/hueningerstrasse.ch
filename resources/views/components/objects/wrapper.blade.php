@props([
  'objects' => collect(),
  'title' => '',
  'variant' => 'living',
])

<div class="grid lg:grid-cols-2 gap-x-40 xl:gap-x-56 gap-y-40 items-start mt-32 md:mt-40">
  <div>
    <x-objects.table :objects="$objects" :title="$title" :variant="$variant" />
  </div>
  <div>
    <x-objects.iso class="max-w-xl mx-auto lg:mx-0" />
  </div>
</div>
