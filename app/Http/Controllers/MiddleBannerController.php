<?php



namespace App\Http\Controllers;



use App\Traits\ImageTrait;

use Illuminate\Http\Request;

use App\Models\{Tag, MiddleBanner};

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\MiddleBannerRequest;

use Illuminate\Support\Facades\Auth;



class MiddleBannerController extends Controller

{

    use ImageTrait;



    // Display a listing of the resource.

    public function index()

    {

        if(Auth::guard('admin')->user()->can('middle-banners.index')){

            $total_middle_banner = MiddleBanner::count();

            return view('admin.middle_banners.index', compact(['total_middle_banner']));

        }else{

            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

        }

    }



    // Load all middle banners helping with AJAX Datatable

    public function load(Request $request)

    {

        if ($request->ajax()){



            $middle_banners = MiddleBanner::with(['tag'])->get();



            return DataTables::of($middle_banners)

            ->addIndexColumn()

            ->addColumn('image', function ($row){

                $banner = (isset($row->image) && !empty($row->image) && file_exists('public/images/uploads/middle_banners/'.$row->image)) ? asset('public/images/uploads/middle_banners/'.$row->image) : asset("public/images/default_images/not-found/no_img1.jpg");

                return '<img class="me-2" src="'.$banner.'" width="100" height="50">';

            })

            ->addColumn('status', function ($row){

                $isChecked = ($row->status == 1) ? 'checked' : '';

                if(Auth::guard('admin')->user()->can('middle-banners.status')){

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

                if(Auth::guard('admin')->user()->can('middle-banners.edit')){

                    $action_html .= '<a href="'.route('middle-banners.edit',encrypt($row->id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';

                }else{

                    $action_html .= '- ';

                }



                if(Auth::guard('admin')->user()->can('middle-banners.destroy')){

                    $action_html .= '<a onclick="deleteMiddleBanner(\''.encrypt($row->id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';

                }else{

                    $action_html .= '- ';

                }



                return $action_html;

            })

            ->rawColumns(['status','actions','image','tag'])

            ->make(true);

        }

    }



    // Show the form for creating a new resource.

    public function create()

    {

        if(Auth::guard('admin')->user()->can('middle-banners.create')){

            $tags = Tag::get();

            return view('admin.middle_banners.create', compact(['tags']));

        }else{

            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

        }

    }



    // Store a newly created resource in storage.

    public function store(MiddleBannerRequest $request)

    {

        try{

            $input = $request->except(['_token', 'image','tag']);

            $input['tag_id'] = $request->tag;



            if($request->hasFile('image')){

                $image = $this->addSingleImage('middle_banner', 'middle_banners', $request->file('image'), '', "400*400");

                $input['image'] = $image;

            }

            MiddleBanner::insert($input);

            return redirect()->route('middle-banners.index')->with('success', 'Middle Banner has been Created.');

        }catch (\Throwable $th){

            return redirect()->back()->with('error', 'Oops, Something went wrong!');

        }

    }



    // Show the form for editing the specified resource.

    public function edit($id)

    {

        try{

            if(Auth::guard('admin')->user()->can('middle-banners.edit')){

                $middle_banner = MiddleBanner::find(decrypt($id));

                $tags = Tag::all();

                return view('admin.middle_banners.edit', compact(['middle_banner','tags']));

            }else{

                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

            }

        }catch (\Throwable $th){

            return redirect()->back()->with('error', 'Oops, Something went wrong!');

        }

    }



    // Update the specified resource in storage.

    public function update(MiddleBannerRequest $request)

    {

        try{

            $middle_banner = MiddleBanner::find(decrypt($request->id));

            $input = $request->except(['_token', 'image','tag','id','link']);

           // $input['tag_id'] = $request->tag;

            $url = $request->link;
            $tag_id = null;

            // if ($url) {
            //     $parsed_url = parse_url($url); 
            //     if (isset($parsed_url['query'])) {
            //         parse_str($parsed_url['query'], $query_params);
            //         $tag_id = $query_params['tag_id'] ?? null;
            //     }
            // }

            $input['tag_id'] = $tag_id; 
            $input['tag_link'] = $url;


            if($request->hasFile('image')){

                $old_image = (isset($middle_banner['image'])) ? $middle_banner['image'] : '';

                $image = $this->addSingleImage('middle_banner', 'middle_banners', $request->file('image'), $old_image, "400*400");

                $input['image'] = $image;

            }

            $middle_banner->update($input);

            return redirect()->route('middle-banners.index')->with('success', 'Middle Banner has been Updated.');

        }catch (\Throwable $th){

            return redirect()->back()->with('error', 'Oops, Something went wrong!');

        }

    }



    // Change Status of the specified resource.

    public function status(Request $request)

    {

        try{

            $middle_banner = MiddleBanner::find(decrypt($request->id));

            $middle_banner->status = ($middle_banner->status == 1) ? 0 : 1;

            $middle_banner->update();

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



    // Remove the specified resource from storage.

    public function destroy(Request $request)

    {

        try{

            $middle_banner = MiddleBanner::find(decrypt($request->id));



            // Delete old Image

            $old_image = isset($middle_banner->image) ? $middle_banner->image : '';

            if (!empty($old_image) && file_exists('public/images/uploads/middle_banners/'.$old_image)){

                unlink('public/images/uploads/middle_banners/'.$old_image);

            }



            $middle_banner->delete();

            return response()->json([

                'success' => 1,

                'message' => "Middle Banner has been Deleted.",

            ]);

        }catch (\Throwable $th){

            return response()->json([

                'success' => 0,

                'message' => "Oops, Something went wrong!",

            ]);

        }

    }



}

