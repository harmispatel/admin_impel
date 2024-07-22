<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadyOrderItem extends Model
{
    use HasFactory;

    public function design()
    {
        return $this->hasOne(Design::class, 'id', 'design_id');
    }
}
