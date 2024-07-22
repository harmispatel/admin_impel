<?php



namespace App\Http\Controllers;



use App\Models\RoleHasPermissions;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;

use Spatie\Permission\Models\{Role, Permission};



class RoleController extends Controller

{

    // Display a listing of the resource.

    public function index()
    {

        if(Auth::guard('admin')->user()->can('roles.index')){

            return view('admin.roles.index');

        }else{

            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

        }

    }



    // Load all roles helping AJAX Datatable

    public function load(Request $request)
    {

        if ($request->ajax()){

            $roles= Role::get();

            return DataTables::of($roles)

            ->addIndexColumn()

            ->addColumn('permissions',function($row){

                $permissions_html = '';

                $permissions = (isset($row->permissions)) ? $row->permissions->pluck('name') : [];



                if($row->id == 1){

                    $permissions_html .= '<span class="me-2 mb-2 badge" style="background:#012970; font-size:14px; font-weight:500;">All Access</span>';

                }else{

                    if(count($permissions) > 0){

                        foreach($permissions as $permission){

                            $permission_name = $permission;

                            $permissions_html .= '<span class="me-2 mb-2 badge" style="background:#012970; font-size:14px; font-weight:500;">'.$permission_name.'</span>';

                        }

                    }else{

                        $permissions_html .= '-';

                    }

                }



                return $permissions_html;

            })

            ->addColumn('actions',function($row){

                $action_html = '';

                if($row->id > 1){

                    if(Auth::guard('admin')->user()->can('roles.edit')){

                        $action_html .= '<a href="'.route('roles.edit',encrypt($row->id)).'" class="btn btn-sm custom-btn me-1 "><i class="bi bi-pencil"></i></a>';

                    }else{

                        $action_html .= '- ';

                    }



                    if(Auth::guard('admin')->user()->can('roles.destroy')){

                        $action_html .= '<a  onclick="deleteRole(\''.encrypt($row->id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';

                    }else{

                        $action_html .= '- ';

                    }

                }else{

                    $action_html = '-';

                }

                return $action_html;

            })

            ->rawColumns(['actions', 'permissions'])

            ->make(true);

        }

    }



    // Show the form for creating a new resource.

    public function create()
    {

        if(Auth::guard('admin')->user()->can('roles.create')){

            $permissions = Permission::pluck('id', 'name')->toArray();

            return view('admin.roles.create',compact('permissions'));

        }else{

            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

        }

    }



    // Store a newly created resource in storage.

    public function store(Request $request)
    {

        $request->validate([

            'name' => 'required|unique:roles,name',

        ]);



        try {

            $permissions = (isset($request->permissions)) ? $request->permissions : [];

            $role = Role::create(['name' => $request->name]);

            $role->syncPermissions($permissions);

            return redirect()->route('roles.index')->with('success','Role has been Created.');

        } catch (\Throwable $th) {

            return back()->with('error','Oops, Something went wrong!');

        }

    }



    // Show the form for editing the specified resource.

    public function edit($id)
    {

        try {

            if(Auth::guard('admin')->user()->can('roles.edit')){

                $permissions = Permission::pluck('id', 'name')->toArray();

                $role = Role::find(decrypt($id));

                $role_permissions = RoleHasPermissions::where("role_id", decrypt($id))->pluck('permission_id', 'permission_id')->all();

                return view('admin.roles.edit',compact('role','permissions','role_permissions'));

            }else{

                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

            }

        } catch (\Throwable $th) {

            return back()->with('error','Oops, Something went wrong!');

        }

    }



    // Update the specified resource in storage.

    public function update(Request $request)

    {

        $request->validate([

            'name' => 'required|unique:roles,name,'.decrypt($request->id),

        ]);



        try {

            $permissions = (isset($request->permissions)) ? $request->permissions : [];

            $role = Role::find(decrypt($request->id));

            $role->name = $request->name;

            $role->update();

            $role->syncPermissions($permissions);

            // return redirect()->route('roles.index')->with('success','Role has been Updated.');

            return redirect()->back()->with('success','Role has been Updated.');

        } catch (\Throwable $th) {

            return back()->with('error','Oops, Something went wrong!');

        }

    }



    // Remove the specified resource from storage.

    public function destroy(Request $request)

    {

        try{

            $role = Role::find(decrypt($request->id));

            $role->permissions()->detach($role->id);

            $role->delete();

            return response()->json([

                'success' => 1,

                'message' => "Role has been Deleted.",

            ]);

        }catch (\Throwable $th){

            return response()->json([

                'success' => 0,

                'message' => "Oops, Something went wrong!",

            ]);

        }



    }



}

