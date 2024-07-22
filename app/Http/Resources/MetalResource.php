<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MetalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        $metals = isset($this->resource) ? $this->resource : [];
        $metals_array = [];

        if(count($metals) > 0)
        {
            foreach($metals as $metal)
            {
                $data['id'] = $metal->id;
                $data['name'] = $metal->name;
                $metals_array[] = $data;
            }
        }
        return $metals_array;
    }
}
