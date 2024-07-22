<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportData implements WithMultipleSheets
{

    protected $data;


    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
        $all_data = $this->data;

        // Add logic to generate sheets dynamically based on your data
        foreach ($all_data['categories'] as $category) {
            $sheets[] = new SheetExport($category);
        }
        return $sheets;
    }

}
