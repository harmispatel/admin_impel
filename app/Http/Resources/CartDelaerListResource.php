<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartDelaerListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $carts = isset($this->resource) ? $this->resource : [];

        $cart_array = [];
        foreach($carts as $cart)
        {
            $data['id'] = $cart->id;
            $data['design_name'] = $cart->design_name;
            $data['quantity'] = $cart->quantity;
            $data['image'] = isset($cart->designs) ?  asset('public/images/uploads/item_image/'.$cart->designs->image) : '' ;
            $cart_array[] = $data;
        }

        return $cart_array;
    }
}
