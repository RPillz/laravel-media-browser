@if ($mediaModel)

    <div class="grid grid-cols-3 gap-2">

        <div class="col-span-2">

            {{-- <p class="text-lg font-semibold mb-3">Browse {{ $mediaModel->name ?: 'Media Library' }}</p> --}}

            {{-- @dump($mediaModel->getMedia('media')) --}}

            <div>
                @if ($mediaCollection->count() > 0)
                    <div class="flex flex-wrap gap-2 max-h-3/4 overflow-y-auto">

                        @foreach ($mediaCollection->forPage($this->mediaPage, $this->mediaPerPage) as $media)
                            <div class="group border" wire:click="selectMedia('{{ $media->uuid }}')">
                                @if($media->hasGeneratedConversion('thumbnail'))
                                    <img src="{{ $media->getUrl('thumbnail') }}" alt="{{ $media->name }}" />
                                @else
                                <div class="text-sm flex flex-col p-5 text-center">
                                    <span class="font-bold">{{ $media->name }}</span>
                                    <span>[{{ $media->mime_type }}]</span>
                                </div>
                                @endif
                            </div>
                        @endforeach

                    </div>

                    <div class="flex justify-between mt-3">
                        <x-button.circle icon="chevron-left" wire:click="mediaPreviousPage" title="Previous Page"
                            :disabled="$this->mediaPage <= 1" />
                        <x-button.circle icon="chevron-right" wire:click="mediaNextPage" title="Next Page"
                            :disabled="$this->mediaPage > $this->mediaCollection->count() / $this->mediaPerPage" />
                    </div>
                @else
                    <p class="p-5 text-gray-300 text-center">No Media Uploaded</p>

                @endif
            </div>

            {{-- <div>
            @forelse($mediaUploads as $upload)
                @dump($upload)
            @empty
                No uploads
            @endforelse
        </div> --}}

        </div>

        <div class="">

            <div>
                @if ($mediaSelected)

                    <p class="text-lg font-semibold mb-3">Selected Media</p>

                    <div class="bg-gray-100 rounded p-3">
                        @if($mediaSelected->hasGeneratedConversion('thumbnail'))
                                <img src="{{ $mediaSelected->getUrl('thumbnail') }}" class="mx-auto max-h-40" alt="{{ $mediaSelected->name }}" />
                            @else
                                <div class="text-sm flex flex-col p-5 text-center">
                                    <span class="font-bold">{{ $mediaSelected->name }}</span>
                                    <span>[{{ $mediaSelected->mime_type }}]</span>
                                </div>
                            @endif
                    </div>

                    <p class="text-center text-sm my-2">{{ $mediaSelected->name }}</p>

                    @if($mediaAttachmentModel)

                        <div>
                            @if ($mediaAttachmentType)
                                <p class="my-2">Will be attached as {{ $mediaAttachmentType }} media.</p>
                            @endif
                        </div>

                        <div class="flex justify-between">
                            <x-button flat wire:click="cancelSelectedMedia" label="Cancel" />
                            <x-button blue wire:click="confirmMedia" label="Select" />
                        </div>

                    @else

                        @if($mediaSelectedAttachments)
                            <p class="text-center text-sm my-2">{{ $mediaSelectedAttachments->count() }} Attachments</p>
                        @endif

                        <div class="flex justify-between">
                            <x-button flat wire:click="cancelSelectedMedia" label="Cancel" />
                            <x-button red outline wire:click="deleteSelectedMedia" label="Delete" />
                            <x-button blue wire:click="replaceMedia" label="Replace" />
                        </div>

                        <div>
                            <input type="file" wire:model="mediaReplacementUpload" />
                            @error('mediaUploads') <span class="error">{{ $message }}</span> @enderror
                        </div>

                    @endif

                @endif
            </div>

            <div style="display: @if (!$mediaSelected) block @else none @endif;">

                <p class="text-lg font-semibold mb-3">Upload Media</P>

                {{-- @include('media-browser::filepond') --}}

                {{-- @include('media-browser::library-upload') --}}
                {{-- Not sure how to set Uppy Uploader for livewire --}}

                @include('media-browser::upload')

            </div>

        </div>

    </div>
@else
    <p>No Media Model is set.</p>

@endif
