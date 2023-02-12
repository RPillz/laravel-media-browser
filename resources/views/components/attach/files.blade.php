@props([ 'modelVar', 'type' => 'primary', 'attachments' => [], 'label' => null, 'help' => null, 'collectionName' => 'files' ])

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

    @foreach($attachments as $attachment)
        <div class="flex justify-between gap-2 py-2">
            <span class="font-bold">{{ $attachment->media->name }}</span>
            <span class="text-gray-500">{{ $attachment->media->mime_type }}</span>
            <span class="text-gray-500">{{ $attachment->media->human_readable_size }}</span>
            <x-button xs red outline wire:click="detachMedia('{{ $modelVar }}', '{{ $attachment->id }}')" label="Detach" />
        </div>
    @endforeach

    <div class="flex flex-inline items-center gap-3">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
        </div>
        <x-button blue wire:click="attachMultipleMedia('{{ $modelVar }}', '{{ $type }}', '{{ $collectionName }}')" label="Attach File" />
    </div>

    {{-- @if($help)
        <x-text.help>{{ $help }}</x-text.help>
    @endif --}}

</div>
