<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class CartUserListResource extends JsonResource
{
    // Transform the resource into an array.
    public function toArray($request)
    {
        $carts = isset($this->resource['carts']) ? $this->resource['carts'] : [];
        $total_qty = isset($this->resource['total_qty']) ? $this->resource['total_qty'] : 0;
        $admin_settings = getAdminSettings();
        $gold_price_24k_1gm_mbo = (isset($admin_settings['gold_price_24k_1gm_mbo']) && !empty($admin_settings['gold_price_24k_1gm_mbo'])) ? $admin_settings['gold_price_24k_1gm_mbo'] : 0;
        $sales_wastage = (isset($admin_settings['sales_wastage']) && !empty($admin_settings['sales_wastage'])) ? unserialize($admin_settings['sales_wastage']) : [];
        $sales_wastage_discount = (isset($admin_settings['sales_wastage_discount']) && !empty($admin_settings['sales_wastage_discount'])) ? unserialize($admin_settings['sales_wastage_discount']) : [];

        $main_array = [];
        $cart_array = [];

        foreach($carts as $cart){

            $category_id = isset($cart->designs->categories) ? $cart->designs->categories->id : '';

            $data['id'] = (isset($cart->id)) ? $cart->id : '';
            $data['design_id'] = (isset($cart->design_id)) ? $cart->design_id : '';
            $data['design_name'] = (isset($cart->design_name)) ? $cart->design_name : '';
            $data['quantity'] = (isset($cart->quantity)) ? $cart->quantity : '';
            $data['gold_type'] = (isset($cart->gold_type)) ? $cart->gold_type : '';
            $data['gold_color'] = (isset($cart->gold_color)) ? $cart->gold_color : '';
            $data['image'] = isset($cart->designs) ?  asset('public/images/uploads/item_images/'.$cart->designs->code.'/'.$cart->designs->image) : '' ;
            $data['percentage'] = isset($cart->designs->percentage) ? $cart->designs->percentage : '';

            // Net Weight
            $data['net_weight_14k'] = isset($cart->designs->nweight1) ? $cart->designs->nweight1 : '';
            $data['net_weight_18k'] = isset($cart->designs->nweight2) ? $cart->designs->nweight2 : '';
            $data['net_weight_20k'] = isset($cart->designs->nweight3) ? $cart->designs->nweight3 : '';
            $data['net_weight_22k'] = isset($cart->designs->nweight4) ? $cart->designs->nweight4 : '';

            // Gross Weight
            $data['gross_weight_14k'] = isset($cart->designs->gweight1) ? $cart->designs->gweight1 : '';
            $data['gross_weight_18k'] = isset($cart->designs->gweight2) ? $cart->designs->gweight2 : '';
            $data['gross_weight_20k'] = isset($cart->designs->gweight3) ? $cart->designs->gweight3 : '';
            $data['gross_weight_22k'] = isset($cart->designs->gweight4) ? $cart->designs->gweight4 : '';


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

            $cart_array[] = $data;

        }

        $main_array['cart_items'] = $cart_array;
        $main_array['total_quantity'] = $total_qty;
        return $main_array;
    }
}

