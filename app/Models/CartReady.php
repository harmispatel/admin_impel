<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartReady extends Model
{
    use HasFactory;

    protected $table = "cart_readies";

    protected $fillable = [
        'user_id',
        'tag_no',
        'group_name',
        'name',
        'quantity',
        'price',
        'size',
        'gross_weight',
        'net_weight',
        'gold_price',
        'design_id',
        'barcode',
        'gold_id'
    ];



    public function designs()
    {
        return $this->hasOne(Design::class, 'id', 'design_id');
    }
}
