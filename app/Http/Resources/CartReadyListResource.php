<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class CartReadyListResource extends JsonResource
{
    public function toArray($request)
    {
        $carts = isset($this->resource['carts']) ? $this->resource['carts'] : [];
        $total_qty = isset($this->resource['total_qty']) ? $this->resource['total_qty'] : 0;

        $main_array = [];
        $cart_array = [];

        foreach($carts as $cart){
            $data['id'] = (isset($cart->id)) ? $cart->id : '';
            $data['user_id'] = (isset($cart->user_id)) ? $cart->user_id : '';
            $data['quantity'] = (isset($cart->quantity)) ? intval($cart->quantity) : '';
            $data['tag_no'] = (isset($cart->tag_no)) ? $cart->tag_no : '';
            $data['group_name'] = (isset($cart->group_name)) ? $cart->group_name : '';
            $data['name'] =  (isset($cart->name)) ? $cart->name : '';
            $data['size'] = isset($cart->size) ? $cart->size : '';
            $data['gross_weight'] = isset($cart->gross_weight) ? $cart->gross_weight : '';
            $data['net_weight'] = isset($cart->net_weight) ? $cart->net_weight : '';
            $data['barcode'] = isset($cart->barcode) ? $cart->barcode : '';
            $data['gold_id'] = isset($cart->gold_id) ? $cart->gold_id : '';
            $data['item_group_id'] = isset($cart->item_group_id) ? $cart->item_group_id : '';
            $data['item_id'] = isset($cart->item_id) ? $cart->item_id : '';
            $data['sub_item_id'] = isset($cart->item_id) ? $cart->item_id : '';
            $data['style_id'] = isset($cart->style_id) ? $cart->style_id : '';
            $data['metal_value'] = isset($cart->metal_value) ? $cart->metal_value : '';
            $data['making_charge'] = isset($cart->making_charge) ? $cart->making_charge : '';
            $data['total_amount'] = isset($cart->total_amount) ? $cart->total_amount : '';
            $data['making_charge_discount'] = isset($cart->making_charge_discount) ? $cart->making_charge_discount : '';
            $data['company_id'] = isset($cart->company_id) ? $cart->company_id : '';
            $data['image'] = isset($cart->barcode) ?  $cart->barcode : '' ;
            $cart_array[] = $data;
        }
        $main_array['carts'] = $cart_array;
        $main_array['total_qty'] = $total_qty;
        return $main_array;
    }
}
