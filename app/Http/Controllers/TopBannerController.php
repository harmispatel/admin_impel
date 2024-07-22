<?php

namespace App\Http\Controllers;

use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Requests\TopBannerRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\{Tag, TopBanner};
use Illuminate\Support\Facades\Auth;

class TopBannerController extends Controller
{
    use ImageTrait;

    // Display a listing of the resource.
    public function index()
    {
        if(Auth::guard('admin')->user()->can('top-banners.index')){
            $total_top_banner = TopBanner::count();
            return view('admin.top_banners.index', compact(['total_top_banner']));
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    // Load all top banners helping with AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()){

            $top_banners = TopBanner::with(['tag'])->get();

            return DataTables::of($top_banners)
            ->addIndexColumn()
            ->addColumn('image', function ($row){
                $banner = (isset($row->image) && !empty($row->image) && file_exists('public/images/uploads/top_banners/'.$row->image)) ? asset('public/images/uploads/top_banners/'.$row->image) : asset("public/images/default_images/not-found/no_img1.jpg");
                return '<img class="me-2" src="'.$banner.'" width="100" height="50">';
            })
            ->addColumn('day', function ($row){
                $days = [
                    '0' => 'Sunday',
                    '1' => 'Monday',
                    '2' => 'Tuesday',
                    '3' => 'Wednesday',
                    '4' => 'Thursday',
                    '5' => 'Friday',
                    '6' => 'Saturday',
                ];
                return $days[$row->day];
            })
            ->addColumn('status', function ($row){
                $isChecked = ($row->status == 1) ? 'checked' : '';
                if(Auth::guard('admin')->user()->can('top-banners.status')){
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus(\''.encrypt($row->id).'\')" id="statusBtn" '.$isChecked.'></div>';
                }else{
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="statusBtn" '.$isChecked.' disabled></div>';
                }
            })
            ->addColumn('tag', function ($row){
                $tag_name = (isset($row['tag']['name'])) ? $row['tag']['name'] : '';
                return $tag_name;
            })
            ->addColumn('actions',function($row){
                $action_html = '';
                if(Auth::guard('admin')->user()->can('top-banners.edit')){
                    $action_html .= '<a href="'.route('top-banners.edit',encrypt($row->id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                }else{
                    $action_html .= '- ';
                }

                if(Auth::guard('admin')->user()->can('top-banners.destroy')){
                    $action_html .= '<a onclick="deleteTopBanner(\''.encrypt($row->id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                }else{
                    $action_html .= '- ';
                }
                return $action_html;
            })
            ->rawColumns(['status','actions','image','tag','day'])
            ->make(true);
        }
    }

    // Show the form for creating a new resource.
    public function create()
    {
        if(Auth::guard('admin')->user()->can('top-banners.create')){
            $tags = Tag::get();
            return view('admin.top_banners.create', compact(['tags']));
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    // Store a newly created resource in storage.
    public function store(TopBannerRequest $request)
    {
        try{
            $input = $request->except(['_token', 'image','tag']);
            $input['tag_id'] = $request->tag;

            if($request->hasFile('image')){
                $file = $request->image;
                $image = $this->addSingleImage('top_banner', 'top_banners', $file, '', "1200*500");
                $input['image'] = $image;
            }

            TopBanner::insert($input);
            return redirect()->route('top-banners.index')->with('success', 'Top Banner has been Created.');
        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Change Status of the specified resource.
    public function status(Request $request)
    {
        try{
            $top_banner = TopBanner::find(decrypt($request->id));
            $top_banner->status = ($top_banner->status == 1) ? 0 : 1;
            $top_banner->update();
            return response()->json([
                'success' => 1,
                'message' => "Status has been Changed.",
            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try{
            if(Auth::guard('admin')->user()->can('top-banners.edit')){
                $top_banner = TopBanner::find(decrypt($id));
                $tags = Tag::all();
                return view('admin.top_banners.edit', compact(['top_banner','tags']));
            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }
        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Update the specified resource in storage.
    public function update(TopBannerRequest $request)
    {
        try{
            $top_banner = TopBanner::find(decrypt($request->id));
            $input = $request->except(['_token', 'image','tag','id']);
            $input['tag_id'] = $request->tag;

            if($request->hasFile('image')){
                $old_image = (isset($top_banner['image'])) ? $top_banner['image'] : '';
                $image = $this->addSingleImage('top_banner', 'top_banners', $request->file('image'), $old_image, "1200*500");
                $input['image'] = $image;
            }
            $top_banner->update($input);
            return redirect()->route('top-banners.index')->with('success', 'Top Banner has been Updated.');
        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try{
            $top_banner = TopBanner::find(decrypt($request->id));

            // Delete old Image
            $old_image = isset($top_banner->image) ? $top_banner->image : '';
            if (!empty($old_image) && file_exists('public/images/uploads/top_banners/'.$old_image)){
                unlink('public/images/uploads/top_banners/'.$old_image);
            }

            $top_banner->delete();
            return response()->json([
                'success' => 1,
                'message' => "Top Banner has been Deleted.",
            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }
}
