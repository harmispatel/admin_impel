<?php

namespace App\Http\Controllers;

use App\Traits\ImageTrait;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    use ImageTrait;

    // Display a listing of the resource.
    public function index()
    {
        return view('admin.testimonials.index');
    }


    // Load all Testimonials helping with AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()) {

            $testimonials = Testimonial::get();

            return DataTables::of($testimonials)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $banner = (isset($row->image) && !empty($row->image) && file_exists('public/images/uploads/testimonials_users/' . $row->image)) ? asset('public/images/uploads/testimonials_users/' . $row->image) : asset("public/images/default_images/not-found/no_img1.jpg");
                    return '<img class="me-2" src="' . $banner . '" width="65" height="65">';
                })
                ->addColumn('status', function ($row) {
                    $isChecked = ($row->status == 1) ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus(\'' . encrypt($row->id) . '\')" id="statusBtn" ' . $isChecked . '></div>';
                })
                ->addColumn('actions', function ($row) {
                    $action_html = '';
                    $action_html .= '<a href="' . route('testimonials.edit', encrypt($row->id)) . '" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                    $action_html .= '<a onclick="deleteTestimonial(\'' . encrypt($row->id) . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                    return $action_html;
                })
                ->rawColumns(['status', 'actions', 'image'])
                ->make(true);
        }
    }


    // Show the form for creating a new resource.
    public function create()
    {
        return view('admin.testimonials.create');
    }


    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'customer' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'message' => 'required|min:20',
        ]);

        try {
            $input = $request->except(['_token', 'image']);

            if ($request->hasFile('image')) {
                $image = $this->addSingleImage('testimonials_user', 'testimonials_users', $request->file('image'), "", "250*250");
                $input['image'] = $image;
            }

            Testimonial::create($input);

            return redirect()->route('testimonials.index')->with('success', 'Testimonial has been Created.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, something went wrong!');
        }
    }


    // Change Status of the specified resource.
    public function status(Request $request)
    {
        try {
            $testimonial = Testimonial::find(decrypt($request->id));
            $testimonial->status = ($testimonial->status == 1) ? 0 : 1;
            $testimonial->update();
            return response()->json([
                'success' => 1,
                'message' => "Status has been Changed.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try {
            $testimonial = Testimonial::find(decrypt($id));
            return view('admin.testimonials.edit', compact(['testimonial']));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }


    // Update the specified resource in storage.
    public function update(Request $request)
    {
        try{
            $testimonial = Testimonial::find(decrypt($request->id));
            $input = $request->except(['_token', 'image', 'id']);

            if($request->hasFile('image')){
                $old_image = (isset($testimonial['image'])) ? $testimonial['image'] : '';
                $image = $this->addSingleImage('testimonials_user', 'testimonials_users', $request->file('image'), $old_image, "250*250");
                $input['image'] = $image;
            }
            $testimonial->update($input);
            return redirect()->route('testimonials.index')->with('success', 'Testimonial has been Updated.');
        }catch (\Throwable $th){
            dd($th);
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }


    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try {
            $testimonial = Testimonial::find(decrypt($request->id));

            // Delete old Image
            $old_image = isset($testimonial->image) ? $testimonial->image : '';
            if (!empty($old_image) && file_exists('public/images/uploads/testimonials_users/' . $old_image)) {
                unlink('public/images/uploads/testimonials_users/' . $old_image);
            }

            $testimonial->delete();
            return response()->json([
                'success' => 1,
                'message' => "Testimonial has been Deleted.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }
}
