<?php

namespace App\Http\Controllers;

use App\Models\CompanyMaster;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyMasterRequest;
use App\Models\ItemGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function show($id)
    {
        $company_master_id = decrypt($id);
        // Initialize curl
        $curl = curl_init();

        // Set the POST URL
        $url = 'https://api.indianjewelcast.com/api/Tag/GetFilters';

        $request = [
            // "DeviceID"=>0,
            // "SortBy"=> "",
            // "SearchText"=> "",
            // "TranType"=> "",
            // "CatalogType"=> "",
            // "CommaSeperate_ItemGroupID"=> "",
            // "CommaSeperate_ItemID"=> "",
            // "CommaSeperate_StyleID"=> "",
            // "CommaSeperate_ProductID"=> "",
            // "CommaSeperate_SubItemID"=> "",
            // "CommaSeperate_AppItemCategoryID"=> "",
            // "CommaSeperate_ItemSubID"=> "",
            // "CommaSeperate_KarigarID"=> "",
            // "CommaSeperate_BranchID"=> "",
            // "CommaSeperate_Size"=> "",
            // "CommaSeperate_CounterID"=> "",
            // "MaxNetWt"=> "",
            // "MinNetWt"=> "",
            // "OnlyCartItem"=> "",
            // "OnlyWishlistItem"=> "",
            // "StockStatus"=> "",
            // "FilterType"=> "",
            // "DoNotShowInClientApp"=> "",
            // "HasTagImage"=> ""

            
            "CommaSeperate_AppItemCategoryID"=> "",
            "CommaSeperate_BranchID"=> "",
            "CommaSeperate_CompanyID"=> $company_master_id,
            "CommaSeperate_CounterID"=> "",
            "CommaSeperate_ItemGroupID"=> "",
            "CommaSeperate_ItemID"=> "",
            "CommaSeperate_ItemSubID"=> "",
            "CommaSeperate_KarigarID"=> "",
            "CommaSeperate_ProductID"=> "",
            "CommaSeperate_Size"=> "",
            "CommaSeperate_StyleID"=> "",
            "CommaSeperate_SubItemID"=> "",
            "DeviceID"=> 0,
            "DoNotShowInClientApp"=> 0,
            "HasTagImage"=> 0,
            "MaxNetWt"=> 0,
            "MinNetWt"=> 0,
            "OnlyCartItem"=> false,
            "OnlyWishlistItem"=> false,
            "PageNo"=> 0,
            "PageSize"=> 60,
            "SearchText"=> "",
            "SortBy"=> "",
            "StockStatus"=> "",
            "TranType"=> ""
        ];

        // Set the POST data
        $data = json_encode($request);

        // Set curl options
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                // Add any other headers if required
            ],
            CURLOPT_TIMEOUT => 30, // Timeout in seconds
            CURLOPT_CONNECTTIMEOUT => 10, // Connection timeout in seconds
        ]);

        // Execute the request
        $response = curl_exec($curl);

        // Check for errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return $error;
        }

        // Close curl
        curl_close($curl);
        $decodedResponse = json_decode($response, true);
        $itemGroups = $decodedResponse['Filters']['ItemGroups'] ?? [];
       
        return view('admin.company_master.show',compact('itemGroups','company_master_id'));
    }

    public function updateItemGroup(Request $request)
    {
        try {
            $item_goups = ItemGroup::where('item_group_id',$request->item_group_id)->first();
            if(!empty($item_goups)){
                $item_goups->status = $request->status;
                $item_goups->update();
            }else{
                $item_goup = new ItemGroup();
                $item_goup->item_group = $request->group_name;
                $item_goup->item_group_id = $request->item_group_id;
                $item_goup->company_master_id = $request->company_master_id;
                $item_goup->status = $request->status;
                $item_goup->save();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Item Group status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status. ' . $e->getMessage()
            ]);
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


     // Change status of specified Comapny master
     public function status(Request $request)
     {
         try {
             $comapny_master = CompanyMaster::find(decrypt($request->id));
             $comapny_master->status = ($comapny_master->status == 1) ? 0 : 1;
             $comapny_master->update();
             return response()->json([
                 'success' => 1,
                 'message' => ($comapny_master->status == 1) ? 'Comapany Master has been Enabled.' : 'Comapany Master has been Disabled.',
             ]);
         } catch (\Throwable $th) {
             return response()->json([
                 'success' => 0,
                 'message' => 'Oops, Something went wrong!',
             ]);
         }
     }
 
}
