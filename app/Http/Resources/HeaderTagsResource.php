<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HeaderTagsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tags = isset($this->resource) ? $this->resource : [];
        $tags_array = [];

        if(count($tags) > 0)
        {
            foreach($tags as $tag)
            {
                $data['id'] = $tag->id;
                $data['name'] = $tag->name;
                $data['status'] = $tag->status;
                $tags_array[] = $data;
            }
        }
        return $tags_array;
    }
}
