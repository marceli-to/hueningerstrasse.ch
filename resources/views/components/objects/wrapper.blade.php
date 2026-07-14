@props([
  'objects' => collect(),
  'title' => '',
])

<div class="grid lg:grid-cols-2 gap-x-40 xl:gap-x-56 gap-y-40 items-center mt-32 md:mt-40">
  <div class="order-2 lg:order-1">
    <x-objects.iso class="max-w-xl mx-auto lg:mx-0" />
  </div>
  <div class="order-1 lg:order-2">
    <x-objects.table :objects="$objects" :title="$title" />
  </div>
</div>
