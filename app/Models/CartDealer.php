<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class CartDealer extends Model

{

    use HasFactory;



    protected $table = "cart_dealer";

    protected $guarded = [];



    public function designs()

    {

        return $this->hasOne(Design::class, 'id', 'design_id');

    }

}

