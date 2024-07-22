<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Tag, Dealer, Design, User};
use Illuminate\Support\Collection;

class DesignsResource extends JsonResource
{
    protected $subcategories;
    protected $total_records;

    public function __construct($resource, $subcategories = null, $total_records = 0)
    {
        parent::__construct($resource);
        $this->subcategories = $subcategories;
        $this->total_records = $total_records;
    }


    public function toArray($request)
    {
        $all_details = [];
        $designs_array = [];
        $designs = (isset($this->resource)) ? $this->resource : [];
        $admin_settings = getAdminSettings();
        $gold_price_24k_1gm_mbo = (isset($admin_settings['gold_price_24k_1gm_mbo']) && !empty($admin_settings['gold_price_24k_1gm_mbo'])) ? $admin_settings['gold_price_24k_1gm_mbo'] : 0;
        $sales_wastage = (isset($admin_settings['sales_wastage']) && !empty($admin_settings['sales_wastage'])) ? unserialize($admin_settings['sales_wastage']) : [];
        $sales_wastage_discount = (isset($admin_settings['sales_wastage_discount']) && !empty($admin_settings['sales_wastage_discount'])) ? unserialize($admin_settings['sales_wastage_discount']) : [];

        foreach($designs as $design){
            $tags = json_decode($design->tags);
            $tagname = Tag::whereIn('id',$tags)->pluck('name');
            $company = json_decode($design->company);

            if ($company){
                $companyname = User::whereIn('id',$company)->pluck('name');
            }

            $mul_images = $design->designImages;
            $images = [];

            if ($mul_images) {
                foreach ($mul_images as $mul_image){
                    $imgs =  asset('public/images/uploads/item_images/'.$design->code.'/'.$mul_image->image);
                    $images[] = $imgs;
                }
            }

            $image = (isset($design->image) && !empty($design->image) && file_exists('public/images/uploads/item_images/'.$design->code.'/'.$design->image)) ? asset('public/images/uploads/item_images/'.$design->code.'/'.$design->image) : asset('public/images/default_images/not-found/no_img1.jpg');

            $category_name = isset($design->categories) ? $design->categories->name : '';
            $category_id = isset($design->categories) ? $design->categories->id : '';
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
            $data['percentage'] = isset($design->percentage) ? $design->percentage : '';
            $data['iaj_gross_weight'] = isset($design->iaj_weight) ? $design->iaj_weight : '';
            $data['image'] = $image;
            $data['multiple_image'] = isset($mul_images) ? $images : [] ;
            $data['gemstone_price'] = isset($design->gemstone_price) ? round($design->gemstone_price,2) : 0;
            $data['cz_stone_price'] = isset($design->cz_stone_price) ? round($design->cz_stone_price,2) : 0;
            $data['less_gems_stone'] = isset($design->less_gems_stone) ? $design->less_gems_stone : 0;
            $data['less_cz_stone'] = isset($design->less_cz_stone) ? $design->less_cz_stone : 0;

            // Weight
            $data['weight_14k'] = isset($design->weight1) ? $design->weight1 : 0;
            $data['weight_18k'] = isset($design->weight2) ? $design->weight2 : 0 ;
            $data['weight_20k'] = isset($design->weight3) ? $design->weight3 : 0;
            $data['weight_22k'] = isset($design->weight4) ? $design->weight4 : 0;

            // Gross Weight
            $data['gross_weight_14k'] = isset($design->gweight1) ? $design->gweight1 : 0;
            $data['gross_weight_18k'] = isset($design->gweight2) ? $design->gweight2 : 0;
            $data['gross_weight_20k'] = isset($design->gweight3) ? $design->gweight3 : 0;
            $data['gross_weight_22k'] = isset($design->gweight4) ? $design->gweight4 : 0;

            // Net Weight
            $data['net_weight_14k'] = isset($design->nweight1) ? $design->nweight1 : 0;
            $data['net_weight_18k'] = isset($design->nweight2) ? $design->nweight2 : 0;
            $data['net_weight_20k'] = isset($design->nweight3) ? $design->nweight3 : 0;
            $data['net_weight_22k'] = isset($design->nweight4) ? $design->nweight4 : 0;

            // Westage
            $data['wastage_14k'] = isset($design->wastage1) ? $design->wastage1 : 0;
            $data['wastage_18k'] = isset($design->wastage2) ? $design->wastage2 : 0;
            $data['wastage_20k'] = isset($design->wastage3) ? $design->wastage3 : 0;
            $data['wastage_22k'] = isset($design->wastage4) ? $design->wastage4 : 0;

            // Metal Value
            $data['metal_value_14k'] = round($gold_price_24k_1gm_mbo * 0.59 * $data['net_weight_14k']);
            $data['metal_value_18k'] = round($gold_price_24k_1gm_mbo * 0.76 * $data['net_weight_18k']);
            $data['metal_value_20k'] = round($gold_price_24k_1gm_mbo * 0.84 * $data['net_weight_20k']);
            $data['metal_value_22k'] = round($gold_price_24k_1gm_mbo * 0.92 * $data['net_weight_22k']);

            $sales_wastage_of_category = isset($sales_wastage[$category_id]) ? $sales_wastage[$category_id] : 0;
            $sales_wastage_discount_of_category = isset($sales_wastage_discount[$category_id]) ? $sales_wastage_discount[$category_id] : 0;
            $data['sales_westage'] = floatval($sales_wastage_of_category);
            $data['sales_westage_discount'] = floatval($sales_wastage_discount_of_category);

            // Making Charges
            $data['making_charge_14k'] = round(($gold_price_24k_1gm_mbo * $sales_wastage_of_category / 100) * $data['gross_weight_14k']);
            $data['making_charge_18k'] = round(($gold_price_24k_1gm_mbo * $sales_wastage_of_category / 100) * $data['gross_weight_18k']);
            $data['making_charge_20k'] = round(($gold_price_24k_1gm_mbo * $sales_wastage_of_category / 100) * $data['gross_weight_20k']);
            $data['making_charge_22k'] = round(($gold_price_24k_1gm_mbo * $sales_wastage_of_category / 100) * $data['gross_weight_22k']);

            // Making Charges with Westage Discount            
            $data['making_charge_discount_14k'] = ($sales_wastage_of_category > 0 && $sales_wastage_discount_of_category > 0) ? round($data['making_charge_14k'] - ($data['making_charge_14k'] * $sales_wastage_discount_of_category / 100)) : 0;
            $data['making_charge_discount_18k'] = ($sales_wastage_of_category > 0 && $sales_wastage_discount_of_category > 0) ? round($data['making_charge_18k'] - ($data['making_charge_18k'] * $sales_wastage_discount_of_category / 100)) : 0;
            $data['making_charge_discount_20k'] = ($sales_wastage_of_category > 0 && $sales_wastage_discount_of_category > 0) ? round($data['making_charge_20k'] - ($data['making_charge_20k'] * $sales_wastage_discount_of_category / 100)) : 0;
            $data['making_charge_discount_22k'] = ($sales_wastage_of_category > 0 && $sales_wastage_discount_of_category > 0) ? round($data['making_charge_22k'] - ($data['making_charge_22k'] * $sales_wastage_discount_of_category / 100)) : 0;

            // Total Amount
            $data['total_amount_14k'] = ($data['making_charge_discount_14k'] > 0) ? round($data['metal_value_14k'] + $data['making_charge_discount_14k']) : round($data['metal_value_14k'] +  $data['making_charge_14k']);
            $data['total_amount_18k'] = ($data['making_charge_discount_18k'] > 0) ? round($data['metal_value_18k'] + $data['making_charge_discount_18k']) : round($data['metal_value_18k'] +  $data['making_charge_18k']);
            $data['total_amount_20k'] = ($data['making_charge_discount_20k'] > 0) ? round($data['metal_value_20k'] + $data['making_charge_discount_20k']) : round($data['metal_value_20k'] +  $data['making_charge_20k']);
            $data['total_amount_22k'] = ($data['making_charge_discount_22k'] > 0) ? round($data['metal_value_22k'] + $data['making_charge_discount_22k']) : round($data['metal_value_22k'] +  $data['making_charge_22k']);

            $designs_array[] = $data;

        }



        if(isset($this->subcategories) && count($this->subcategories) > 0){

            $tags_ids = Design::whereIn('category_id', $this->subcategories)->pluck('tags')->toArray();

            $filteredTags = (new Collection($tags_ids))->filter(function ($tag) {

                $array = json_decode($tag, true);

                return (is_array($array) && count($array) > 1) || (is_array($array) && count($array) > 0);

            })->values()->toArray();

            if(count($filteredTags) > 0){

                $all_tags = [];

                foreach($filteredTags as $filteredTag){

                    $filteredTag = json_decode($filteredTag);

                    if(count($filteredTag) > 0){

                        foreach($filteredTag as $tag){

                            $all_tags[] = $tag;

                        }

                    }

                }

                $categories_tags = Tag::whereIn('id',$all_tags)->where('status',1)->get(['id','name']);

            }else{

                $categories_tags = [];

            }

        }else{

            $categories_tags = Tag::where('status',1)->get(['id','name']);

        }



        if(isset($this->subcategories) && count($this->subcategories) > 0){

            $min_design_price = Design::whereIn('category_id', $this->subcategories)->min('total_price_18k');

            $max_design_price = Design::whereIn('category_id', $this->subcategories)->max('total_price_18k');

        }else{

            $min_design_price = Design::min('total_price_18k');

            $max_design_price = Design::max('total_price_18k');

        }



        $all_details['total_records'] = $this->total_records;

        $all_details['filterd_records'] = count($this->resource);

        $all_details['designs'] = $designs_array;

        $all_details['tags'] = $categories_tags;

        $all_details['tags'] = $categories_tags;

        $all_details['minprice'] = round($min_design_price);

        $all_details['maxprice'] = round($max_design_price);

        return $all_details;

    }

}
