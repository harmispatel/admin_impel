<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function dealer()
    {
        return $this->hasOne(User::class, 'id', 'dealer_id');
    }

    public function order_items()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }

    public function City()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

    public function State()
    {
        return $this->hasOne(State::class, 'id', 'state');
    }
}
