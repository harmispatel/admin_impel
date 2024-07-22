<?php

namespace App\Http\Controllers;

use App\Models\{Admin};
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\{Role};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\{DB, Hash, Auth};

class AdminController extends Controller
{
    use ImageTrait;

    // Display a listing of the resource.
    public function index()
    {
        if(Auth::guard('admin')->user()->can('users.index')){
            return view('admin.users.index');
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    // Load all users with helping AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()){
            // Get all Admins
            $admins = Admin::get();

            return DataTables::of($admins)
            ->addIndexColumn()
            ->addColumn('name', function ($row){
                return "$row->firstname $row->lastname";
            })
            ->addColumn('image', function ($row){
                $image = (isset($row->image) && !empty($row->image) && file_exists('public/images/uploads/user_images/'.$row->image)) ? asset('public/images/uploads/user_images/'.$row->image) : asset('public/images/default_images/profiles/profile1.jpg');
                return '<img src="'.$image.'" width="60">';
            })
            ->addColumn('role', function ($row){
                return (isset($row->role->name)) ? $row->role->name : '';
            })
            ->addColumn('status', function ($row){
                $checked = ($row->status == 1) ? 'checked' : '';
                if($row->id != 1){
                    if(Auth::guard('admin')->user()->can('users.status')){
                        return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$row->id.')" id="statusBtn" '.$checked.'></div>';
                    }else{
                        return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="statusBtn" '.$checked.' disabled></div>';
                    }
                }else{
                    return '-';
                }
            })
            ->addColumn('actions',function($row){
                $action_html = '';
                if($row->id != 1){
                    if(Auth::guard('admin')->user()->can('users.edit')){
                        $action_html .= '<a href="'.route('users.edit',encrypt($row->id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                    }else{
                        $action_html .= '- ';
                    }

                    if(Auth::guard('admin')->user()->can('users.destroy')){
                        $action_html .= '<a onclick="deleteUsers(\''.encrypt($row->id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                    }else{
                        $action_html .= '- ';
                    }
                }else{
                    $action_html .= '-';
                }
                return $action_html;
            })
            ->rawColumns(['status','role','actions','image','name'])
            ->make(true);
        }
    }

    // Show the form for creating a new resource.
    public function create()
    {
        if(Auth::guard('admin')->user()->can('users.create')){
            $roles = Role::all();
        return view('admin.users.create', compact('roles'));
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    // Store a newly created resource in storage.
    public function store(UserRequest $request)
    {
        try {
            $input = $request->except('_token','image','confirm_password','password', 'role');
            $input['password'] = Hash::make($request->password);
            $input['user_type'] = $request->role;

            if ($request->hasFile('image')){
                $image_url = $this->addSingleImage('user_image', 'user_images', $request->file('image'), '',"300*300");
                $input['image'] = $image_url;
            }

            $user = Admin::create($input);
            $role = Role::where('id',$user->user_type)->first();
            $user->assignRole($role->name);
            return redirect()->route('users.index')->with('success','User has been Created.');
        } catch (\Throwable $th) {
            return redirect()->route('users.index')->with('error','Oops, Something with wrong');
        }
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try {
            if(Auth::guard('admin')->user()->id == decrypt($id)){
                if(Auth::guard('admin')->user()->can('myprofile.update')){
                    $roles = Role::all();
                    $user = Admin::find(decrypt($id));
                    return view('admin.users.edit',compact('user','roles'));
                }else{
                    return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
                }
            }else{
                if(Auth::guard('admin')->user()->can('users.edit')){
                    $roles = Role::all();
                    $user = Admin::find(decrypt($id));
                    return view('admin.users.edit',compact('user','roles'));
                }else{
                    return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
                }
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Update the specified resource in storage.
    public function update(UserRequest $request)
    {
        try {
            $input = $request->except('_token','id','password','confirm_password','image', 'role');
            if(!empty($request->password) || $request->password != null){
                $input['password'] = Hash::make($request->password);
            }
            if(isset($request->role) && !empty($request->role)){
                $input['user_type'] = $request->role;
            }

            $user = Admin::find(decrypt($request->id));
            if(isset($user->id)){
                if ($request->hasFile('image')){
                    $old_image = (isset($user ->image)) ? $user ->image : '';
                    $image_url = $this->addSingleImage('user', 'user_images', $request->file('image'), $old_image, "300*300");
                    $input['image'] = $image_url;
                }
                $user->update($input);

                DB::table('model_has_roles')->where('model_id',decrypt($request->id))->delete();
                $role = Role::where('id', $user->user_type)->first();
                $user->assignRole($role->name);
            }
            return redirect()->route('users.index')->with('success','User has been Updated.');
        } catch (\Throwable $th) {
            return redirect()->route('users.index')->with('error','Oops, Something went wrong!');
        }
    }

   // Show the Details of the specified resource.
    public function show()
    {
        try {
            if(Auth::guard('admin')->user()->can('myprofile.index')){
                $user = Auth::guard('admin')->user();
                return view('admin.users.show', compact(['user']));
            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Change Status of the specified resource.
    public function status(Request $request)
    {
        try {
            $admin = Admin::find($request->id);
            $admin->status =  ($admin->status == 1) ? 0 : 1;
            $admin->update();
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
            $user = Admin::find(decrypt($request->id));
            $user_image = isset($user->image) ? $user->image : '';

            // Delete User Image
            if (!empty($user_image) && file_exists('public/images/uploads/user_images/'.$user_image)) {
                unlink('public/images/uploads/user_images/'.$user_image);
            }

            $user->delete();

            return response()->json([
                'success' => 1,
                'message' => "User has been Deleted.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }

}
