<?php

namespace App\Exports;

use App\Models\{Category, Design, Tag};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;


class SheetExport implements FromCollection, WithTitle, WithHeadings, WithEvents
{
    private $category;

    public function __construct($category)
    {
        $this->category = $category;
    }

    public function collection()
    {
        $all_excel_data = [];
        $maincategory_id = $this->category;
        $sub_categories = Category::where('parent_category',$maincategory_id)->pluck('id');
        $designs = Design::whereIn('category_id',$sub_categories)->get();

        if(count($designs) > 0)
        {
            $inner_data = [];
            foreach ($designs as $key => $design)
            {
                $design_data = [];

                // Design No.
                $design_data[] = isset($design->code) ? $design->code : '';
                // Main Category ID
                $design_data[] = $maincategory_id;
                // Sub Category ID
                $design_data[] =  isset($design->category_id) ? $design->category_id : '';
                // Design Name
                $design_data[] = isset($design->name) ? $design->name : '';
                // Gender Id
                $design_data[] = isset($design->gender_id) ? $design->gender_id : '';
                // Metal Id
                $design_data[] = isset($design->metal_id) ? $design->metal_id : '';

                // Tags
                $tags_ids = json_decode($design->tags);
                $tags = [];
                for($i=0; $i<10; $i++){
                    $tag_id = (isset($tags_ids[$i])) ? $tags_ids[$i] : '';
                    $tag = Tag::find($tag_id);
                    $tag_name = (isset($tag['name'])) ? $tag['name'] : '';
                    $tags[] = $tag_name;
                }
                $design_data[] = $tags[0];
                $design_data[] = $tags[1];
                $design_data[] = $tags[2];
                $design_data[] = $tags[3];
                $design_data[] = $tags[4];
                $design_data[] = $tags[5];
                $design_data[] = $tags[6];
                $design_data[] = $tags[7];
                $design_data[] = $tags[8];
                $design_data[] = $tags[9];

                // Total Weight
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';

                // Gross Weight
                $design_data[] = isset($design->gweight4) ? $design->gweight4 : '';
                $design_data[] = isset($design->gweight3) ? $design->gweight3 : '';
                $design_data[] = isset($design->gweight2) ? $design->gweight2 : '';
                $design_data[] = isset($design->gweight1) ? $design->gweight1 : '' ;

                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';

                // Description
                $design_data[] = isset($design->description) ? $design->description : '';

                $design_data[] = '';

                // Less CZ Stone
                $design_data[] = (isset($design['less_cz_stone'])) ? $design['less_cz_stone'] : '';
                // Less Gems Stone
                $design_data[] = (isset($design['less_gems_stone'])) ? $design['less_gems_stone'] : '';

                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';
                $design_data[] = '';

                $design_data[] = (isset($design['percentage'])) ? $design['percentage'] : '';

                $inner_data[] = $design_data;
            }
            $all_excel_data[] = $inner_data;
        }

        // Return the data for the sheet
        return collect($all_excel_data);
    }

      // Sheet Heading
    public function headings(): array
    {
        $heading_arr = [];
        $heading_arr[] = 'DESIGN NO.';
        $heading_arr[] = 'MAINCATEGORYID';
        $heading_arr[] = 'SUBCATEGORYID';
        $heading_arr[] = 'ITEM';
        $heading_arr[] = 'GENDERID';
        $heading_arr[] = 'METALID';
        $heading_arr[] = 'TAG1';
        $heading_arr[] = 'TAG2';
        $heading_arr[] = 'TAG3';
        $heading_arr[] = 'TAG4';
        $heading_arr[] = 'TAG5';
        $heading_arr[] = 'TAG6';
        $heading_arr[] = 'TAG7';
        $heading_arr[] = 'TAG8';
        $heading_arr[] = 'TAG9';
        $heading_arr[] = 'TAG10';
        $heading_arr[] = 'TOTAL WAIGHT IN 22K';
        $heading_arr[] = 'TOTAL WAIGHT IN 20K';
        $heading_arr[] = 'TOTAL WAIGHT IN 18K';
        $heading_arr[] = 'TOTAL WAIGHT IN 14K';
        $heading_arr[] = 'IGROSS WAIGHT IN 22K';
        $heading_arr[] = 'IGROSS WAIGHT IN 20K';
        $heading_arr[] = 'IGROSS WAIGHT IN 18K';
        $heading_arr[] = 'IGROSS WAIGHT IN 14K';
        $heading_arr[] = 'NUMBER OF C.Z';
        $heading_arr[] = 'NUMBER OF GEM STONE';
        $heading_arr[] = 'TOTAL NUMBER OF STONE';
        $heading_arr[] = 'DESCRIPTION';
        $heading_arr[] = 'METAL WAIGHT';
        $heading_arr[] = 'TOTAL C.Z WAIGHT';
        $heading_arr[] = 'TOTAL GEM STONE WAIGHT';
        $heading_arr[] = 'TOTAL STONE WAIGHT';
        $heading_arr[] = 'STONE AVERAGE IN 22K';
        $heading_arr[] = 'STONE AVERAGE IN 20K';
        $heading_arr[] = 'STONE AVERAGE IN 18K';
        $heading_arr[] = 'STONE AVERAGE IN 14K';
        $heading_arr[] = 'MAKING WASTAGE IN 22K';
        $heading_arr[] = 'MAKING WASTAGE IN 20K';
        $heading_arr[] = 'MAKING WASTAGE IN 18K';
        $heading_arr[] = 'MAKING WASTAGE IN 14K';
        $heading_arr[] = 'WHOLSALE PROFIT VASTAGE';
        $heading_arr[] = 'RETAIL PROFIT WASTAGE';
        $heading_arr[] = 'CUSTOMER PROFIT WASTAGE';
        $heading_arr[] = 'APPROX WHOLSALE SELLING WASTAGE IN 22K';
        $heading_arr[] = 'EXACT WHOLSALE SELLING WASTAGE IN 22K';
        $heading_arr[] = 'APPROX WHOLSALE SELLING WASTAGE IN 20K';
        $heading_arr[] = 'EXACT WHOLSALE SELLING WASTAGE IN 20K';
        $heading_arr[] = 'APPROX WHOLSALE SELLING WASTAGE IN 18K';
        $heading_arr[] = 'EXACT WHOLSALE SELLING WASTAGE IN 18K';
        $heading_arr[] = 'APPROX WHOLSALE SELLING WASTAGE IN 14K';
        $heading_arr[] = 'EXACT WHOLSALE SELLING WASTAGE IN 14K';

        $heading_arr[] = 'APPROX RETAIL SELLING WASTAGE IN 22K';
        $heading_arr[] = 'EXACT RETAIL SELLING WASTAGE IN 22K';
        $heading_arr[] = 'APPROX RETAIL SELLING WASTAGE IN 20K';
        $heading_arr[] = 'EXACT RETAIL SELLING WASTAGE IN 20K';
        $heading_arr[] = 'APPROX RETAIL SELLING WASTAGE IN 18K';
        $heading_arr[] = 'EXACT RETAIL SELLING WASTAGE IN 18K';
        $heading_arr[] = 'APPROX RETAIL SELLING WASTAGE IN 14K';
        $heading_arr[] = 'EXACT RETAIL SELLING WASTAGE IN 14K';

        $heading_arr[] = 'APPROX CUSTOMER SELLING WASTAGE IN 22K';
        $heading_arr[] = 'EXACT CUSTOMER SELLING WASTAGE IN 22K';
        $heading_arr[] = 'APPROX CUSTOMER SELLING WASTAGE IN 20K';
        $heading_arr[] = 'EXACT CUSTOMER SELLING WASTAGE IN 20K';
        $heading_arr[] = 'APPROX CUSTOMER SELLING WASTAGE IN 18K';
        $heading_arr[] = 'EXACT CUSTOMER SELLING WASTAGE IN 18K';
        $heading_arr[] = 'APPROX CUSTOMER SELLING WASTAGE IN 14K';
        $heading_arr[] = 'EXACT CUSTOMER SELLING WASTAGE IN 14K';

        $heading_arr[] = 'PERCENTAGE';

        return $heading_arr;
    }

    public function title(): string
    {
        $main_category_id = $this->category;
        $main_category_details = Category::where('id',$main_category_id)->first();
        $main_category_name = isset($main_category_details['name']) ? $main_category_details['name'] : '';
        return $main_category_name;
    }

    // Sheets Settings
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event)
            {
                $event->sheet->getDelegate()->getStyle('A1:BP1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:BP1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:BP1')->getAlignment()->setWrapText(true);
            },
        ];
    }
}
