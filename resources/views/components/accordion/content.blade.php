<div
  x-show="active === id"
  x-collapse
  x-cloak>
  <div class="pb-15 text-lg md:text-2xl">
    {{ $slot }}
  </div>
</div>
