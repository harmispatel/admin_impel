<?php

namespace App\Http\Controllers;

use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Requests\DesignRequest;
use App\Models\{Tag, Metal, Gender, Design, Category, Design_image};
use Illuminate\Support\Facades\Auth;

class DesignController extends Controller
{
    use ImageTrait;

    // Display a listing of the resource.
    public function index()
    {
        if(Auth::guard('admin')->user()->can('designs.index')){
            return view('admin.designs.index');
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    // Load all designs helping with AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()){

            $columns = array(
                0 => 'id',
                2 => 'code',
            );
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $totalData = Design::query();
            $designs = Design::query();

            if(!empty($request->input('search.value'))){
                $search = $request->input('search.value');
                $designs->where('name', 'LIKE', "%{$search}%")->orWhere('code', 'LIKE', "%{$search}%");
                $totalData = $totalData->where('name', 'LIKE', "%{$search}%")->orWhere('code', 'LIKE', "%{$search}%");
            }

            $totalData = $totalData->count();
            $totalFiltered = $totalData;
            $designs = $designs->offset($start)->orderBy($order, $dir)->limit($limit)->get();

            $item = array();
            $all_items = array();

            if(count($designs) > 0){
                foreach ($designs as $design) {
                    $item['id'] = $design->id;
                    $item['name'] = (isset($design['name'])) ? $design['name'] : '';
                    $item['code'] = (isset($design['code'])) ? $design['code'] : '';

                    // Status Button
                    $checked = ($design->status == 1) ? 'checked' : '';
                    if(Auth::guard('admin')->user()->can('designs.status')){
                        $item['status'] = '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$design->id.')" id="statusBtn" '.$checked.'></div>';
                    }else{
                        $item['status'] = '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="statusBtn" '.$checked.' disabled></div>';
                    }

                    // Image
                    if(isset($design->image) && !empty($design->image) && file_exists('public/images/uploads/item_images/'.$design->code.'/'.$design->image)){
                        $item['image'] = '<img src="'.asset('public/images/uploads/item_images/'.$design->code.'/'.$design->image).'" width="70">';
                    }else{
                        $item['image'] = '<img src="'.asset('public/images/default_images/not-found/no_img1.jpg').'" width="70">';
                    }

                    // Top Selling Button
                    $isCheckedTopSelling = ($design->highest_selling == 1) ? 'checked' : '';
                    if(Auth::guard('admin')->user()->can('designs.top-selling.status')){
                        $item['top_selling'] = '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeTopSelling('.$design->id.')" id="statusBtn" '.$isCheckedTopSelling.'></div>';
                    }else{
                        $item['top_selling'] = '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="statusBtn" '.$isCheckedTopSelling.' disabled></div>';
                    }

                    // Actions Buttons
                    // $action_html = '';
                    // $action_html .= '<a href="'.route('designs.edit',encrypt($design->id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                    // $action_html .= '<a onclick="deleteDesign(\''.$design->id.'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                    // $item['actions'] = $action_html;

                    $all_items[] = $item;
                }
            }

            return response()->json([
                "draw"            => intval($request->request->get('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
                "data"            => $all_items
            ]);
        }
    }

    // Show the form for creating a new resource.
    public function create()
    {
        if(Auth::guard('admin')->user()->can('designs.create')){
            $tags = Tag::get();
            $metals = Metal::get();
            $genders = Gender::get();
            $categories = Category::where('parent_category','!=',0)->get();
            return view('admin.designs.create',compact('categories','genders','metals','tags'));
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    // Store a newly created resource in storage.
    public function store(DesignRequest $request)
    {
        try{
            $input = $request->except('_token','tags');
            $input['tags'] = json_encode($request->tags);

            // Create Design
            Design::create($input);
            return redirect()->route('designs.index')->with('success','Design has been Created.');
        } catch (\Throwable $th) {
            return redirect()->route('designs.index')->with('error','Oops, Something went wrong!');
        }
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try {
            if(Auth::guard('admin')->user()->can('designs.edit')){
                $tags = Tag::get();
                $metals = Metal::get();
                $genders = Gender::get();
                $categories = Category::where('parent_category','!=',0)->get();
                $design = Design::find(decrypt($id));
                return view('admin.designs.edit',compact('categories','genders','metals','tags','design'));
            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Update the specified resource in storage.
    public function update(DesignRequest $request)
    {
        try {
            $input = $request->except('_token','tags','id');
            $input['tags'] = json_encode($request->tags);
            $design = Design::find(decrypt($request->id));
            $design->update($input);
            return redirect()->route('designs.index')->with('message','Design has been Updated.');
        } catch (\Throwable $th) {
            return redirect()->route('designs.index')->with('error','Oops, Something went wrong!');
        }
    }

    // Change Status of Specific Design
    public function status(Request $request)
    {
        try{
            $design = Design::find($request->id);
            $design->status =  ($design->status == 1) ? 0 : 1;
            $design->update();
            return response()->json([
                'success' => 1,
                'message' => "Design Status has been Changed.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }

    // Change Status of Top Selling
    public function topSelling(Request $request)
    {
        try{
            $design = Design::find($request->id);
            $design->highest_selling =  ($design->highest_selling == 1) ? 0 : 1;
            $design->update();
            $message = ($design->highest_selling == 1) ? 'Design has been Added to Top Selling.' : 'Design has been Removed from Top Selling.';
            return response()->json([
                'success' => 1,
                'message' => $message,
            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }

    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try {
            $design = Design::find($request->id);
            $design_images = Design_image::where('design_id',$request->id)->get();
            $main_image = isset($design->image) ? $design->image : '';

            // Delete Multiple Image
            foreach($design_images as $design_image){
                if (!empty($design_image->image) && file_exists('public/images/uploads/item_images/'.$design->code.'/'.$design_image->image)){
                    unlink('public/images/uploads/item_images/'.$design->code.'/'.$design_image->image);
                }
            }

            // Delete Main Image
            if (!empty($main_image) && file_exists('public/images/uploads/item_images/'.$design->code.'/'.$main_image)){
                unlink('public/images/uploads/item_images/'.$design->code.'/'.$main_image);
            }

            Design_image::where('design_id',$design->id)->delete();
            $design->delete();

            return response()->json([
                'success' => 1,
                'message' => "Design has been Deleted.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }
}
