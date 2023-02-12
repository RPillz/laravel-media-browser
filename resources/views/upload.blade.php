
<div>

    <form wire:submit.prevent="mediaSingleUpload">

        <div>
            <input type="file" wire:model="mediaUploads" >
        </div>

        <div>
            @error('mediaUploads') <span class="error">{{ $message }}</span> @enderror
        </div>

        {{-- <div>
            <x-button type="submit" label="Save Media" />
        </div> --}}

    </form>

</div>
