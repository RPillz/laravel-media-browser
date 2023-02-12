<div>

    <form wire:submit.prevent="mediaMultiUpload">

        <input type="file" wire:model="mediaUploads" multiple>
    
     
    
        @error('mediaUploads.*') <span class="error">{{ $message }}</span> @enderror
    
     
    
        <button type="submit">Save Media</button>
    
    </form>

</div>