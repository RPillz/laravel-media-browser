@props(['modelVar', 'type' => 'primary', 'thumbs' => [], 'label' => 'Attach Images', 'url' => null, 'collectionName' => 'images' ])

<div {{ $attributes->merge(['class' => 'border rounded overflow-hidden']) }}>

    @if($label)
        <div class="bg-gray-300 px-2 py-1">
            <span class="font-bold text-gray-500">{{ $label }}</span>
        </div>
    @endif

    <div class="relative">

        <div class="justify-center p-3 bg-gray-100 rounded">

            @forelse($thumbs as $thumb)
                <img class="mx-auto border w-100 shadow" src="{{ $thumb }}" />
            @empty
                <p class="text-gray-500 text-center">No Images</p>
            @endforelse

            <x-button blue wire:click="attachMedia('{{ $modelVar }}', '{{ $type }}', '{{ $collectionName }}')" label="Pick Image" />

        </div>


        {{-- @if($thumb)
            <div class="absolute bottom-5 right-5 flex gap-2">
                <x-button red wire:click="detachAllMedia('{{ $modelVar }}', '{{ $type }}')" label="Clear" />
                <x-button blue wire:click="attachMedia('{{ $modelVar }}', '{{ $type }}', '{{ $collectionName }}')" label="Replace" />
            </div>
        @endif --}}



        {{-- @if($choose)
            <div class="absolute top-0 left-0 w-full h-full bg-gray-200">
                <div class="px-5 py-8 text-center justify-center">

                    <form wire:submit.prevent="saveImage('{{ $collection }}')">

                        <div class="justify-center flex gap-2">

                            <div class="relative border-dotted h-10 rounded-lg border-dashed border-2 border-gray-400 bg-gray-100 flex justify-center items-center overflow-hidden">
                                <div class="absolute">
                                    <div class="flex items-center text-gray-400">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        @if($file)
                                            <span class="font-normal">{{ Str::limit($file->getClientOriginalName() , 30) }}</span>
                                        @else
                                            <span class="font-normal" wire:loading.remove>Choose File</span>
                                        @endif
                                        <div wire:loading wire:target="imageUploadFile">Wait...</div>
                                    </div>
                                </div>
                                <input type="file" wire:model="imageUploadFile" class="h-full w-full opacity-0">
                            </div>

                            <x-button.primary wire:click="saveImage('{{ $collection }}')" wire:loading.attr="disabled">
                                Save
                            </x-button.primary>

                            <x-button.secondary wire:click="$set('chooseUploadFile', false)" class="" wire:loading.attr="disabled">
                                Cancel
                            </x-button.secondary>

                        </div>


                    </form>

                    @error('imageUploadFile') <p class="text-red-700">{{ $message }}</p> @enderror

                </div>
            </div>
        @endif --}}

    </div>

</div>
