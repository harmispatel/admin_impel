<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReadyPdfListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $pdfs = isset($this->resource['readytopdf']) ? $this->resource['readytopdf'] : [];

        $main_array = [];
        $pdf_array = [];

        foreach($pdfs as $value){
            $data['id'] = $value->id ?? "";
            $data['user_id'] = $value->user_id ?? "";
            $data['company_id'] = $value->company_id ?? "";
            $data['item_group_id'] = $value->item_group_id ?? "";
            $data['item_id'] = $value->item_id ?? "";
            $data['sub_item_id'] = $value->sub_item_id ?? "";
            $data['style_id'] = $value->style_id ?? "";
            $data['barcode'] = $value->barcode ?? "";

            // if (isset($value->barcode)) {
            //     $imageUrl = "https://api.indianjewelcast.com/TagImage/{$value->barcode}.jpg";
            //     $imageData = file_get_contents($imageUrl);
            //     if ($imageData !== false) {
            //         $base64Image = base64_encode($imageData);
            //         $data['image'] = 'data:image/jpeg;base64,' . $base64Image;
            //     } else {
            //         $data['image'] = '';
            //     }
            // } else {
            //     $data['image'] = '';
            // }

            // Check if the image has already been cached
            $cacheKey = 'image_' . $value->barcode;
            $cachedImage = cache()->get($cacheKey);

            if ($cachedImage) {
                $data['image'] = $cachedImage;
            } else {
                if (isset($value->barcode)) {
                    $imageUrl = "https://api.indianjewelcast.com/TagImage/{$value->barcode}.jpg";
                    $imageData = file_get_contents($imageUrl);

                    if ($imageData !== false) {
                        $base64Image = base64_encode($imageData);
                        $imageBase64 = 'data:image/jpeg;base64,' . $base64Image;
                        cache()->put($cacheKey, $imageBase64, now()->addHours(24));
                        $data['image'] = $imageBase64;
                    } else {
                        $data['image'] = '';
                    }
                } else {
                    $data['image'] = '';
                }
            }
            

            $data['tag_no'] = $value->tag_no ?? "";
            $data['group_name'] = $value->group_name ?? "";
            $data['name'] = $value->name ?? "";
            $data['quantity'] = intval($value->quantity) ?? 1;
            $data['size'] = $value->size ?? "";
            $data['gross_weight'] = $value->gross_weight ?? "";
            $data['net_weight'] = $value->net_weight ?? "";
            $data['metal_value'] = $value->metal_value ?? 0;
            $data['making_charge'] = $value->making_charge ?? 0;
            $data['making_charge_discount'] = $value->making_charge_discount ?? 0;
            $data['total_amount'] = $value->total_amount ?? 0;
            $pdf_array[] = $data;
        }
        $main_array['ready_pdfs_list'] = $pdf_array;  
        return $main_array;
    }
}
