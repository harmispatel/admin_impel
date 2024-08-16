<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartReady extends Model
{
    use HasFactory;

    protected $table = "cart_readies";

    protected $guarded = [];
}
