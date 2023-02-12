@props(['modelVar', 'type' => 'primary', 'thumb' => null, 'label' => 'Attach Image', 'url' => null, 'collectionName' => 'images' ])

<div {{ $attributes->merge(['class' => 'border rounded overflow-hidden']) }}>

    @if($label)
        <div class="bg-gray-300 px-2 py-1">
            <span class="font-bold text-gray-500">{{ $label }}</span>
        </div>
    @endif

    <div class="relative">

        <div class="justify-center p-3 bg-gray-100 rounded">

            @if($thumb)
                <img class="mx-auto border w-100 shadow" src="{{ $thumb }}" />
            @else

                {{-- <button wire:click="$set('chooseUploadFile','true')" class="flex mx-auto my-10 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-8 h-8 mr-2 flex-inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="flex-inline">Add Image</span>
                </button> --}}

                <x-button blue wire:click="attachMedia('{{ $modelVar }}', '{{ $type }}', '{{ $collectionName }}')" label="Pick Image" />

            @endif

        </div>


        @if($thumb)
            <div class="absolute bottom-5 right-5 flex gap-2">
                {{-- <x-button.secondary class="text-red-800" wire:click="deleteImage('{{ $collection }}')" wire:loading.attr="disabled">
                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Delete
                </x-button.secondary> --}}
                <x-button red wire:click="detachAllMedia('{{ $modelVar }}', '{{ $type }}')" label="Clear" />
                <x-button blue wire:click="attachMedia('{{ $modelVar }}', '{{ $type }}', '{{ $collectionName }}')" label="Replace" />
            </div>
        @endif



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
