@props([ 'modelVar', 'type' => 'primary', 'thumb' => null, 'label' => null, 'help' => null, 'collectionName' => null ])

@php

    if($label){
        $field_id = 'media_'.Str::of($label)->snake();
    } else {
        $field_id = 'media_'.rand(0,999999);
    }

@endphp

<div class="flex flex-col mb-4">

    @if($label)
        <label for="{{ $field_id }}">{{ $label }}</label>
    @endif

    <div class="flex flex-inline items-center gap-3">
        <div>
            @if($thumb)
                <img src="{{ $thumb }}" class="w-12 h-12 border" />
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
            @endif
        </div>
        @if($thumb)
            <x-button red wire:click="detachAllMedia('{{ $modelVar }}', '{{ $type }}')" label="Clear" />
        @endif
        <x-button blue wire:click="attachMedia('{{ $modelVar }}', '{{ $type }}', '{{ $collectionName }}')" label="Pick Media" />
    </div>

    {{-- @if($help)
        <x-text.help>{{ $help }}</x-text.help>
    @endif --}}

</div>
