@if ($model)

    @if ($mediaCollection->count() > 0)
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">

            @foreach ($mediaCollection->forPage($this->mediaPage, $this->mediaPerPage) as $media)
                <div class="group border" wire:click="attachMedia('{{ $media->uuid }}')">
                    @if($media->hasGeneratedConversion('thumbnail'))
                        <img src="{{ $media->getUrl('thumbnail') }}" alt="{{ $media->name }}" />
                    @else
                        <div class="text-sm flex flex-col p-5 text-center">
                            <span class="mx-auto w-10 h-10 fiv-sqo fiv-icon-{{ \Symfony\Component\Mime\MimeTypes::getDefault()->getExtensions($media->mime_type)[0] ?: 'blank' }}"></span>
                            <span class="font-bold break-words">{{ $media->name }}</span>
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

        <p class="col-span-5 p-5 text-gray-300 text-center">No {{ ucfirst($mediaCollectionName) ?: 'Media' }} Uploaded</p>

    @endif

    @if(!$readOnly)
        <div class="mt-6 bg=gray-50 rounded p-4">
            @include('media-browser::upload')
        </div>
    @endif


@else

    <p>No Media Model is set.</p>

@endif
