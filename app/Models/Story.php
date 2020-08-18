<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany(StoryComment::class);
    }
}
