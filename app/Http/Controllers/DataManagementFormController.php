<?php

namespace App\Http\Controllers;

use App\Models\surveyData;
use App\Models\surveyForm;
use App\Models\surveyOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DataManagementFormController extends Controller
{
    public function index()
    {
        $id = 1;
        $data = surveyData::findOrFail($id);
        return view('admin.managementform.manageform',compact('data'));
    }

    public function SendOtp(Request $request)
    {
        try {
            $request->validate([
                'number' => 'required'
            ]);
            
            $curl = curl_init();
            $number = $request->number;
            $otp = rand(100000, 999999); 
            $APIKey = 'q9o165ctikCFWUQWnqLBww';
            $senderid = 'IMPELE';
            $channel = 2;
            $DCS = 0;
            $flashsms = 0;
            $text = "Welcome to Impel, {$otp} is your OTP Please Verify.";
            $route = 31;
            $EntityId = 1701172630214402951;
            $dlttemplateid = 1707173856837408268;
    
            // Set the POST URL
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS';
    
            // Set the query parameters
            $queryParams = http_build_query([
                'APIKey' => $APIKey,
                'senderid' => $senderid,
                'channel' => $channel,
                'DCS' => $DCS,
                'flashsms' => $flashsms,
                'number' => $number,
                'text' => $text,
                'route' => $route,
                'EntityId' => $EntityId,
                'dlttemplateid' => $dlttemplateid
            ]);
    
            // Set curl options
            curl_setopt_array($curl, [
                CURLOPT_URL => $url.'?' . $queryParams,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CONNECTTIMEOUT => 10,
            ]);
    
            // Execute the request
            $response = curl_exec($curl);
    
            // Check for errors
            if (curl_errno($curl)) {
                $error = curl_error($curl);
                curl_close($curl);
                return response()->json(['error' => $error], 500);
            }
    
            // Close cURL
            curl_close($curl);
            $responseData = json_decode($response, true);
    
            if (isset($responseData['ErrorCode']) && $responseData['ErrorCode'] === '000') {
               $now = now();
               
                $user = surveyOtp::where('number',$number)->first();
                if(!empty($user)){
                    $user->delete();
                }
    
                surveyOtp::create([
                    'number' => $number,
                    'otp' => $otp,
                    'expire_at' => $now->addMinutes(3),
                ]);
            }
    
            return response()->json([
                'success' => 1,
                'message' => "Otp Send Successfully"
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Otp not"
            ]);
        }

        
    }

    public function survayWithOtp(Request $request)
    {   
        $request->validate([
            'otp' => 'required'
        ]);

        $survayOtp = surveyOtp::where('number',$request->number)->where('otp',$request->otp)->first();

        $now = now();
        if (!$survayOtp) {
            return response()->json([
                'success' => 0,
                'message' => "Your OTP is not correct"
            ]);
        }else if($survayOtp && $now->isAfter($survayOtp->expire_at)){
            return response()->json([
                'success' => 0,
                'message' => "Your OTP has been expired"
            ]);
        }

        return response()->json([
            'success' => 1,
            'message' => "Otp Verifiy Successfully"
        ]);
    }

    public function offerMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'coupen' => 'required',
            'discount' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $messageData = [
            'APIKey' => 'q9o165ctikCFWUQWnqLBww',
            'senderid' => 'IMPELE',
            'channel' => 2,
            'DCS' => 0,
            'flashsms' => 0,
            'number' => $request->number,
            'text' => "Celebrate Vasant Panchami with Us! Enjoy {$request->discount} OFF Making charges on our elegant and exclusive Gold and silver jewellery collections. Use code {$request->coupen} at checkout. Valid only on 2nd Feb. Hurry, shop now at https://impel.store Team Impel Jewelry",
            'route' => 31,
            'EntityId' => 1701172630214402951,
            'dlttemplateid' => 1707173815232941357,
        ];

        return $this->sendSms($messageData);
    }

    public function connectMessage(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'link' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $messageData = [
            'APIKey' => 'q9o165ctikCFWUQWnqLBww',
            'senderid' => 'IMPELE',
            'channel' => 2,
            'DCS' => 0,
            'flashsms' => 0,
            'number' => $request->number,
            'text' => "Stay Connected with Impel Jewelry! Follow us on Instagram for the latest updates, designs, and exclusive offers. Click here: {$request->link} Let’s shine together! Team Impel Jewelry",
            'route' => 31,
            'EntityId' => 1701172630214402951,
            'dlttemplateid' => 1707173815110106997,
        ];

        return $this->sendSms($messageData);
    }

    private function sendSms(array $messageData)
    {
        $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS';
        $queryParams = http_build_query($messageData);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url . '?' . $queryParams,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json(['error' => $error], 500);
        }

        curl_close($curl);
        $responseData = json_decode($response, true);

        if (isset($responseData['ErrorCode']) && $responseData['ErrorCode'] === '000') {
            return response()->json([
                'success' => 1,
                'message' => "Message sent successfully."
            ]);
        }

        return response()->json([
            'success' => 0,
            'message' => "Failed to send message."
        ]);
    }

    public function survayForm(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'city' => 'required',
            'state' => 'required',
            'coupen' => 'required',
            'discount' => 'required',
            'link' => 'required',
            'flat_no' => 'required',
            'society' => 'required',
            'area' => 'required'
        ]);
        
        try {
            
            surveyForm::create([
                'name' => $request->name,
                'number' => $request->number,
                'city' => $request->city,
                'state' => $request->state,
                'address' => $request->address,
                'coupen' => $request->coupen,
                'discount' => $request->discount,
                'date' => '2nd Feb',
                'link' => $request->link,
                'flat_no' => $request->flat_no,
                'society' => $request->society,
                'area' => $request->area,
                'send_offer_message' => $request->send_offer_message,
                'send_social_media_message' => $request->send_social_media_message
            ]);

            $input = $request->except('name','number','city','state','address','otp');
            $id = 1;
            $sarvay = surveyData::findOrFail($id);
            if (!empty($sarvay)) {
                $sarvay->update($input);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Store Design SuccessFully'
            ]);

        } catch (\Throwable $th) {
            dd($th);
            return $this->sendApiResponse(false, 0, 'Oops, Something went wrong!', []);
        }
    }

    public function survayData()
    {
        try {
            $data = surveyData::all();
            return $this->sendApiResponse(true, 0, 'Data Fetched.', $data);
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0, 'Oops, Something went wrong!', []);
        }
        
    }

    // public function formList(Request $request){
    //     try {

    //         if ($request->ajax()){

    //             // Get all Admins
    
    //             $survayForms = surveyForm::all();
    
    
    
    //             return DataTables::of($survayForms)
    
    //             ->addIndexColumn()
    
    //             // ->addColumn('name', function ($row){
    
    //             //     return "$row->name";
    
    //             // })
    //             // ->addColumn('number', function ($row){
    
    //             //     return "$row->number";
    
    //             // })
    //             // ->addColumn('city', function ($row){
    
    //             //     return "$row->city";
    
    //             // })
    //             // ->addColumn('state', function ($row){
    
    //             //     return "$row->state";
    
    //             // })
    //             // ->addColumn('coupen', function ($row){
    
    //             //     return "$row->coupen";
    
    //             // })
    //             // ->addColumn('discount', function ($row){
    
    //             //     return "$row->discount";
    
    //             // })
    //             // ->addColumn('date', function ($row){
    
    //             //     return "$row->date";
    
    //             // })
    //             // ->addColumn('link', function ($row){
    
    //             //     return "$row->link";
    
    //             // })
    //             // ->addColumn('flat_no', function ($row){
    
    //             //     return "$row->flat_no";
    
    //             // })
    //             // ->addColumn('society', function ($row){
    
    //             //     return "$row->society";
    
    //             // })
    //             // ->addColumn('area', function ($row){
    
    //             //     return "$row->area";
    
    //             // })
    
    //             ->rawColumns([])
    
    //             ->make(true);
    
    //         }
    //         return view('admin.managementform.form-list');
    //         //code...
    //     } catch (\Throwable $th) {
    //         dd($th);
    //         return redirect()->back()->with('error',"something went wrong!");
    //     }
    // }

    public function formList(Request $request)
    {
        try {
            if ($request->ajax()) {
                $admins = surveyForm::orderBy('id','desc')->get();
                
                return DataTables::of($admins)
                    ->addIndexColumn()
                    ->addColumn('name', function ($row) {
                        return $row->name;
                    })
                    ->addColumn('number', function ($row) {
                        return isset($row->number) ? $row->number : '';
                    })
                    ->addColumn('coupen', function ($row) {
                        return $row->coupen;
                    })
                    ->addColumn('discount', function ($row) {
                        return $row->discount;
                    })
                    ->addColumn('date', function ($row) {
                        return $row->date;
                    })
                    ->addColumn('city', function ($row) {
                        return $row->city;
                    })
                    ->addColumn('state', function ($row) {
                        return $row->state;
                    })
                    ->addColumn('flat_no', function ($row) {
                        return $row->flat_no;
                    })
                    ->addColumn('society', function ($row) {
                        return $row->society;
                    })
                    ->addColumn('area', function ($row) {
                        return $row->area;
                    })
                    ->addColumn('link', function ($row) {
                        return $row->link;
                    })
                    ->rawColumns(['name', 'number', 'coupen', 'city', 'state', 'flat_no', 'society', 'area', 'link'])
                    ->make(true);
            }
            return view('admin.managementform.form-list');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    
}
