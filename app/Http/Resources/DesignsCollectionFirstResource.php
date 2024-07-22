<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Tag, Dealer, User,Design};


class DesignsCollectionFirstResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $designscollections = (isset($this->resource)) ? $this->resource : [];
        
        $designcollections = Design::whereIn('id',$designscollections)->get();
        
        $notcollectiondesigns = Design::whereNotIn('id',$designscollections)->get();

        if (count($designcollections) > 0) {
            $design_arrays = [];
            foreach($designcollections as $design)
            {
    
                $tags = json_decode($design->tags);
                $tagname = Tag::whereIn('id',$tags)->pluck('name');
    
                $company = json_decode($design->company);
                if ($company)
                {
                    $companyname = User::whereIn('id',$company)->pluck('name');
                }
                $mul_images = $design->designImages;
                $images = [];
                if ($mul_images) {
                    foreach ($mul_images as $mul_image)
                    {
                        $imgs =  asset('public/images/uploads/item_image/'.$mul_image->image);
                        $images[] = $imgs;
                    }
                }
                $category_name = isset($design->categories) ? $design->categories->name : '';
                $gender_name = isset($design->gender) ? $design->gender->name : '';
                $metal_name = isset($design->metal) ? $design->metal->name : '';
                $data['id'] = $design->id;
                $data['name'] = $design->name;
                $data['category_id'] = $category_name;
                $data['gender_id'] = $gender_name;
                $data['metal_id'] = $metal_name;
                $data['companies'] = isset($company) ? $companyname : [];
                $data['tags'] = $tagname;
                $data['code'] = $design->code;
                $data['status'] = ($design->status == 1) ? 'Active' : 'Inactive';
                $data['is_flash'] = ($design->is_flash == 1) ? 'Yes' : 'No';
                $data['highest_selling'] = ($design->highest_selling == 1) ? 'Yes' : 'No';
                $data['price'] = isset($design->price) ? $design->price : '';
                $data['weight_14k'] = isset($design->weight1) ? $design->weight1 : '';
                $data['weight_18k'] = isset($design->weight2) ? $design->weight2 : '' ;
                $data['weight_20k'] = isset($design->weight3) ? $design->weight3 : '';
                $data['weight_22k'] = isset($design->weight4) ? $design->weight4 : '';
                $data['gross_weight_14k'] = isset($design->gweight1) ? $design->gweight1 : '';
                $data['gross_weight_18k'] = isset($design->gweight2) ? $design->gweight2 : '';
                $data['gross_weight_20k'] = isset($design->gweight3) ? $design->gweight3 : '';
                $data['gross_weight_22k'] = isset($design->gweight4) ? $design->gweight4 : '';
                $data['wastage_14k'] = isset($design->wastage1) ? $design->wastage1 : '';
                $data['wastage_18k'] = isset($design->wastage2) ? $design->wastage2 : '';
                $data['wastage_20k'] = isset($design->wastage3) ? $design->wastage3 : '';
                $data['wastage_22k'] = isset($design->wastage4) ? $design->wastage4 : '';
                $data['iaj_gross_weight'] = isset($design->iaj_weight) ? $design->iaj_weight : '';
                $data['multiple_image'] = isset($mul_images) ? $images : [] ;
                $designs_arrays[] = $data;
            }
            
        }
        
        
        $not_collection_array = [];
        foreach($notcollectiondesigns as $value)
        {

            $not_collection_tags = json_decode($value->tags);
            $not_collection_tagname = Tag::whereIn('id',$not_collection_tags)->pluck('name');

            $companys = json_decode($value->company);
            if ($companys)
            {
                $companysname = User::whereIn('id',$companys)->pluck('name');
            }
            $not_collection_mul_images = $value->designImages;
            $not_collection_images = [];
            if ($not_collection_mul_images) {
                foreach ($not_collection_mul_images as $not_collection_mul_image)
                {
                    $images =  asset('public/images/uploads/item_image/'.$not_collection_mul_image->image);
                    $not_collection_images[] = $images;
                }
            }
            $not_collection_category_name = isset($value->categories) ? $value->categories->name : '';
            $not_collection_gender_name = isset($value->gender) ? $value->gender->name : '';
            $not_collection_metal_name = isset($value->metal) ? $value->metal->name : '';
            $datas['id'] = $value->id;
            $datas['name'] = $value->name;
            $datas['category_id'] = $not_collection_category_name;
            $datas['gender_id'] = $not_collection_gender_name;
            $datas['metal_id'] = $not_collection_metal_name;
            $datas['companies'] = isset($companys) ? $companysname : [];
            $datas['tags'] = $not_collection_tagname;
            $datas['code'] = $value->code;
            $datas['status'] = ($value->status == 1) ? 'Active' : 'Inactive';
            $datas['is_flash'] = ($value->is_flash == 1) ? 'Yes' : 'No';
            $datas['highest_selling'] = ($value->highest_selling == 1) ? 'Yes' : 'No';
            $datas['price'] = isset($value->price) ? $value->price : '';
            $datas['weight_14k'] = isset($value->weight1) ? $value->weight1 : '';
            $datas['weight_18k'] = isset($value->weight2) ? $value->weight2 : '' ;
            $datas['weight_20k'] = isset($value->weight3) ? $value->weight3 : '';
            $datas['weight_22k'] = isset($value->weight4) ? $value->weight4 : '';
            $datas['gross_weight_14k'] = isset($value->gweight1) ? $value->gweight1 : '';
            $datas['gross_weight_18k'] = isset($value->gweight2) ? $value->gweight2 : '';
            $datas['gross_weight_20k'] = isset($value->gweight3) ? $value->gweight3 : '';
            $datas['gross_weight_22k'] = isset($value->gweight4) ? $value->gweight4 : '';
            $datas['wastage_14k'] = isset($value->wastage1) ? $value->wastage1 : '';
            $datas['wastage_18k'] = isset($value->wastage2) ? $value->wastage2 : '';
            $datas['wastage_20k'] = isset($value->wastage3) ? $value->wastage3 : '';
            $datas['wastage_22k'] = isset($value->wastage4) ? $value->wastage4 : '';
            $datas['iaj_gross_weight'] = isset($value->iaj_weight) ? $value->iaj_weight : '';
            $datas['multiple_image'] = isset($not_collection_mul_images) ? $not_collection_images : [] ;
            $not_collection_array[] = $datas;
        }

        if (count($designcollections) > 0) {
            
            $design_array = array_merge($designs_arrays,$not_collection_array);
        }else{
            $design_array = $not_collection_array;
        }
            
        

        return $design_array;
    }
}
