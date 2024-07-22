<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Design;

class HighestDesignResource extends JsonResource
{
    // Transform the resource into an array.
    public function toArray($request)
    {
        $designs = isset($this->resource) ? $this->resource : [];
        $designs_array = [];
        $admin_settings = getAdminSettings();
        $gold_price_24k_1gm_mbo = (isset($admin_settings['gold_price_24k_1gm_mbo']) && !empty($admin_settings['gold_price_24k_1gm_mbo'])) ? $admin_settings['gold_price_24k_1gm_mbo'] : 0;
        $sales_wastage = (isset($admin_settings['sales_wastage']) && !empty($admin_settings['sales_wastage'])) ? unserialize($admin_settings['sales_wastage']) : [];
        $sales_wastage_discount = (isset($admin_settings['sales_wastage_discount']) && !empty($admin_settings['sales_wastage_discount'])) ? unserialize($admin_settings['sales_wastage_discount']) : [];

        if (count($designs) > 0) {
            foreach ($designs as $design) {
                
                $category_id = isset($design->categories) ? $design->categories->id : '';
                $data['id'] = $design->id;
                $data['image'] = (isset($design->image) && !empty($design->image) && file_exists('public/images/uploads/item_images/' . $design->code . '/' . $design->image)) ? asset('public/images/uploads/item_images/' . $design->code . '/' . $design->image) : asset('public/images/default_images/not-found/no_img1.jpg');
                $data['percentage'] = isset($design->percentage) ? $design->percentage : '';

                // Gross Weight
                $data['gross_weight_14k'] = isset($design->gweight1) ? $design->gweight1 : '';
                $data['gross_weight_18k'] = isset($design->gweight2) ? $design->gweight2 : '';
                $data['gross_weight_20k'] = isset($design->gweight3) ? $design->gweight3 : '';
                $data['gross_weight_22k'] = isset($design->gweight4) ? $design->gweight4 : '';

                // Net Weight
                $data['net_weight_14k'] = isset($design->nweight1) ? $design->nweight1 : '';
                $data['net_weight_18k'] = isset($design->nweight2) ? $design->nweight2 : '';
                $data['net_weight_20k'] = isset($design->nweight3) ? $design->nweight3 : '';
                $data['net_weight_22k'] = isset($design->nweight4) ? $design->nweight4 : '';

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

        }

        return $designs_array;

    }

}

