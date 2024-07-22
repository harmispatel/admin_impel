<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomPagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $page_details = isset($this->resource) ? $this->resource : [];
        if (isset($page_details) > 0) {
            $data['id'] = $page_details->id;
            $data['name'] = $page_details->name;
            $data['slug'] = $page_details->slug;
            $data['image'] = (isset($page_details->image) && !empty($page_details->image) && file_exists('public/images/uploads/pages/'.$page_details->image)) ? asset('public/images/uploads/pages/'.$page_details->image) : "";
            $data['content'] = $page_details->content;
    }
        return $data;
    }
}
