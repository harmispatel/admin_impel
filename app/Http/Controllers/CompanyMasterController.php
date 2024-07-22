<?php

namespace App\Http\Controllers;

use App\Models\CompanyMaster;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyMasterRequest;
use Illuminate\Support\Facades\Auth;

class CompanyMasterController extends Controller
{
    public function index()
    {
        if(Auth::guard('admin')->user()->can('comapny.master.index')){
            $companymaster = CompanyMaster::all();
            return view('admin.company_master.index',compact('companymaster'));
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    public function store()
    {
        try {
            if(Auth::guard('admin')->user()->can('comapny.master.store')){
                $company = new CompanyMaster();
                $company->company_name = request('company_name');
                $company->company_tag_id = request('company_tag_id');
                $company->save();

                return $this->sendResponse(true, "Company Master has been Created");
            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(false, "Oops, Something went wrong!");
        }
    }


    public function edit(Request $request)
    {
        try {
            if(Auth::guard('admin')->user()->can('comapny.master.edit')){
                $id = decrypt($request->id);
                $company = CompanyMaster::find($id);
                return $this->sendResponse(true,"Company Master has been Retrived.",$company);
            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(false, "Oops, Something went wrong!");
        }
    }

    public function update(CompanyMasterRequest $request)
    {
        try {

            $company = CompanyMaster::find($request->id);
            if (!$company) {
                return $this->sendResponse(false, "Company not found.");
            }

            $company->update($request->all());
            return $this->sendResponse(true, "Company Master has been Upadated.");

        } catch (\Throwable $th) {
            return $this->sendResponse(false, "Oops, Something went wrong!");
        }
    }


    public function destroy(Request $request)
    {
        try{
            if(Auth::guard('admin')->user()->can('comapny.master.destroy')){
                $company_id = decrypt($request->id);
                $company = CompanyMaster::find($company_id);
                $company->delete();

                return response()->json([
                    'success' => 1,
                    'message' => "Company Master has been Deleted.",
                ]);
            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }

        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }
}
