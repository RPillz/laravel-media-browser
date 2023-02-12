<?php

namespace RPillz\LaravelMediaBrowser\Traits;

use Symfony\Component\Mime\MimeTypes;
use RPillz\LaravelMediaBrowser\Models\MediaAttachment;

trait HasMediaAttachments
{

    public function attachments()
    {
        return $this->morphMany(MediaAttachment::class, 'attachable');
    }

    public function getAttachment($type='primary'){
        if ($attachment = $this->attachments->where('type', $type)->first()){
            return $attachment;
        } else {
            return false;
        }
    }

    public function getAttachments($type='primary'){
        if ($attachments = $this->attachments->where('type', $type)->all()){
            return $attachments;
        } else {
            return [];
        }
    }

    public function getAttachmentMedia($type='primary'){
        if ($attachment = $this->attachments->where('type', $type)->first()){
            return $attachment->media;
        } else {
            return false;
        }
    }

    public function getAttachmentGallery($type='gallery'){
        if ($attachment = $this->attachments->where('type', $type)->all()){
            return $attachment;
        } else {
            return false;
        }
    }

    public function getAttachmentUrl($type='primary', $size='full'){

        if ($media = $this->getAttachmentMedia($type)){
            if ($media->hasGeneratedConversion($size)){
                return $media->getUrl($size);
            } else {
                return $media->getUrl();
            }
        }

    }

    public function getAttachmentCode($type='primary', $size='full', $attributes = null){

        if (!is_array($attributes) && !empty($attributes)){
            $attributes = [
                'class' => $attributes
            ];
        }

        if ($media = $this->getAttachmentMedia($type)){
            if ($media->hasGeneratedConversion($size)){
                return $media->img($size, $attributes);
            } else {
                return $media->img('', $attributes);
            }
        }

    }

    public function getAttachmentExtension($type='primary'){

        if ($media = $this->getAttachmentMedia($type)){
            return MimeTypes::getDefault()->getExtensions($media->mime_type)[0];
        }

    }

    public function removeAttachment($id){

        if ($attachment = $this->attachments->find($id)){
            $attachment->delete();
            return true;
        } else {
            return false;
        }

    }

    public function removeAllAttachments($type = 'primary'){

        if (!$attachments = $this->attachments->where('type', $type)->all()) return false;

        foreach($attachments as $attachment){
            $attachment->delete();
        }

        return true;

    }

    // shortcut for the primary image url
    public function imageUrl($size = 'full', bool $random = false){

        if($attached = $this->getAttachmentUrl('primary', $size)){
            return $attached;
        } else
        if ($random) {
            if ($size == 'large' || $size == 'cover') return 'https://picsum.photos/seed/'.$this->slug.'/1080/720';
            if ($size == 'thumbnail') return 'https://picsum.photos/seed/'.$this->slug.'/200/200';
            return 'https://picsum.photos/seed/'.$this->slug.'/540/360';
        } else {
            return null;
        }

    }


}
