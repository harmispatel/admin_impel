<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportData;
use App\Exports\Exportdata;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\{Category, Design};



class ImportExportController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:import.export', ['only' => ['index']]);
    }


    public function index()
    {
        return view('admin.import_export.import_export');
    }

    public function importDesigns(Request $request)
    {
        $request->validate([
            'import_file'  => 'required|mimes:xls,xlsx'
        ]);

        try {

            $import_file = $request->file('import_file');
            Excel::import(new ImportData,$import_file);

            return response()->json([
                'success' => 1,
                'message' => 'Designs Imported Successfully.',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => 'Something went Wrong!',
            ]);
        }
    }


    public function exportDesigns()
    {
        $total_categories_ids = Design::pluck('category_id');
        $unique_category_ids = $total_categories_ids->unique();
        $categories = Category::whereIn('id',$unique_category_ids)->pluck('parent_category');

        if (count($categories) > 0)
        {
            $data['categories'] = $categories;
            try {
                return Excel::download(new Exportdata($data),'all_designes.xlsx');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error','Something Went Wrong!');
            }
        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }
}
