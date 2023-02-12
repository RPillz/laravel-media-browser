<?php

namespace RPillz\LaravelMediaBrowser\Traits;

use RPillz\LaravelMediaBrowser\Models\MediaLibrary;

trait HasMediaLibraries {

    public function mediaLibraries()
    {
        return $this->morphMany(MediaLibrary::class, 'owner');
    }

    public function mediaLibrary()
    {
        return $this->morphOne(MediaLibrary::class, 'owner')->oldestOfMany();
    }

}
