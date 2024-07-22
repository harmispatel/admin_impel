<?php

namespace App\Http\Controllers;

use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Models\{User, City, State};
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    use ImageTrait;

    // Display a listing of the resource.
    public function index()
    {
        if(Auth::guard('admin')->user()->can('customers.index')){
            return view('admin.customers.index');
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    // Load all customers with helping AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()){
            $verification_filter = (isset($request->verification_filter)) ? $request->verification_filter : '';
            // Get all Customers
            $customers = User::where('user_type',2);
            if(!empty($verification_filter)){
                $customers = $customers->where('verification', $verification_filter);
                $customers = $customers->orderBy('id','ASC')->get();
            }else{
                $customers = $customers->orderBy('verification','ASC')->get();
            }

            return DataTables::of($customers)
            ->addIndexColumn()
            ->addColumn('verification', function ($row) {
                if($row->verification == 1){
                    return '<span class="badge bg-danger">Half Registerd</span>';
                }elseif($row->verification == 2){
                    return '<span class="badge bg-success">Full Registerd</span>';
                }
            })
            ->addColumn('profile', function ($row) {
                $profile = (isset($row->profile) && !empty($row->profile) && file_exists('public/images/uploads/user_images/'.$row->profile)) ? asset('public/images/uploads/user_images/'.$row->profile) : asset('public/images/default_images/profiles/profile1.jpg');
                return '<img src="'.$profile.'" width="50" style="border-radius:50%;">';
            })
            ->addColumn('status', function ($row){
                $checked = ($row->status == 1) ? 'checked' : '';
                if(Auth::guard('admin')->user()->can('customers.status')){
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$row->id.')" id="statusBtn" '.$checked.'></div>';
                }else{
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="statusBtn" '.$checked.' disabled></div>';
                }
            })
            // ->addColumn('actions',function($row){
            //     $action_html = '';

            //     // Edit Button
            //     if(Auth::guard('admin')->user()->can('customers.edit')){
            //         $action_html .= '<a href="'.route('customers.edit',encrypt($row->id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
            //     }else{
            //         $action_html .= '-';
            //     }
            //     return $action_html;
            // })
            ->rawColumns(['verification','profile','actions','status'])
            ->make(true);
        }
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try {
            $customer = User::find(decrypt($id));
            $states = State::get();
            $cities = City::where('state_id',$customer->state)->get();
            return view('admin.customers.edit',compact('customer','states','cities'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Function for Update Existing Record
    public function update(CustomerRequest $request)
    {
        try {
            $input = $request->except('_token','customer_id','profile_picture');
            $customer = User::find(decrypt($request->customer_id));

            if(isset($customer->id)){

                $old_image = (isset($customer->profile)) ? $customer->profile : '';
                if($request->hasFile('profile_picture')){
                    $profile = $this->addSingleImage('user_image', 'user_images',$request->file('profile_picture'), $old_image,'300*300');
                    $input['profile'] = $profile;
                }

                $customer->update($input);

                if(isset($customer->name) && !empty($customer->name) && isset($customer->email) && !empty($customer->email) && isset($customer->phone) && !empty($customer->phone) && isset($customer->pincode) && !empty($customer->pincode) && isset($customer->address) && !empty($customer->address) && isset($customer->city) && !empty($customer->city) && isset($customer->state) && !empty($customer->state)){
                    $customer->update(['verification' => 2]);
                }else{
                    $customer->update(['verification' => 1]);
                }
            }
            return redirect()->route('customers.index')->with('success','Customer has been Updated.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','oops, Something went wrong!');
        }
    }

    // Function for Change Customer Status
    public function status(Request $request)
    {
        try {
            $customer = User::find($request->id);
            $customer->status =  ($customer->status == 1) ? 0 : 1;
            $customer->update();
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
}
