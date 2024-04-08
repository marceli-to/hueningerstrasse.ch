@props(['type' => 'text', 'placeholder' => '', 'name', 'isWire' => false])
@if ($isWire)
  <textarea 
    wire:model="{{ $name }}" 
    placeholder="{{ $placeholder }}" 
    class="text-base lg:text-md xl:text-lg w-full min-h-[150px] ring-0 focus:ring-0 border-none bg-white text-olive placeholder:text-serene"></textarea>
@else
  <textarea 
    name="{{ $name }}" 
    placeholder="{{ $placeholder }}" 
    class="text-base lg:text-md xl:text-lg w-full ring-0 focus:ring-0 border-none bg-serene text-white placeholder:text-white"></textarea>
@endif