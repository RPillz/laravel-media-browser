<div>
        
    <form wire:submit.prevent="mediaMultiUpload">

        <x-filepond
            wire:model="mediaUploads"
            ref="mediafilepond"
            multiple
            allowFileTypeValidation
            acceptedFileTypes="['image/png', 'image/jpg', 'image/jpeg']"
            allowFileSizeValidation
            maxFileSize="10mb"
            allowRemove="false"
            allowRevert="false"
            maxFiles=5
        />

        @error('mediaUploads')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

    </form>

</div>