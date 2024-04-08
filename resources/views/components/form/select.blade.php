<select 
  data-filter-type="state" 
  {{ $attributes->merge(['class' => 'w-full relative bg-olive bg-[url("../icons/chevron-down.svg")] bg-[length:15px_auto] font-sans-regular text-base lg:text-md xl:text-lg border-0 focus:ring-0 text-white appearance-none accent-serene']) }}>
  {{ $slot }}
</select>