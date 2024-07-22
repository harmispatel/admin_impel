<?php



namespace App\Http\Controllers;



use App\Models\{Category, Design};

use App\Traits\ImageTrait;

use Illuminate\Http\Request;

use App\Http\Requests\CategoriesRequest;

use Illuminate\Support\Facades\Auth;



class CategoryController extends Controller

{

    use ImageTrait;



    // Display a listing of the resource.

    public function index()

    {

        if(Auth::guard('admin')->user()->can('categories.index')){

            $categories = Category::with(['subcategories','parentcategory'])->where('parent_category',0)->get();

            return view('admin.categories.index', compact('categories'));

        }else{

            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

        }

    }





    // Store a newly created resource in storage.

    public function store(CategoriesRequest $request)

    {

        try{

            $input = $request->except('_token','image','parent_category','parent_cat','category_id');



            // Parent Category

            if ($request->parent_cat) {

                $input['parent_category'] = 0;

            }else{

                $input['parent_category'] = $request->parent_category;

            }



            if(isset($request->category_id) && !empty($request->category_id)){

                $input['id'] = $request->category_id;

            }



            // Upload Category Image when Exists

            if ($request->hasFile('image')){

                $file = $request->file('image');

                $image_url = $this->addSingleImage('category','category_images',$file, '',"300*300");

                $input['image'] = $image_url;

            }



            // Insert Category

            Category::insert($input);



            return $this->sendResponse(true, "Category has been Created.");

        }catch (\Throwable $th){

            return $this->sendResponse(false, 'Oops, Something went wrong!');

        }

    }





    // Show the form for editing the specified resource.

    public function edit(Request $request)

    {

        try {

            $category_id =  decrypt($request->id);

            $category_details = Category::where('id',$category_id)->first();

            $cat_image_html = '';



            if(isset($category_details['image']) && !empty($category_details['image']) && file_exists('public/images/uploads/category_images/'.$category_details['image'])){

                $cat_image_html .= '<img src="'.asset('public/images/uploads/category_images/'.$category_details['image']).'" width="70">';

            }else{

                $cat_image_html .= '<img src="'.asset('public/images/default_images/not-found/no_img1.jpg').'" width="70">';

            }

            $category_details['image'] = $cat_image_html;



            return $this->sendResponse(true,"Category has been Retrived.",$category_details);

        } catch (\Throwable $th) {

            return $this->sendResponse(false, "Oops, Something went wrong!");

        }

    }





    // Update the specified resource in storage.

    public function update(CategoriesRequest $request)
    {

        try{

            $category_id = isset($request->id) ? $request->id : '';
            $category = Category::find($category_id);



            $input = $request->except('_token','category_id','image','parent_category','parent_cat','category_id');



            // Parent Category

            if ($request->parent_cat == null || $request->parent_cat ) {

                $input['parent_category'] = 0;

            }else{

                $input['parent_category'] = $request->parent_category;

            }



            if(isset($category->id)){

                // Save Image if exists

                if ($request->has('image')){

                    $old_image = (isset($category['image'])) ? $category['image'] : '';

                    if ($request->hasFile('image')){

                        $file = $request->file('image');

                        $image_url = $this->addSingleImage('category','category_images',$file, $old_image,"300*300");

                        $input['image'] = $image_url;

                    }

                }

                $category->update($input);

            }

            return $this->sendResponse(true, "Category has been Upadated.");

        }catch (\Throwable $th){

            return $this->sendResponse(false, "Oops, Something went wrong!");

        }

    }





    // Change Category Status

    public function status(Request $request)

    {

        try{

            $category_id = decrypt($request->id);

            $category = Category::find($category_id);

            $category->status =  ($category->status == 1) ? 0 : 1;

            $category->update();



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

            $category_id = decrypt($request->id);

            $category = Category::find($category_id);



            $child_exists = Category::where('parent_category', $category_id)->count();

            $design_exists = Design::where('category_id',$category_id)->count();

            if($child_exists > 0){

                return response()->json([

                    'success' => 0,

                    'message' => "This category will not be deleted unless it has a design or child category!",

                ]);

            }else if($design_exists > 0){

                return response()->json([

                    'success' => 0,

                    'message' => "This category will not be deleted unless it has a design or child category!",

                ]);

            }



            // Delete Category Image

            $cat_image = isset($category->image) ? $category->image : '';

            if(!empty($cat_image) && file_exists('public/images/uploads/category_images/'.$cat_image)){

                unlink('public/images/uploads/category_images/'.$cat_image);

            }



            // Delete Category

            $category->delete();



            return response()->json([

                'success' => 1,

                'message' => "Category has been Deleted.",

            ]);

        }catch (\Throwable $th){

            return response()->json([

                'success' => 0,

                'message' => "Oops, Something went wrong!",

            ]);

        }

    }



}

