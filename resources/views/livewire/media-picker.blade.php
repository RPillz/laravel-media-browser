<div class="space-y-4">

    @include('media-browser::picker.list')

    @if(!$multiple && $mediaAttachments->count() > 0)
        <x-button amber outline label="Replace {{ ucfirst($type) ?: 'Media' }}" wire:click="addMedia" />
    @else
        <x-button green outline label="Add {{ ucfirst($type) ?: 'Media' }}" wire:click="addMedia" />
    @endif

    @include('media-browser::picker.modal')

</div>
