<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $genders = isset($this->resource) ? $this->resource : [];
        $genders_array = [];

        if(count($genders) > 0)
        {
            foreach($genders as $gender)
            {
                $data['id'] = $gender->id;
                $data['name'] = $gender->name;
                $genders_array[] = $data;
            }
        }
        return $genders_array;
    }
}
