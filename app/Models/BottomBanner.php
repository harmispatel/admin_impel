<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottomBanner extends Model
{
    use HasFactory;

    protected $guarded = [];

    function tag()
    {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }
}
