<?php

namespace RPillz\LaravelMediaBrowser\Models;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibrary extends Model implements HasMedia
{
    use HasUlids;
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $attributes = [
        'disk' => null,
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function getDiskAttribute()
    {
        if (!is_null($this->attributes['disk'])) return $this->attributes['disk'];
        return config('media-browser.storage-disk', 'public');
    }

    public function registerMediaCollections(): void
    {

        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'])
            ->useDisk($this->disk)
            ->registerMediaConversions(function (Media $media) {

                $this->addMediaConversion('large')
                    ->keepOriginalImageFormat()
                    ->fit(Manipulations::FIT_MAX, 1280, 1280);

                $this->addMediaConversion('medium')
                    ->keepOriginalImageFormat()
                    ->fit(Manipulations::FIT_MAX, 900, 900);

                $this->addMediaConversion('cover')
                    ->keepOriginalImageFormat()
                    ->fit(Manipulations::FIT_CROP, 1280, 720);

                $this->addMediaConversion('small')
                    ->keepOriginalImageFormat()
                    ->fit(Manipulations::FIT_MAX, 600, 600);

                $this->addMediaConversion('small-cover')
                    ->keepOriginalImageFormat()
                    ->fit(Manipulations::FIT_CROP, 320, 180);

                $this->addMediaConversion('thumbnail')
                    ->keepOriginalImageFormat()
                    ->fit(Manipulations::FIT_CROP, 200, 200);

            });

        $this->addMediaCollection('files')
            ->useDisk($this->disk);

    }

}
