<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyMasterItemResource extends JsonResource
{
    public function toArray($request)
    {
        $items = $this->resource['item_groups'] ?? collect(); // Ensuring collection

        $items_array = [];

        foreach ($items as $value) {
            $items_array[] = [
                'Id' => $value->id ?? "",
                'ItemID' => $value->item_id ?? "",
                'ItemName' => $value->item_name ?? "",
                'CompanyMasterId' => $value->company_master_id ?? "",
                'Status' => $value->status ?? "",
            ];
        }

        return ['Items' => $items_array];
    }
}
