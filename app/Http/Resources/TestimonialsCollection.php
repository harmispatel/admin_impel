<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TestimonialsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return[
            'data'=>$this->collection->map(function($data){
                return[
                    'id'=>$data->id,
                    'customer'=>$data->customer,
                    'messsage'=>$data->message,
                    'image'=>isset($data->image) ? asset('public/images/uploads/testimonials_users/'.$data->image) : "",
                    'status'=>($data->status==1) ? true : false,
                    'created_at'=>$data->created_at
                ];
            })
        ];
    }

    public function with($request){
        return [
            'success'=>true,
            'message'=>'Testimonials List Loaded Successfully',
        ];
    }
}
