<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        $categories = isset($this->resource) ? $this->resource : [];
        $categories_array = [];

        if(count($categories) > 0)
        {
            foreach ($categories as $category)
            {
                $child_categories = $category->subcategories;

                $data['id'] = $category->id;
                $data['name'] = $category->name;
                $data['parent_category'] = $category->parent_category;
                $data['status'] = $category->status;
                $data['image'] = (isset($category->image) && !empty($category->image)) ? asset('public/images/uploads/category_images/'.$category->image) : asset('public/images/uploads/category_images/no_image.jpg');

                if(count($child_categories) > 0)
                {
                    $child_cat = [];
                    foreach($child_categories as $child_category)
                    {
                        $datas = [];
                        $datas['id'] = $child_category->id;
                        $datas['name'] = $child_category->name;
                        $child_cat[] = $datas;
                    }
                    $data['child_categories'] = $child_cat;
                }

                $categories_array[] = $data;
            }
        }
        return $categories_array;
    }
}
