
<x-modal.card title="{{ ucfirst($mediaCollectionName) ?: 'Media' }} Browser" blur max-width="5xl" z-index="z-40" wire:model.defer="mediaLibraryDisplay">
    @include('media-browser::picker.browser')
</x-modal.card>
