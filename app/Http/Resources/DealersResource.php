<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Dealer;

class DealersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $dealers = isset($this->resource) ? $this->resource : [];
        $dealers_array  = [];

        if (count($dealers) > 0)
        {
            foreach ($dealers as $dealer)
            {
                $data['id'] = $dealer->id;
                $data['name'] = $dealer->name;
                $data['email'] = $dealer->email;
                $data['phone'] = $dealer->phone;
                $data['address'] = $dealer->address;
                $data['logo'] = (isset($dealer->logo) && !empty($dealer->logo)) ? asset('public/images/uploads/companies_logos/'.$dealer->logo) : asset('public/images/uploads/companies_logos/no_image.jpg');
                $data['comapany_name'] = $dealer->comapany_name;
                $data['gst_no'] = $dealer->gst_no;
                $data['pincode'] = $dealer->pincode;
                $data['whatsapp_no'] = $dealer->whatsapp_no;
                $dealers_array[] = $data;
            }
        }
        return $dealers_array;
    }
}