<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    // Function for Get Cities By State ID
    function getStatesCities(Request $request)
    {
        try {
            $state_id = $request->state_id;
            $html = '<option value="">Choose City</option>';

            $cities = City::where('state_id',$state_id)->get();
            if(count($cities) > 0){
                foreach($cities as $city){
                    $html .= '<option value="'.$city['id'].'">'.$city['name'].'</option>';
                }
            }

            return response()->json([
                'success' => 1,
                'message' => 'Cities has been retrived successfully..',
                'cities' => $html,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => 'Something went wrong!',
            ]);
        }
    }
}
