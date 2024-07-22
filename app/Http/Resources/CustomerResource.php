<?php

namespace App\Http\Resources;

use App\Models\State;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $profile = isset($this->resource) ? $this->resource : [];

        $docs = $profile->document;
        if(count($docs) > 0) {
            foreach($docs as $doc)
            {
                $pro_doc['id'] = $doc->id;
                $pro_doc['document'] = asset('public/images/uploads/documents/'.$doc->document);
                $pro_doc_array[] = $pro_doc;
            }
        }

        $data['id'] = isset($profile->id) ? $profile->id : '';
        $data['user_type'] = isset($profile->user_type) ? $profile->user_type : '';
        $data['name'] = isset($profile->name) ? $profile->name : '';
        $data['email'] = isset($profile->email) ? $profile->email : '';
        $data['phone'] = isset($profile->phone) ? $profile->phone : '';
        $data['address'] = isset($profile->address) ? $profile->address : '';
        $data['city'] = isset($profile->company_city) ? $profile->company_city : '';
        $data['state'] = isset($profile->company_state) ? $profile->company_state : '';
        $data['pincode'] = isset($profile->pincode) ? $profile->pincode : '';
        $data['shipping_address'] = isset($profile->shipping_address) ? $profile->shipping_address : '';
        $data['shipping_city'] = isset($profile->shippingCity) ? $profile->shippingCity : '';
        $data['shipping_state'] = isset($profile->shippingState) ? $profile->shippingState : '';
        $data['shipping_pincode'] = isset($profile->shipping_pincode) ? $profile->shipping_pincode : '';
        $data['ref_name'] = isset($profile->ref_name) ? $profile->ref_name : '';
        $data['company_logo'] = isset($profile->company_logo) ? asset('public/images/uploads/companies_logos/'.$profile->company_logo) : asset("public/images/default_images/not-found/no_img1.jpg");
        $data['profile'] = isset($profile->profile) ? asset('public/images/uploads/user_images/'.$profile->profile) : asset('public/images/default_images/profiles/profile1.jpg');
        $data['comapany_name'] = isset($profile->comapany_name) ? $profile->comapany_name : '';
        $data['status'] = isset($profile->status) ? $profile->status : '';
        $data['verification'] = isset($profile->verification) ? $profile->verification : '';
        $data['address_same_as_company'] = isset($profile->address_same_as_company) ? $profile->address_same_as_company : '';
        $data['gst_no'] = isset($profile->gst_no) ? $profile->gst_no : '';
        $data['pan_no'] = isset($profile->pan_no) ? $profile->pan_no : '';
        $data['whatsapp_no'] = isset($profile->whatsapp_no) ? $profile->whatsapp_no : '';
        $data['documents'] = isset($pro_doc_array) ?  $pro_doc_array : [];
        $data['states'] = State::get()->toArray();
        $profile_data = $data;
        return $profile_data;

    }
}
