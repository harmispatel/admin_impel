<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadyOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order_items()
    {
        return $this->hasMany(ReadyOrderItem::class, 'order_id', 'id');
    }

    public function City()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

    public function State()
    {
        return $this->hasOne(State::class, 'id', 'state');
    }

    public function dealer()
    {
        return $this->hasOne(User::class, 'id', 'dealer_id');
    }
}
