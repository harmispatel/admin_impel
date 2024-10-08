<?php



namespace App\Models;



use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use Laravel\Passport\HasApiTokens;



class User extends Authenticatable

{

    use HasApiTokens, HasFactory, Notifiable;



    /**

     * The attributes that are mass assignable.

     *

     * @var array<int, string>

     */

    protected $guarded = [];





    /**

     * The attributes that should be hidden for serialization.

     *

     * @var array<int, string>

     */

    protected $hidden = [

        'password',

        'remember_token',

    ];



    /**

     * The attributes that should be cast.

     *

     * @var array<string, string>

     */

    protected $casts = [

        'email_verified_at' => 'datetime',

    ];





    public function document()

    {

        return $this->hasMany(UserDocument::class);

    }



    public function company_city()

    {

        return $this->hasOne(City::class,'id','city')->select('id','name');

    }



    public function shippingCity()

    {

        return $this->hasOne(City::class,'id','shipping_city')->select('id','name');

    }



    public function company_state()

    {

        return $this->hasOne(State::class,'id','state')->select('id','name');

    }



    public function shippingState()

    {

        return $this->hasOne(State::class,'id','shipping_state')->select('id','name');

    }



    public function orders()
    {
        return $this->hasMany(Order::class, 'dealer_id', 'id');
    }


    public function readyOrders()
    {
        return $this->hasMany(ReadyOrder::class, 'dealer_id', 'id');
    }
}

