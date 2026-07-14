@props(['options' => []])

<div class="grid grid-cols-1 gap-16 sm:grid-cols-2 lg:grid-cols-4 lg:gap-20 lg:items-end">

  <x-forms.select
    id="availability"
    label="Verfügbarkeit"
    class="js-filter-attribute"
    data-filterType="object-state"
    :options="$options['availability'] ?? []" />

  <x-forms.select
    id="rooms"
    label="Zimmer"
    class="js-filter-attribute"
    data-filterType="object-rooms"
    :options="$options['rooms'] ?? []" />

  <x-forms.select
    id="floor"
    label="Etage"
    class="js-filter-attribute"
    data-filterType="object-floor"
    :options="$options['floors'] ?? []" />

  <button
    type="button"
    class="js-btn-reset w-full bg-sky/60 hover:bg-sky text-ink border border-ink/15 px-16 py-12 text-sm md:text-lg text-left transition-colors cursor-pointer">
    Filter zurücksetzen
  </button>

</div>
