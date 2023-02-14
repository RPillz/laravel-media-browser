<?php

namespace RPillz\LaravelMediaBrowser\Traits\Livewire;


use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RPillz\LaravelMediaBrowser\Models\MediaLibrary;
use RPillz\LaravelMediaBrowser\Models\MediaAttachment;

trait HasMediaBrowser
{

    use WithPagination;
    use WithFileUploads;

    public $mediaModel;

    public $mediaUploads;
    public $mediaReplacementUpload;

    public $mediaLibraryDisplay = false;

    public $mediaCollection = null;
    public $mediaCollectionName = 'images';

    public $mediaAttachmentType = null;
    public $mediaAttachmentModel = null;
    public $mediaAttachmentSingle = true;

    public $mediaSelected = null;
    public $mediaSelectedAttachments = null;

    public $mediaPage = 1;
    public $mediaPerPage = 3;

    protected $mediaBrowserRules = [
        'media' => '',
    ];

    public function setMediaModel($model, $collection = null){
        $this->mediaModel = $model;
        $this->refreshMediaCollection($collection);
    }

    public function refreshMediaCollection(string $collection = null){

        if ($collection) $this->mediaCollectionName = $collection;
        $this->mediaCollection = $this->mediaModel->getMedia($this->mediaCollectionName)->sortDesc();
    }

    public function openMediaLibrary(string $collection = null){

        $this->refreshMediaCollection($collection);

        $this->mediaPage = 1;

        $this->mediaSelected = null;

        $this->mediaLibraryDisplay = true;

    }

    public function closeMediaLibrary(){

        $this->mediaAttachment = null;
        $this->mediaLibraryDisplay = false;

    }

    public function updatedMediaUploads($upload){

        if (is_null($upload)) return false;

        $this->validate([

            'mediaUploads.*' => 'image|max:1024', // 1MB Max

        ]);

        $saved = $upload->store($this->mediaCollectionName, config('media-browser.image-disk'));

        Log::debug('Image Saved To Disk', ['path' => $saved]);

        $filename = $upload->getClientOriginalName();

        // if (config('tenancy.filesystem.suffix_base'))
        // {
        //     $saved = config('tenancy.filesystem.suffix_base').tenant()->id.'/app/'.$saved;
        // }

        // dd($saved);

        // $newmedia = $this->mediaModel->addMedia($upload->getRealPath())->usingName($filename)->toMediaCollection('media');
        // $this->mediaSelected = $this->mediaModel->addMedia(Storage::disk(config('media-browser.image-disk'))->path($saved))->usingName($filename)->toMediaCollection($this->mediaCollectionName);
        $this->mediaSelected = $this->mediaModel->addMediaFromDisk(Storage::disk(config('media-browser.image-disk'))->path($saved), config('media-browser.image-disk'))->usingName($filename)->toMediaCollection($this->mediaCollectionName);

        // dd($this->mediaSelected);

        // $this->mediaSelected = $newmedia;

        // $this->refreshMediaCollection();

        return true;

    }

    public function updatedMediaReplacementUpload($upload){

        if (is_null($upload)) return false;

        $this->validate([

            'mediaReplacementUpload.*' => 'image|max:1024', // 1MB Max

        ]);

        $saved = $upload->store($this->mediaCollectionName, config('media-browser.image-disk'));

        $filename = $upload->getClientOriginalName();

        $newMedia = $this->mediaModel->addMedia(Storage::disk(config('media-browser.image-disk'))->path($saved))->usingName($filename)->toMediaCollection($this->mediaCollectionName);

        // replace attachments

        MediaAttachment::where('media_id', $this->mediaSelected->id)->update(['media_id' => $newMedia->id]);

        // delete old media

        $this->mediaSelected->delete();

        $this->mediaSelected = $newMedia;

        $this->refreshMediaCollection();

        return true;

    }

    public function attachMedia(string $modelName, string $type='primary', string $collection = null, bool $single = true){

        if ($this->{$modelName}){

            $this->mediaAttachmentModel = $modelName;
            $this->mediaAttachmentType = $type;
            $this->mediaAttachmentSingle = $single;

            $this->openMediaLibrary($collection);

        } else {

            // cannot attach media

        }

    }

    public function attachMultipleMedia(string $modelName, string $type='primary', string $collection = null){

        $this->attachMedia($modelName, $type, $collection, false);

    }

    public function detachMedia(string $modelName, $attachmentId)
    {

            if ($this->{$modelName}){

                $this->{$modelName}->attachments()->where('id', $attachmentId)->delete();

                $this->{$modelName}->refresh();

            } else {

                // cannot detach media

            }
    }


    public function detachAllMedia(string $modelName, string $type='primary', string $collection = null){

        if ($this->{$modelName}){

            $this->{$modelName}->removeAllAttachments($type);

            $this->{$modelName}->refresh();

        } else {

            // cannot detach media

        }

    }


    public function selectMedia($uuid){

        $media = $this->mediaCollection->firstWhere('uuid', $uuid);

        if(!$media) return false;

        $this->mediaSelectedAttachments = MediaAttachment::where('media_id', $media->id)->get();

        $this->mediaSelected = $media;

    }

    public function confirmMedia(){

        if ($this->mediaSelected){

            if ($this->mediaAttachmentType && $this->mediaAttachmentModel){

                if ($this->mediaAttachmentSingle){

                    $this->{$this->mediaAttachmentModel}->attachments()->updateOrCreate([
                        'type' => $this->mediaAttachmentType,
                    ],[
                        'media_id' => $this->mediaSelected->id,
                    ]);

                } else {

                    $this->{$this->mediaAttachmentModel}->attachments()->create([
                        'type' => $this->mediaAttachmentType,
                        'media_id' => $this->mediaSelected->id,
                    ]);

                }

                $this->{$this->mediaAttachmentModel}->refresh();

            }

            $this->closeMediaLibrary();

        }

    }

    public function cancelSelectedMedia(){

        $this->refreshMediaCollection();
        $this->mediaSelected = null;

    }

    public function deleteSelectedMedia($confirmed = false)
    {

        if (!$confirmed){
            $this->dialog()->confirm([
                'title'       => 'Delete Media?',
                'description' => 'Remove media with <strong>'.$this->mediaSelectedAttachments->count().' attachments</strong>?',
                'acceptLabel' => 'Yes, remove it',
                'icon'        => 'warning',
                'method'      => 'deleteSelectedMedia',
                'params'    => [1]
            ]);
            return;
        }

        MediaAttachment::where('media_id', $this->mediaSelected->id)->delete();

        $this->mediaSelected->delete();

        $this->notification()->info('Media deleted');

        $this->refreshMediaCollection();

    }

    public function replaceMedia(){



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


}
