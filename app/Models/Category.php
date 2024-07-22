<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];


    // Get SubCategories
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_category');
    }


    // Get Parent Category
    public function parentcategory()
    {
        return $this->belongsTo(Category::class, 'parent_category');
    }


}
