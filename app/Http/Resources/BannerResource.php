<?php

namespace App\Http\Resources;

use App\Models\BottomBanner;
use App\Models\MiddleBanner;
use App\Models\TopBanner;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $reorderder_days = isset($this->resource) ? $this->resource : [];
        $all_banners  = [];

        // All Top Banners
        $top_banners = TopBanner::whereIn('day', $reorderder_days)
        ->orderByRaw("FIELD(day, " . implode(',', $reorderder_days) . ")")
        ->get();
        if (count($top_banners) > 0)
        {
            $top_banners_arr = [];
            foreach ($top_banners as $top_banner)
            {

                $top_banner_records['id'] = $top_banner->id;
                $top_banner_records['image'] = (isset($top_banner->image) && !empty($top_banner->image) && file_exists('public/images/uploads/top_banners/'.$top_banner->image)) ? asset('public/images/uploads/top_banners/'.$top_banner->image) : asset('public/images/default_images/not-found/no_img1.jpg');
                $top_banner_records['description'] = isset($top_banner->description) ? $top_banner->description : '';
                $top_banner_records['day'] = $top_banner->day;
                $top_banner_records['tag_id'] = $top_banner->tag_id;
                $top_banners_arr[] = $top_banner_records;
            }
            $all_banners['top_banners'] = $top_banners_arr;
        }

        // All Middle Banners
        $middle_banners = MiddleBanner::where('status', 1)->get();
        if (count($middle_banners) > 0)
        {
            $middle_banners_arr = [];
            foreach ($middle_banners as $middle_banner)
            {

                $middle_banner_records['id'] = $middle_banner->id;
                $middle_banner_records['image'] = (isset($middle_banner->image) && !empty($middle_banner->image) && file_exists('public/images/uploads/middle_banners/'.$middle_banner->image)) ? asset('public/images/uploads/middle_banners/'.$middle_banner->image) : asset('public/images/default_images/not-found/no_img1.jpg');
                $middle_banner_records['description'] = isset($middle_banner->description) ? $middle_banner->description : '';
                $middle_banner_records['tag_id'] = $middle_banner->tag_id;
                $middle_banners_arr[] = $middle_banner_records;
            }
            $all_banners['middle_banners'] = $middle_banners_arr;
        }

        // All Bottom Banners
        $bottom_banners = BottomBanner::where('status', 1)->get();
        if (count($bottom_banners) > 0)
        {
            $bottom_banners_arr = [];
            foreach ($bottom_banners as $bottom_banner)
            {

                $bottom_banner_records['id'] = $bottom_banner->id;
                $bottom_banner_records['image'] = (isset($bottom_banner->image) && !empty($bottom_banner->image) && file_exists('public/images/uploads/bottom_banners/'.$bottom_banner->image)) ? asset('public/images/uploads/bottom_banners/'.$bottom_banner->image) : asset('public/images/default_images/not-found/no_img1.jpg');
                $bottom_banner_records['description'] = isset($bottom_banner->description) ? $bottom_banner->description : '';
                $bottom_banner_records['tag_id'] = $bottom_banner->tag_id;
                $bottom_banners_arr[] = $bottom_banner_records;
            }
            $all_banners['bottom_banners'] = $bottom_banners_arr;
        }

        return $all_banners;
    }
}
