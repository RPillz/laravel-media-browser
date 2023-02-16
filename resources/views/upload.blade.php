
<div>

    <form wire:submit.prevent="mediaSingleUpload">

        {{-- <div>
            <input type="file" wire:model="mediaUploads" >
        </div> --}}

        <div wire:loading wire:target="mediaUploads">Uploading...</div>

        <div
            x-data="{ isUploading: false, progress: 0 }"
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
        >

            <!-- File Input -->
            <input type="file" wire:model="mediaUploads" >

            <!-- Progress Bar -->
            <div x-show="isUploading">
                <progress max="100" x-bind:value="progress"></progress>
            </div>

        </div>

        <div>
            @error('mediaUploads') <span class="error">{{ $message }}</span> @enderror
        </div>

        {{-- <div>
            <x-button type="submit" label="Save Media" />
        </div> --}}

    </form>

</div>
