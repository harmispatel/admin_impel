<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        if (Auth::guard('admin')->user()->can('pages.index')) {
            return view('admin.pages.index');
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'You have no rights for this action!');
        }
    }

    // Load all orders helping with AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()){

            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $order = 'id';
            $dir = 'ASC';
            $search = $request->input('search.value');

            $totalData = Page::query();
            $pages = Page::query();

            if(!empty($search)){
                $pages->where('name', 'LIKE', "%{$search}%");
                $totalData = $totalData->where('name', 'LIKE', "%{$search}%");
            }

            $totalData = $totalData->count();
            $totalFiltered = $totalData;
            $pages = $pages->offset($start)->orderBy($order, $dir)->limit($limit)->get();

            $item = array();
            $all_items = array();

            if(count($pages) > 0){
                foreach ($pages as $page) {
                    $item['id'] = $page->id;
                    $item['name'] = (isset($page['name']) && !empty($page['name'])) ? $page['name'] : '';

                    $isChecked = ($page->status == 1) ? 'checked' : '';
                    $item['status'] = '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus(\''.encrypt($page->id).'\')" id="statusBtn" '.$isChecked.'></div>';

                    $action_html = '';
                    $action_html .= '<a href="'.route('pages.edit', encrypt($page->id)).'" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>';
                    $item['actions'] = $action_html;

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


    public function destroy(Request $request)
    {
        try{
            $page = Page::find(decrypt($request->id));
            $page_image = isset($page->image) ? $page->image : '';

            if (!empty($page_image) && file_exists('public/images/uploads/pages/'.$page_image)) {
                unlink('public/images/uploads/pages/'.$page_image);
                $page->image = null;
                $page->save();
            }

            return response()->json([
                'success' => 1,
                'message' => "Image has been Deleted.",

            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('admin.pages.create');
    }


   // Show the form for editing the specified resource.
   public function edit($id)
   {
       try{
            $page_details = Page::find(decrypt($id));
            return view('admin.pages.edit', compact(['page_details']));
       }catch (\Throwable $th){
           return redirect()->back()->with('error', 'Oops, Something went wrong!');
       }
   }

    // Store a newly created resource in storage.
   public function store(Request $request)
   {
        $request->validate([
            'name' => 'required|unique:pages,name',
            'image' => 'image',
        ]);

        try {
            $page_name = $request->name;
            $page_content = $request->content;
            $page_slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $page_name));

            $page = new Page();
            $page->name = $page_name;
            $page->slug = $page_slug;
            $page->content = $page_content;

            // Upload Image if Exists
            if ($request->hasFile('image')) {
                $image_name = 'page_' . $page_slug . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('images/uploads/pages/'), $image_name);
                $page->image = $image_name;
            }
            $page->save();
            return redirect()->route('pages.index')->with('success', 'Page has been Created.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
   }


    // Update Page
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:pages,name,'.$request->id,
            'image' => 'image',
        ]);

        try {
            $page_name = $request->name;
            $page_content = $request->content;
            $page_slug = strtolower($page_name);
            $page_slug = str_replace(' ', '-', $page_slug);

            $page = Page::find($request->id);
            $page->name = $page_name;
            $page->slug = $page_slug;
            $page->content = $page_content;

            // Upload Image if Exists
            if ($request->hasFile('image')) {
                // Delete Old
                if (isset($page->image) && !empty($page->image) && file_exists('public/images/uploads/pages/' . $page->image)) {
                    unlink('public/images/uploads/pages/' . $page->image);
                }

                $image_name = 'page_' . $page_slug . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('images/uploads/pages/'), $image_name);
                $page->image = $image_name;
            }
            $page->update();
            return redirect()->back()->with('success', 'Page Details has been Updated.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Change Status of the specified resource.
    public function status(Request $request)
    {
        try{
            $page = Page::find(decrypt($request->id));
            $page->status = ($page->status == 1) ? 0 : 1;
            $page->update();
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
}
