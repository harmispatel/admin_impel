<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DesignCollectionPDFListResource extends JsonResource
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
        $admin_settings = getAdminSettings();
        $gold_price_24k_1gm_mbo = (isset($admin_settings['gold_price_24k_1gm_mbo']) && !empty($admin_settings['gold_price_24k_1gm_mbo'])) ? $admin_settings['gold_price_24k_1gm_mbo'] : 0;
        $sales_wastage = (isset($admin_settings['sales_wastage']) && !empty($admin_settings['sales_wastage'])) ? unserialize($admin_settings['sales_wastage']) : [];
        $sales_wastage_discount = (isset($admin_settings['sales_wastage_discount']) && !empty($admin_settings['sales_wastage_discount'])) ? unserialize($admin_settings['sales_wastage_discount']) : [];
        $designscollections_array = [];

        foreach($designscollections as $designscollection){

            $category_id = isset($designscollection->designs->categories) ? $designscollection->designs->categories->id : '';
            $data['id'] = $designscollection->designs->id;
            $data['name'] = $designscollection->designs->name;
            $data['gold_type'] = $designscollection->gold_type;
            $data['gold_color'] = $designscollection->gold_color;
            $data['quantity'] = 1;
            $data['code'] = $designscollection->designs->code;
            
            // $data['image'] = (isset($designscollection->designs->image) && file_exists('public/images/uploads/item_images/'.$designscollection->designs->code.'/'.$designscollection->designs->image)) ? asset('public/images/uploads/item_images/'.$designscollection->designs->code.'/'.$designscollection->designs->image) : asset('public/images/default_images/not-found/no_img1.jpg');
            $imagePath = (isset($designscollection->designs->image) && file_exists(public_path('images/uploads/item_images/'.$designscollection->designs->code.'/'.$designscollection->designs->image))) ? public_path('images/uploads/item_images/'.$designscollection->designs->code.'/'.$designscollection->designs->image) : public_path('images/default_images/not-found/no_img1.jpg');
       
            if (file_exists($imagePath)) {
                $imageData = file_get_contents($imagePath);
                $base64Image = base64_encode($imageData);
                $data['image'] = 'data:image/jpeg;base64,' . $base64Image; 
            } else {
                $imageData = file_get_contents(public_path('images/default_images/not-found/no_img1.jpg'));
                $base64Image = base64_encode($imageData);
                $data['image'] = 'data:image/jpeg;base64,' . $base64Image; 
            }

            // Gross Weight
            $data['gross_weight_14k'] = isset($designscollection->designs->gweight1) ? $designscollection->designs->gweight1 : '';
            $data['gross_weight_18k'] = isset($designscollection->designs->gweight2) ? $designscollection->designs->gweight2 : '';
            $data['gross_weight_20k'] = isset($designscollection->designs->gweight3) ? $designscollection->designs->gweight3 : '';
            $data['gross_weight_22k'] = isset($designscollection->designs->gweight4) ? $designscollection->designs->gweight4 : '';

            // Net Weight
            $data['net_weight_14k'] = isset($designscollection->designs->nweight1) ? $designscollection->designs->nweight1 : '';
            $data['net_weight_18k'] = isset($designscollection->designs->nweight2) ? $designscollection->designs->nweight2 : '';
            $data['net_weight_20k'] = isset($designscollection->designs->nweight3) ? $designscollection->designs->nweight3 : '';
            $data['net_weight_22k'] = isset($designscollection->designs->nweight4) ? $designscollection->designs->nweight4 : '';

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

            $designscollections_array[] = $data;

        }

        $response['pdf_items'] = $designscollections_array;
        $response['total_quantity'] = count($designscollections);

        return $response;

    }
}
