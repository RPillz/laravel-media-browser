<?php

namespace RPillz\LaravelMediaBrowser\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RPillz\LaravelMediaBrowser\Models\MediaLibrary;
use RPillz\LaravelVideoLibrary\Models\VideoLibrary;
use RPillz\LaravelMediaBrowser\Models\MediaAttachment;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaPicker extends Component
{

    use Actions;
    use WithPagination;
    use WithFileUploads;

    public $model = null;
    public $type = 'primary';
    public $multiple = true;
    public $readOnly = false;

    public $mediaAttachments;
    public $mediaUploads;
    public $uploadedMedia;

    public $mediaCollection = null;
    public $mediaCollectionName = 'images';

    public $mediaAttachmentType = null;
    public $mediaAttachmentModel = null;
    public $mediaAttachmentSingle = true;

    // public $mediaSelected = null;
    // public $mediaSelectedAttachments = null;

    public $mediaLibraryDisplay = false;
    public $mediaLibrary;

    public $mediaPage = 1;
    public $mediaPerPage = 15;

    protected $rules = [
        'mediaUploads' => '',
    ];

    public function mount($library = null, $collection = null)
    {
        $this->setMediaLibrary($library);
        $this->mediaAttachments = $this->model->getAttachments($this->type);
        $this->refreshMediaCollection($collection);

    }

    public function render()
    {
        return view('media-browser::livewire.media-picker');
    }

    public function addMedia()
    {
        $this->mediaLibraryDisplay = true;
    }

    public function attachMedia($uuid){

        // $media = $this->mediaCollection->firstWhere('uuid', $uuid);
        // $media = $this->mediaLibrary->getMedia($this->mediaCollectionName)->where('uuid', $uuid)->first();
        $media = Media::where('uuid', $uuid)->first();

        Log::debug('Media Attach', ['uuid' => $uuid, 'collection' => $this->mediaCollectionName, 'media' => $media] );

        if(!$media) return false;

        if ($this->multiple){

            $this->model->attachments()->create([
                'type' => $this->type,
                'media_id' => $media->id,
            ]);

        } else {

            $this->model->attachments()->updateOrCreate([
                'type' => $this->type,
            ],[
                'media_id' => $media->id,
            ]);

        }

        $this->mediaLibraryDisplay = false;

        $this->mediaAttachments = $this->model->getAttachments($this->type);

    }

    public function removeAttachment($uuid){

        $this->model->removeAttachment($uuid);

        $this->mediaAttachments = $this->model->getAttachments($this->type);

    }

    public function refreshMediaCollection(string $collection = null){

        if ($collection) $this->mediaCollectionName = $collection;
        $this->mediaCollection = null;
        $this->mediaCollection = $this->mediaLibrary->getMedia($this->mediaCollectionName)->sortDesc();

    }

    private function setMediaLibrary(MediaLibrary $library = null)
    {
        if (! $library) {
            $library = MediaLibrary::oldest()->first();
        }

        $this->mediaLibrary = $library;
    }

    public function mediaNextPage(){
        if ($this->mediaPage <= ($this->mediaCollection->count() / $this->mediaPerPage) ){
            $this->mediaPage++;
        }
    }

    public function mediaPreviousPage(){
        if ($this->mediaPage > 1){
            $this->mediaPage--;
        }
    }

    public function mediaGoToPage(int $page){
        $this->mediaPage = $page;
    }

    public function updatedMediaUploads($upload){

        if (is_null($upload)) return false;

        $this->validate([
            'mediaUploads.*' => 'file', // 1GB Max
        ]);

        $saved = $upload->store($this->mediaCollectionName, $this->mediaLibrary->disk);

        Log::debug('Media Saved To Disk', ['path' => $saved]);

        $filename = $upload->getClientOriginalName();

        $this->uploadedMedia = $this->mediaLibrary->addMediaFromDisk(Storage::disk($this->mediaLibrary->disk)->path($saved), $this->mediaLibrary->disk)->usingName($filename)->toMediaCollection($this->mediaCollectionName);

        $this->refreshMediaCollection();

        Log::debug('Media Saved To Library', ['media' => $this->uploadedMedia]);

        if ($this->uploadedMedia) $this->attachMedia($this->uploadedMedia->uuid);

        return true;

    }

}
