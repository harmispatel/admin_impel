<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlashDesignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        $flashDesigns = isset($this->resource) ? $this->resource : [];
        $flashDesign_array  = [];

        if (count($flashDesigns) > 0) 
        {
            foreach ($flashDesigns as $flashDesign)
            {
                $data['id'] = $flashDesign->id;
                $data['name'] = $flashDesign->name;
                $data['image'] = isset($flashDesign->image) ? asset('public/images/uploads/item_image/'.$flashDesign->image) : asset('public/images/uploads/item_image/no_image.jpg');
                $flashDesign_array[] = $data;

            }
        }
        return $flashDesign_array;

    }
}
