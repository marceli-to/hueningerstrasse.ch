@props(['type' => 'submit'])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'bg-forest rounded-sm font-sans-bold font-bold flex text-white uppercase py-10 px-20 !leading-none hover:bg-olive transition-all']) }}>
  {{ $slot}}
</button>