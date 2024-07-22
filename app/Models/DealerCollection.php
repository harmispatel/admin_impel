<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerCollection extends Model
{
    use HasFactory;

    protected $table = "dealer_collection";
    protected $guarded = [];

    public function designs()
    {
        return $this->hasOne(Design::class, 'id', 'design_id');
    }

    public function dealer()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
