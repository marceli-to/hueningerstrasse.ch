@props(['route', 'title' => '', 'image', 'hash' => ''])
<figure class="relative">
  <a 
    @if ($hash)
      href="{{ route($route) . $hash }}"
    @else
      href="{{ route($route) }}" 
    @endif
    title="{{ str_replace('<br>', ' ', $title) }}">
    <img 
    src="/media/img/{{ $image }}.jpg" 
    height="350" 
    width="350" 
    alt="{{ $title }}"
    class="block aspect-square w-full object-cover">
    <figcaption class="group absolute w-full h-full z-20 top-0 left-0 bg-serene bg-opacity-60 hover:bg-black hover:bg-opacity-10 touch-auto transition-all flex justify-center items-center">
      <h3 class="font-sans-bold font-bold font-normal text-center text-md sm:text-xl lg:text-3xl leading-5 sm:leading-6 lg:leading-9 xl:leading-9 text-olive opacity-100 group-hover:text-white transition-colors">
        {!! $title !!}
      </h3>
    </figcaption>
  </a>
</figure>