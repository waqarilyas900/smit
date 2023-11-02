<?php

namespace App\Models;
use App\Models\Option;

class Addon extends Model
{
    public $translatable = ['name'];
    protected $appends = ['options'];
    public function getOptionsAttribute()
    {
        return Option::where('addon_id', $this->id)->get();
    }
    public function option(){
        return $this->hasMany(Option::class);
    }
}
