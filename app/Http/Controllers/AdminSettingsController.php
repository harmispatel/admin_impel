<?php

namespace App\Http\Controllers;
use App\Models\AdminSetting;
use App\Models\Category;
use App\Models\ReadyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingsController extends Controller
{

    function index()
    {

        if(Auth::guard('admin')->user()->can('settings.index')){

            $settings = getAdminSettings();
            $categories = Category::where('parent_category', '!=', 0)->get();

            return view('admin.settings.index',compact(['settings', 'categories']));

        }else{

            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

        }

    }

    function PriceCalcMakeByOrder()
    {
        if(Auth::guard('admin')->user()->can('price-calculator.make-by-order')){
            $settings = getAdminSettings();
            $categories = Category::where('parent_category', '!=', 0)->get();

            return view("admin.settings.price_calculate.make_by_order",compact(['settings', 'categories']));
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    function updatePriceCalcMakeByOrder(Request $request)
    {
        try{
                $settings = $request->settings;
                $settings['sales_wastage'] = (isset($settings['sales_wastage'])) ? serialize($settings['sales_wastage']) : '';
                $settings['sales_wastage_discount'] = (isset($settings['sales_wastage_discount'])) ? serialize($settings['sales_wastage_discount']) : '';

                if(Auth::guard('admin')->user()->can('price-calculator.update-make-by-order')){

                    if(count($settings) > 0){

                        foreach ($settings as $key => $setting){

                            $is_exists = AdminSetting::where('setting_key',$key)->first();

                            $setting_id = (isset($is_exists['id']) && !empty($is_exists['id'])) ? $is_exists['id'] : '';



                            if(!empty($setting_id) || $setting_id != ''){

                                $update_settings = AdminSetting::find($setting_id);

                                $update_settings->value = $setting;

                                $update_settings->update();

                            }else{

                                $new_settings = new AdminSetting();

                                $new_settings->setting_key = $key;

                                $new_settings->value = $setting;

                                $new_settings->save();

                            }

                        }

                    }
                    return redirect()->route('price-calculator.make-by-order')->with('success', 'Make by order price has been Updated.');

                }else{
                    return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
                }

        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }


    function update(Request $request)
    {

        try{
            $settings = $request->settings;
            $settings['phonepe_live'] = (isset($settings['phonepe_live'])) ? $settings['phonepe_live'] : 0;

            if(Auth::guard('admin')->user()->can('settings.update')){

                if(count($settings) > 0){

                    foreach ($settings as $key => $setting){

                        $is_exists = AdminSetting::where('setting_key',$key)->first();

                        $setting_id = (isset($is_exists['id']) && !empty($is_exists['id'])) ? $is_exists['id'] : '';



                        if(!empty($setting_id) || $setting_id != ''){

                            $update_settings = AdminSetting::find($setting_id);

                            $update_settings->value = $setting;

                            $update_settings->update();

                        }else{

                            $new_settings = new AdminSetting();

                            $new_settings->setting_key = $key;

                            $new_settings->value = $setting;

                            $new_settings->save();

                        }

                    }

                }

                return redirect()->route('settings.index')->with('success', 'Settings has been Updated.');

            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }

        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }

    }

    public function GetCategoryReadyToDispatch(Request $request)
    {
        // Initialize curl
        $curl = curl_init();

        // Set the POST URL
        $url = 'https://api.indianjewelcast.com/api/Tag/GetFilters';

        $request = [
            "DeviceID" => 0,
            "SortBy" => "",
            "SearchText" => "",
            "TranType" => "",
            "CatalogType" => "",
            "CommaSeperate_ItemGroupID" => "",
            "CommaSeperate_ItemID" => "",
            "CommaSeperate_StyleID" => "",
            "CommaSeperate_ProductID" => "",
            "CommaSeperate_SubItemID" => "",
            "CommaSeperate_AppItemCategoryID" => "",
            "CommaSeperate_ItemSubID" => "",
            "CommaSeperate_KarigarID" => "",
            "CommaSeperate_BranchID" => "",
            "CommaSeperate_Size" => "",
            "CommaSeperate_CounterID" => "",
            "MaxNetWt" => "",
            "MinNetWt" => "",
            "OnlyCartItem" => false,
            "OnlyWishlistItem" => false,
            "StockStatus" => "",
            "FilterType" => "",
            "DoNotShowInClientApp" => "",
            "HasTagImage" => ""
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

        $data = json_decode($response);
        return $data->Filters->ItemGroups;
    }

    // ready to dispatch price calculator
    function PriceCalcReadyToDispatch(Request $request)
    {
        if(Auth::guard('admin')->user()->can('price_calculate.make_by_order_ready_to_dispatch')){
            $settings = getAdminSettings();
            $categories = $this->GetCategoryReadyToDispatch($request);
            return view("admin.settings.price_calculate.make_by_order_ready_to_dispatch",compact(['settings', 'categories']));

        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }

    }

    function updatePriceCalcReadyToDispatch(Request $request)
    {
        try{
            $settings = $request->settings;
            $settings['sales_wastage_rtd'] = (isset($settings['sales_wastage_rtd'])) ? serialize($settings['sales_wastage_rtd']) : '';
            $settings['sales_wastage_discount_rtd'] = (isset($settings['sales_wastage_discount_rtd'])) ? serialize($settings['sales_wastage_discount_rtd']) : '';
            $categoryNames = $request->category_name;
            $categoryId = $request->category_id;

            if(Auth::guard('admin')->user()->can('price-calculator.update-ready-to-dispatch')){
                foreach ($categoryId as $index => $id) {
                    $category_exist = ReadyCategory::where('category_id', $id)->first();
                    if (!empty($category_exist)) {
                        $category_exist->category_name = $categoryNames[$index];
                        $category_exist->update();
                    } else {
                        $new_category = new ReadyCategory();
                        $new_category->category_name = $categoryNames[$index];
                        $new_category->category_id = $id;
                        $new_category->save();
                    }
                }
                if(count($settings) > 0){
                    foreach ($settings as $key => $setting){

                        $is_exists = AdminSetting::where('setting_key',$key)->first();
                        $setting_id = (isset($is_exists['id']) && !empty($is_exists['id'])) ? $is_exists['id'] : '';

                        if(!empty($setting_id) || $setting_id != ''){
                            $update_settings = AdminSetting::find($setting_id);
                            $update_settings->value = $setting;
                            $update_settings->update();
                        }else{
                            $new_settings = new AdminSetting();
                            $new_settings->setting_key = $key;
                            $new_settings->value = $setting;
                            $new_settings->save();
                        }

                }

                return redirect()->route('price_calculate.make_by_order_ready_to_dispatch')->with('success', 'Ready To Dispatch price has been Updated.');
            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }
        }
        }catch (\Throwable $th){
            dd($th);
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }
}
