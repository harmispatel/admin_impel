<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDelaerListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
            $orders = isset($this->resource) ? $this->resource : [];
    
            $order_array = [];
            foreach($orders as $order)
            {
                $data['id'] = $order->id;
                $data['order_date'] = $order->order_date;
                $data['design_name'] = $order->designs->name;
                $data['quantity'] = $order->quantity;
                $data['status'] = $order->order_status;
                $data['image'] = isset($order->designs) ?  asset('public/images/uploads/item_image/'.$order->designs->image) : '' ;
                $order_array[] = $data;
            }
    
            return $order_array;
        
    }
}
