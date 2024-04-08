@props(['message'])
<span {{ $attributes->merge(['class' => 'absolute top-0 right-0 px-7 py-5 inline-block w-auto bg-red-500 text-white text-xs leading-none']) }}>
  {{ $message }}
</span> 