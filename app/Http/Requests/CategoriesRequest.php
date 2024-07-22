<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\{
    Category
};


class CategoriesRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }


    // Get the validation rules that apply to the request.
    public function rules()
    {

        $categories = Category::get();
        foreach($categories as $category){
            $parent_cats[] = $category->parent_category;
        }

        if($this->id){
            if ($this->parent_category == 0) {
                $rules = [
                    'name' => 'required|unique:categories,name,'.$this->id,
                    'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                ];
            }else{
                if(in_array($this->parent_category,$parent_cats)){
                    $category_id = $this->id;
                    $request = $this;
                    $rules = [
                        'name' => [
                            'required',
                            Rule::unique('categories')->where(function ($query) use ($request, $category_id) {
                                return $query->where('parent_category', $request->parent_category)
                                    ->where('id', '<>', $category_id);
                            }),
                        ],
                        'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                    ];
                }else{
                    $rules = [

                        'name' => 'required',
                        'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                    ];
                }
            }
        }
        else
        {
            if($this->parent_category == null)
            {
                $rules = [
                    'category_id' => 'unique:categories,id',
                    'name' => 'required|unique:categories,name',
                    'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                ];

            }else{
                if (in_array($this->parent_category,$parent_cats)) {
                    $rules = [
                        'category_id' => 'unique:categories,id',
                        'name' => 'required|unique:categories,name',
                        'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                    ];
                }else{
                    $rules = [
                        'category_id' => 'unique:categories,id',
                        'name' => 'required',
                        'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                    ];
                }

            }
        }

        return $rules;
    }
}
