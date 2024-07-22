<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\{Design, Design_image, Tag};
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ImportData implements ToModel,WithHeadingRow,WithCalculatedFormulas
{
   /**
    * @param Collection $collection
    */
    public function model(array  $rows)
    {
        try {
            $rows = array_filter($rows);
            if (isset($rows) && count($rows) > 0)
            {
                $design_no = (isset($rows['design_no'])) ? $rows['design_no'] : '';
                $input['name'] = (isset($rows['item'])) ? $rows['item'] : '';
                $input['category_id'] = (isset($rows['subcategoryid'])) ? $rows['subcategoryid'] : '';
                $input['gender_id'] = (isset($rows['genderid'])) ? $rows['genderid'] : '';
                $input['metal_id'] = (isset($rows['metalid'])) ? $rows['metalid'] : '';

                $find_design = Design::where('code',$design_no)->first();
                $design_id = (isset($find_design['id'])) ? $find_design['id'] : '';

                // Insert Tags & Update Tags
                $tags  = [];
                if(isset($rows['tag1']) && !empty($rows['tag1'])){
                    $tags[] = $rows['tag1'];
                }
                if(isset($rows['tag2']) && !empty($rows['tag2'])){
                    $tags[] = $rows['tag2'];
                }
                if(isset($rows['tag3']) && !empty($rows['tag3'])){
                    $tags[] = $rows['tag3'];
                }
                if(isset($rows['tag4']) && !empty($rows['tag4'])){
                    $tags[] = $rows['tag4'];
                }
                if(isset($rows['tag5']) && !empty($rows['tag5'])){
                    $tags[] = $rows['tag5'];
                }
                if(isset($rows['tag6']) && !empty($rows['tag6'])){
                    $tags[] = $rows['tag6'];
                }
                if(isset($rows['tag7']) && !empty($rows['tag7'])){
                    $tags[] = $rows['tag7'];
                }
                if(isset($rows['tag8']) && !empty($rows['tag8'])){
                    $tags[] = $rows['tag8'];
                }
                if(isset($rows['tag9']) && !empty($rows['tag9'])){
                    $tags[] = $rows['tag9'];
                }
                if(isset($rows['tag10']) && !empty($rows['tag10'])){
                    $tags[] = $rows['tag10'];
                }

                $tag_ids  = [];
                if(count($tags) > 0){
                    foreach($tags as $tag){
                        $find_tag = Tag::where('name',$tag)->first();
                        $tag_id = (isset($find_tag['id'])) ? $find_tag['id'] : '';

                        // Update Tag
                        if(isset($tag_id) && !empty($tag_id)){
                            $update_tag = Tag::find($tag_id);
                            $update_tag->name = $tag;
                            $update_tag->update();
                            $tag_ids[] = $tag_id;
                        }else{
                            $new_tag = Tag::create(['name'=>$tag]);
                            $tag_ids[] = $new_tag->id;
                        }
                    }
                }

                $input['tags'] = json_encode($tag_ids);
                $input['code'] = $design_no;
                $input['image'] = $design_no.'.jpg';
                $input['video'] = $design_no.'.mp4';
                $input['description'] = (isset($rows['description'])) ? $rows['description'] : '';

                // Gross Weight
                $gross_weight_14k = (isset($rows['gross_waight_in_14k'])) ? $rows['gross_waight_in_14k'] : 0;
                $gross_weight_14k = is_numeric($gross_weight_14k) ? $gross_weight_14k : $this->getCalculatedValue($rows['gross_waight_in_14k']);
                $gross_weight_18k = (isset($rows['gross_waight_in_18k'])) ? $rows['gross_waight_in_18k'] : 0;
                $gross_weight_18k = is_numeric($gross_weight_18k) ? $gross_weight_18k : $this->getCalculatedValue($rows['gross_waight_in_14k']);
                $gross_weight_20k = (isset($rows['gross_waight_in_20k'])) ? $rows['gross_waight_in_20k'] : 0;
                $gross_weight_20k = is_numeric($gross_weight_20k) ? $gross_weight_20k : $this->getCalculatedValue($rows['gross_waight_in_14k']);
                $gross_weight_22k = (isset($rows['gross_waight_in_22k'])) ? $rows['gross_waight_in_22k'] : 0;
                $gross_weight_22k = is_numeric($gross_weight_22k) ? $gross_weight_22k : $this->getCalculatedValue($rows['gross_waight_in_14k']);

                // Stone
                $total_gem_stone_waight = (isset($rows['total_gem_stone_waight'])) ? $rows['total_gem_stone_waight'] : 0;
                $total_cz_waight = (isset($rows['total_cz_waight'])) ? $rows['total_cz_waight'] : 0;

                // Net Weight
                $net_weight_14k = number_format($gross_weight_14k - $total_gem_stone_waight - $total_cz_waight,2);
                $net_weight_18k = number_format($gross_weight_18k - $total_gem_stone_waight - $total_cz_waight,2);
                $net_weight_20k = number_format($gross_weight_20k - $total_gem_stone_waight - $total_cz_waight,2);
                $net_weight_22k = number_format($gross_weight_22k - $total_gem_stone_waight - $total_cz_waight,2);

                $input['gweight1'] = $gross_weight_14k;
                $input['gweight2'] = $gross_weight_18k;
                $input['gweight3'] = $gross_weight_20k;
                $input['gweight4'] = $gross_weight_22k;
                $input['less_gems_stone'] = $total_gem_stone_waight;
                $input['less_cz_stone'] = $total_cz_waight;
                $input['nweight1'] = $net_weight_14k;
                $input['nweight2'] = $net_weight_18k;
                $input['nweight3'] = $net_weight_20k;
                $input['nweight4'] = $net_weight_22k;
                $input['percentage'] = (isset($rows['percentage'])) ? $rows['percentage'] : '';

                if(!empty($design_id) || $design_id != ''){
                    // Update Design
                    $update_design = Design::find($design_id)->update($input);
                }else{
                    // Create New Design
                    $new_design = Design::create($input);

                    // Insert Multiple Image
                    $mul_images = [
                        '0' => $design_no."A.jpg",
                        '1' => $design_no."B.jpg",
                        '2' => $design_no."C.jpg",
                        '3' => $design_no."D.jpg",
                    ];
                    if(count($mul_images) > 0){
                        foreach($mul_images as $image){
                            $new_image = new Design_image();
                            $new_image->design_id = $new_design->id;
                            $new_image->image = $image;
                            $new_image->save();
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            return redirect()->route('import.export')->with('error', 'Oops Something Went Wrong!');
        }
    }

    private function getCalculatedValue($cell)
    {
        // Use the Excel package to get the calculated value
        $calculatedValue = \PhpOffice\PhpSpreadsheet\Calculation\Calculation::getInstance()->calculateCellValue($cell);

        return $calculatedValue;
    }
}
