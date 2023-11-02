<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class AboutFaq extends Model
{
    use HasTranslations;
    public $translatable = ['title', 'value'];
}