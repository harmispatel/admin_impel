<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\{Tag};
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class TagController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        if(Auth::guard('admin')->user()->can('tags.index')){
            return view('admin.tags.index');
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    // Load all tags helping with AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()){
            $tags= Tag::orderBy('name','ASC')->get();
            return DataTables::of($tags)
            ->addIndexColumn()
            ->addColumn('status', function ($row){
                $checked = ($row->status == 1) ? 'checked' : '';
                if(Auth::guard('admin')->user()->can('tags.status')){
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$row->id.')" id="statusBtn" '.$checked.'></div>';
                }else{
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="statusBtn" '.$checked.' disabled></div>';
                }
            })
            ->addColumn('display_on_header', function ($row){
                $checked = ($row->display_on_header == 1) ? 'checked' : '';
                if(Auth::guard('admin')->user()->can('tags.header.status')){
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="displayHeaderStatus('.$row->id.')" id="statusBtn" '.$checked.'></div>';
                }else{
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="statusBtn" '.$checked.' disabled></div>';
                }
            })
            // ->addColumn('actions',function($row){
            //     $action_html = '';
            //     $action_html .= '<a onclick="editTag(\''.encrypt($row->id).'\')" class="btn btn-sm custom-btn me-1" id="editTags"><i class="bi bi-pencil"></i></a>';
            //     $action_html .= '<a onclick="deleteTag(\''.encrypt($row->id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
            //     return $action_html;
            // })
            ->rawColumns(['status','display_on_header','actions'])
            ->make(true);
        }
    }

    // Store a Tags created resource in storage.
    public function store(TagRequest $request)
    {
        try{
            $input = $request->except('_token');
            Tag::create($input);
            return response()->json([
                'success' => 1,
                'message' => "Tag has been Created.",
            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }

    // Show the form for editing the specified Tags.
    public function edit(Request $request)
    {
        try{
            $id = decrypt($request->id);
            $tag = Tag::find($id);
            return response()->json([
                'success' => 1,
                'data' => $tag,
                'message' => "Tag has been Retrived.",
            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }

    // Update the specified Tags in storage.
    public function update(TagRequest $request)
    {
        try{
            $tag_id = isset($request->id) ? $request->id : '';
            $input = $request->except('_token','id');
            $tag = Tag::find($tag_id);
            $tag->update($input);
            return response()->json([
                'success' => 1,
                'message' => "Tag has been Updated.",
            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }

    // Change Display Header Status of Specified resource
    public function headerStatus(Request $request)
    {
        try{
            $tag_id = $request->id;
            $tag = Tag::find($tag_id);
            $tag->display_on_header = ($tag->display_on_header == 1) ? 0 : 1;
            $tag->update();
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

    // Change Status of Specified resource
    public function status(Request $request)
    {
        try{
            $id = $request->id;
            $tag = Tag::find($id);
            $tag->status =  ($tag->status == 1) ? 0 : 1;
            $tag->update();
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


    //  Remove the specified tags from storage.
    public function destroy(Request $request)
    {
        try{
            $tag_id = decrypt($request->id);
            Tag::where('id',$tag_id)->delete();
            return response()->json([
                'success' => 1,
                'message' => "Tag has been Deleted.",
            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }
}
