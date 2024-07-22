<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\{User,Payment};


class CashfreePaymentController extends Controller
{
    public function doCashFreePayment(Request $request){
        try {

            if(isset($request->total) && !empty($request->total) && isset($request->user_id) && !empty($request->user_id)){
                $userDetails=User::find($request->user_id);
                $name=isset($userDetails->name) ? $userDetails->name : "";
                $phone=isset($userDetails->phone) ? $userDetails->phone : "";
                $email=isset($userDetails->email) ? $userDetails->email : "";

                $url = "https://sandbox.cashfree.com/pg/orders";
                $headers = array(
                    "Content-Type: application/json",
                    "x-api-version: 2022-01-01",
                    "x-client-id: ".env('CASHFREE_API_KEY'),
                    "x-client-secret:".env('CASHFREE_API_SECRET')
                );
                $data = json_encode([
                    'order_id' =>  'order_'.rand(1111111111,9999999999).time(),
                    'order_amount' => $request->total,
                    "order_currency" => "INR",
                    "customer_details" => [
                        "customer_id" => $request->user_id,
                        "customer_name" => $name,
                        "customer_email" => $email,
                        "customer_phone" => $phone,
                    ],
                    "order_meta" => [
                        "return_url" => 'http://192.168.1.87/indianjewel/api/cashfree/payments/success/?order_id={order_id}'
                    ]
                ]);
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                $resp = curl_exec($curl);
                curl_close($curl);
                $paymentLink=json_decode($resp['payment_link']);
                return $this->sendResponse(true, 'Payment redirect Link',$paymentLink);
            }
            else{
                return $this->sendResponse(false, 'Amount and user Id  is required');
            }

        } catch (\Throwable $th) {
            dd($th);
            return $this->sendApiResponse(false, 0, 'Oops, Something went wrong!', (object)[]);
        }
    }
    // PAYMENT STATUS RESPONSE
    public function success(Request $request)
    {
        try {

            $sandboxUrl="https://sandbox.cashfree.com/pg/orders/".$request->order_id;
            //$liveUrl="https://api.cashfree.com/pg/orders/".$request->order_id;
            $headers = array(
                "Content-Type: application/json",
                "x-api-version: 2022-01-01",
                "x-client-id: ".env('CASHFREE_API_KEY'),
                "x-client-secret:".env('CASHFREE_API_SECRET')
            );
            $curl = curl_init($sandboxUrl);
            curl_setopt($curl, CURLOPT_URL, $sandboxUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $resp = curl_exec($curl);
            curl_close($curl);
            $result=json_decode($resp);
            if($result->order_status =='PAID'){

                $input['status']=$result->order_status;
                $input['name']=$result->customer_details->customer_name;
                $input['email']=$result->customer_details->customer_email;
                $input['phone']=$result->customer_details->customer_phone;
                $input['user_id']=$result->customer_details->customer_id;
                $input['amount']=$result->order_amount;
                $input['currency']=$result->order_currency;
                $input['payment_order_id']=$result->order_id;
                $input['payment_method']='cashFree';
                $input['payment_type']='online';
                Payment::insert($input);
                return redirect()->away('http://192.168.1.19:3000/order-details/'.$request->order_id);
                //return $this->sendResponse(true, 'Payment Successfully Done');
            }
            else{
                return $this->sendResponse(false, 'Payment Failed');
            }

        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0, 'Oops, Something went wrong!', (object)[]);
        }

    }
}
