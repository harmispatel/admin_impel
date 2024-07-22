<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartUser extends Model
{
    use HasFactory;
 
    protected $table = "cart_user";
    protected $guarded = [];

    public function designs()
    {
        return $this->hasOne(Design::class, 'id', 'design_id');
    }

}
