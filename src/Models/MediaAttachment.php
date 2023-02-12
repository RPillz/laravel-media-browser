<?php

namespace RPillz\LaravelMediaBrowser\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaAttachment extends Model implements Sortable
{
    use HasUlids;
    use HasFactory;
    use SortableTrait;

    protected $guarded = ['id', 'deleted_at', 'created_at', 'updated_at'];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function buildSortQuery()
    {
        return static::query()->where('attachable_type', $this->attachable_type)->where('attachable_id', $this->attachable_id)->where('type', $this->type);
    }
}
