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
            $data['id'] = $cart->id ?? "";
            $data['user_id'] = $cart->user_id ?? "";
            $data['company_id'] = $cart->company_id ?? "";
            $data['item_group_id'] = $cart->item_group_id ?? "";
            $data['item_id'] = $cart->item_id ?? "";
            $data['sub_item_id'] = $cart->sub_item_id ?? "";
            $data['style_id'] = $cart->style_id ?? "";
            $data['barcode'] = $cart->barcode ?? "";
            $data['image'] = $cart->barcode ?? "";
            $data['tag_no'] = $cart->tag_no ?? "";
            $data['group_name'] = $cart->group_name ?? "";
            $data['name'] = $cart->name ?? "";
            $data['quantity'] = intval($cart->quantity) ?? 1;
            $data['size'] = $cart->size ?? "";
            $data['gross_weight'] = $cart->gross_weight ?? "";
            $data['net_weight'] = $cart->net_weight ?? "";
            $data['metal_value'] = $cart->metal_value ?? 0;
            $data['making_charge'] = $cart->making_charge ?? 0;
            $data['making_charge_discount'] = $cart->making_charge_discount ?? 0;
            $data['total_amount'] = $cart->total_amount ?? 0;
            $cart_array[] = $data;
        }
        $main_array['carts'] = $cart_array;
        $main_array['total_qty'] = $total_qty;
        return $main_array;
    }
}
