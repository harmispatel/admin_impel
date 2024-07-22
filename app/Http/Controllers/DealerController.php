<?php



namespace App\Http\Controllers;



use App\Traits\ImageTrait;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Http\Requests\DealerRequest;

use Yajra\DataTables\Facades\DataTables;

use App\Models\{City,User,State,UserDocument};

use Illuminate\Support\Facades\Auth;



class DealerController extends Controller

{

    use ImageTrait;



    // Display a listing of the resource.

    public function index()

    {

        if(Auth::guard('admin')->user()->can('dealers.index')){

            return view('admin.dealers.index');

        }else{

            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

        }

    }



    // Load all dealers helping AJAX Datatable

    public function load(Request $request)

    {

        if ($request->ajax()){



            // Get all Dealers

            $dealers = User::where('user_type',1)->orderBy('status','DESC')->get();



            return DataTables::of($dealers)

            ->addIndexColumn()

            ->addColumn('joined_on', function ($row){

                $joined_on =  "(".$row->created_at->diffForHumans().")</br>".date('d-m-Y', strtotime($row->created_at));

               return $joined_on;

            })

            ->addColumn('profile_picture', function ($row){

                $default_profile_picture = asset('public/images/default_images/profiles/profile1.jpg');

                $profile_picture = (isset($row->profile) && file_exists('public/images/uploads/user_images/'.$row->profile)) ? asset('public/images/uploads/user_images/'.$row->profile) : $default_profile_picture;

                $logo_html = '<img class="me-2" style="border-radius:50%;" src="'.$profile_picture.'" width="50" height="50">';

                return $logo_html;

            })

            ->addColumn('status', function ($row){

                $checked = ($row->status == 1) ? 'checked' : '';

                if(Auth::guard('admin')->user()->can('dealers.status')){

                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$row->id.')" id="statusBtn" '.$checked.'></div>';

                }else{

                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="statusBtn" '.$checked.' disabled></div>';

                }

            })

            ->addColumn('actions',function($row){

                $action_html = '';



                if(Auth::guard('admin')->user()->can('dealers.edit')){

                    $action_html .= '<a href="'.route('dealers.edit',encrypt($row->id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';

                }else{

                    $action_html .= '-';

                }



                if(Auth::guard('admin')->user()->can('dealers.destroy')){

                    // $action_html .= '<a onclick="deleteDealer(\''.encrypt($row->id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';

                }



                return $action_html;

            })

            ->rawColumns(['status','actions','joined_on', 'profile_picture'])

            ->make(true);

        }

    }



    // Show the form for creating a new resource.

    public function create()

    {

        if(Auth::guard('admin')->user()->can('dealers.create')){

            $states = State::get();

            return view('admin.dealers.create',compact(['states']));

        }else{

            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

        }

    }


    // Store a newly created resource in storage.

    public function store(DealerRequest $request)

    {

        try {

            $input = $request->except('_token','password','confirm_password','company_logo','documents','profile_picture');

            $input['password'] = Hash::make($request->password);



            // Upload Company Logo

            if ($request->hasFile('company_logo')){

                $file = $request->file('company_logo');

                $image_url = $this->addSingleImage('comapany_logo','companies_logos',$file, '',"300*300");

                $input['company_logo'] = $image_url;

            }



            // Upload Dealer Profile Picture

            if ($request->hasFile('profile_picture')){

                $file = $request->file('profile_picture');

                $image_url = $this->addSingleImage('user_image','user_images',$file, '',"300*300");

                $input['profile'] = $image_url;

            }



            $dealer = User::create($input);



            // Upload Dealers Documents

            if($request->hasFile('documents')) {

                $documents = $request->file('documents');

                foreach ($documents as $doc){

                    $new_document = new UserDocument;

                    $new_document->user_id = $dealer->id;

                    $doc_name = $this->addSingleImage('document','documents',$doc, '','default');

                    $new_document->document = $doc_name;

                    $new_document->save();

                }

            }

            return redirect()->route('dealers.index')->with('success','Dealers has been Created.');

        } catch (\Throwable $th) {

            return redirect()->route('dealers.index')->with('error','Oops, Something went wrong!');

        }

    }



    // Show the form for editing the specified resource.

    public function edit($id)

    {

        try {

            if(Auth::guard('admin')->user()->can('dealers.edit')){

                $dealer = User::with(['document'])->find(decrypt($id));

                $states = State::get();

                $cities = City::where('state_id',$dealer->state)->get();

                return view('admin.dealers.edit',compact('dealer','states','cities'));

            }else{

                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

            }

        } catch (\Throwable $th) {

            return back()->with('error', 'Oops, Something went wrong!');

        }

    }



    // Update the specified resource in storage.

    public function update(DealerRequest $request)

    {

        try {

            $input = $request->except('_token','id','password','confirm_password','company_logo','documents','profile_picture');

            if ($request->password || $request->password != null) {

                $input['password'] = Hash::make($request->password);

            }



            $dealer = User::find(decrypt($request->id));

            if (isset($dealer->id)){

                // Upload Company Logo

                if ($request->has('company_logo')){

                    $old_company_logo = (isset($dealer->company_logo)) ? $dealer->company_logo : '';

                    if( $request->hasFile('company_logo')){

                        $image_url = $this->addSingleImage('comapany_logo','companies_logos',$request->file('company_logo'), $old_company_logo,"300*300");

                        $input['company_logo'] = $image_url;

                    }

                }



                // Upload Dealer Profile Picture

                if ($request->has('profile_picture')){

                    $old_profile = (isset($dealer->profile)) ? $dealer->profile : '';

                    if( $request->hasFile('profile_picture')){

                        $image_url = $this->addSingleImage('user_image','user_images',$request->file('profile_picture'), $old_profile,"300*300");

                        $input['profile'] = $image_url;

                    }

                }



                // Upload Dealer Documents

                if ($request->hasFile('documents')){

                    $documents = $request->file('documents');

                    foreach ($documents as $doc){

                        $new_document = new UserDocument;

                        $new_document->user_id = decrypt($request->id);

                        $doc_name = $this->addSingleImage('document','documents',$doc, '','default');

                        $new_document->document = $doc_name;

                        $new_document->save();

                    }

                }

                $dealer->update($input);

            }

            return redirect()->route('dealers.index')->with('success','Dealers has been Updated.');

        } catch (\Throwable $th) {

            return redirect()->route('dealers.index')->with('error','Oops, Something went wrong!');

        }

    }



    // Store a Users status Changes resource in storage..

    public function status(Request $request)

    {

        try {

            $dealer = User::find($request->id);

            $dealer->status =  ($dealer->status == 1) ? 0 : 1;

            $dealer->update();

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



    // Remove the specified resource from storage.

    public function destroy(Request $request)

    {

        try {

            $user = User::find(decrypt($request->id));

            $company_logo = (isset($user->company_logo)) ? $user->company_logo : '';

            $profile_picture = (isset($user->profile)) ? $user->profile : '';



            // Delete Company Logo

            if (!empty($company_logo) && file_exists('public/images/uploads/companies_logos/'.$company_logo)){

                unlink('public/images/uploads/companies_logos/'.$company_logo);

            }



            // Delete Profile Picture

            if (!empty($profile_picture) && file_exists('public/images/uploads/user_images/'.$profile_picture)){

                unlink('public/images/uploads/user_images/'.$profile_picture);

            }



            // Delete Dealer Documents

            $documents = UserDocument::where('user_id',decrypt($request->id))->get();

            foreach($documents as $doc){

                if (!empty($doc->document) && file_exists('public/images/uploads/documents/'.$doc->document)){

                    unlink('public/images/uploads/documents/'.$doc->document);

                }

            }

            UserDocument::where('user_id',decrypt($request->id))->delete();



            $user->delete();



            return response()->json([

               'success' => 1,

               'message' => "Dealer has been Deleted.",

            ]);

        } catch (\Throwable $th) {

            return response()->json([

                'success' => 0,

                'message' => "Oops, Something went wrong!",

            ]);

        }

    }



}

