<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDealerReport extends Model
{
    use HasFactory;

    protected $table = "order_dealer_report";
    protected $guarded = [];

    public function designs()
    {
        return $this->hasOne(Design::class, 'id', 'design_id');
    }
}
