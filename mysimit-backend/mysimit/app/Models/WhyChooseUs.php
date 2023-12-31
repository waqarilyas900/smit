<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class WhyChooseUs extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['primaryMedia', 'primaryMediaUrl'];
    public $translatable = ['title', 'description'];
    /**
     * Register the media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('primary')
            ->singleFile();
    }

    /**
     * Get the primary media
     */
    public function getPrimaryMediaAttribute()
    {
        return $this->getFirstMedia('primary') ?? null;
    }

    /**
     * Get the primary media url
     */
    public function getPrimaryMediaUrlAttribute()
    {
        return $this->getFirstMediaUrl('primary') ?? null;
    }
}