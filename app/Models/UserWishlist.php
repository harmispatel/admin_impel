<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWishlist extends Model
{
    use HasFactory;

    protected $table = "user_wishlist";
    protected $guarded = [];

    public function designs()
    {
        return $this->hasOne(Design::class, 'id', 'design_id');
    }


}
