<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function designImages()
    {
        return $this->hasMany(Design_image::class);
    }

    public function categories()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function gender()
    {
        return $this->hasOne(Gender::class, 'id', 'gender_id');
    }

    public function metal()
    {
        return $this->hasOne(Metal::class, 'id', 'metal_id');
    }

    public function companies()
    {
        return $this->hasMany(User::class, 'id', 'company');
    }

    public function dealer_collections(){
        return $this->hasMany(DealerCollection::class, 'design_id', 'id');
    }

}
