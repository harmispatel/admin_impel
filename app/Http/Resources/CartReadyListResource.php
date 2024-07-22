<?php

namespace App\Http\Resources;

use App\Models\ReadyCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class CartReadyListResource extends JsonResource
{
    public function toArray($request)
    {
        $carts = isset($this->resource['carts']) ? $this->resource['carts'] : [];
        $total_qty = isset($this->resource['total_qty']) ? $this->resource['total_qty'] : 0;

        $admin_settings = getAdminSettings();
        $sales_wastage = (isset($admin_settings['sales_wastage']) && !empty($admin_settings['sales_wastage'])) ? unserialize($admin_settings['sales_wastage']) : [];

        $sales_wastage_discount = (isset($admin_settings['sales_wastage_discount']) && !empty($admin_settings['sales_wastage_discount'])) ? unserialize($admin_settings['sales_wastage_discount']) : [];
        $gold_price_24k_1gm_mbo = (isset($admin_settings['gold_price_24k_1gm_mbo']) && !empty($admin_settings['gold_price_24k_1gm_mbo'])) ? $admin_settings['gold_price_24k_1gm_mbo'] : 0;

        $main_array = [];
        $cart_array = [];

        foreach($carts as $cart){

           $readyCategory = ReadyCategory::where('category_name',$cart->group_name)->first();
           $category_id = $readyCategory->category_id;

            $data['id'] = (isset($cart->id)) ? $cart->id : '';
            $data['design_id'] = (isset($cart->design_id)) ? $cart->design_id : '';
            $data['user_id'] = (isset($cart->user_id)) ? $cart->user_id : '';
            $data['quantity'] = (isset($cart->quantity)) ? intval($cart->quantity) : '';
            $data['tag_no'] = (isset($cart->tag_no)) ? $cart->tag_no : '';
            $data['group_name'] = (isset($cart->group_name)) ? $cart->group_name : '';
            $data['name'] =  (isset($cart->name)) ? $cart->name : '';
            $data['price'] = isset($cart->price) ? $cart->price : '';
            $data['size'] = isset($cart->size) ? $cart->size : '';
            $data['gross_weight'] = isset($cart->gross_weight) ? $cart->gross_weight : '';
            $data['net_weight'] = isset($cart->net_weight) ? $cart->net_weight : '';
            $data['gold_price'] = isset($cart->gold_price) ? $cart->gold_price : '';
            $data['barcode'] = isset($cart->barcode) ? $cart->barcode : '';
            $data['gold_id'] = isset($cart->gold_id) ? $cart->gold_id : '';


            $sales_wastage_of_category = isset($sales_wastage[$category_id]) ? $sales_wastage[$category_id] : 0;



            $data['image'] = isset($cart->barcode) ?  $cart->barcode : '' ;
            // $data['percentage'] = isset($cart->designs->percentage) ? $cart->designs->percentage : '';

            // Metal Value
            $data['metal_value'] = round($gold_price_24k_1gm_mbo * 0.59 * $data['net_weight']);

            $sales_wastage_of_category = isset($sales_wastage[$category_id]) ? $sales_wastage[$category_id] : 0;
            $sales_wastage_discount_of_category = isset($sales_wastage_discount[$category_id]) ? $sales_wastage_discount[$category_id] : 0;
            $data['sales_westage'] = floatval($sales_wastage_of_category);
            $data['sales_westage_discount'] = floatval($sales_wastage_discount_of_category);

            // Making Charges
            $data['making_charge'] = round(($gold_price_24k_1gm_mbo * $sales_wastage_of_category / 100) * $data['gross_weight']);

            // Making Charges with Westage Discount
            $data['making_charge_discount'] = ($sales_wastage_of_category > 0 && $sales_wastage_discount_of_category > 0) ? round($data['making_charge'] - ($data['making_charge'] * $sales_wastage_discount_of_category / 100)) : 0;

            // Total Amount
            $data['total_amount'] = ($data['making_charge_discount'] > 0) ? round($data['metal_value'] + $data['making_charge_discount']) : round($data['metal_value'] +  $data['making_charge']);

            $cart_array[] = $data;

        }

        $main_array['carts'] = $cart_array;
        $main_array['total_qty'] = $total_qty;
        return $main_array;
    }
}

