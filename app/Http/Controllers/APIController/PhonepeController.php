<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};
use GuzzleHttp\Client;
use Str;

class PhonepeController extends Controller
{
    public function phonepePayment(Request $request)
    {
        try {

            $admin_settings = getAdminSettings();
            $phonepe_live = (isset($admin_settings['phonepe_live']) && !empty($admin_settings['phonepe_live'])) ? $admin_settings['phonepe_live'] : 0;
            if($phonepe_live == 1){
                $phonepe_cred['merchant_id'] = (isset($admin_settings['phonepe_live_merchant_id'])) ? $admin_settings['phonepe_live_merchant_id'] : '';
                $phonepe_cred['salt_key'] = (isset($admin_settings['phonepe_live_salt_key'])) ? $admin_settings['phonepe_live_salt_key'] : '';
                $phonepe_cred['phonepe_url'] = 'https://api.phonepe.com/apis/hermes/pg/v1/pay';
            }else{
                $phonepe_cred['merchant_id'] = (isset($admin_settings['phonepe_sandbox_merchant_id'])) ? $admin_settings['phonepe_sandbox_merchant_id'] : '';
                $phonepe_cred['salt_key'] = (isset($admin_settings['phonepe_sandbox_salt_key'])) ? $admin_settings['phonepe_sandbox_salt_key'] : '';
                $phonepe_cred['phonepe_url'] = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay';
            }

            if(!isset($request->total_amount) || $request->total_amount <= 0){
                return $this->sendResponse(false, 'Cart amount is not valid!');
            }elseif(!isset($request->user_id) && empty($request->user_id)){
                return $this->sendResponse(false, 'User not Found!');
            }else{

                $user = User::find($request->user_id);
                $name = $user->name ?? "";
                $email = $user->email ?? "";
                $phone = $user->phone ?? "";
                $amount = $request->total_amount ?? 0;
                $transactionID = strtoupper(Str::random(15)).$user->id;
                $saltIndex = 1;

                if(isset($user->id)){

                    if(!empty($phonepe_cred['merchant_id']) && !empty($phonepe_cred['salt_key']) && !empty($phonepe_cred['phonepe_url'])){

                        if($request->ready_order == 1){
                            $phonepe_data = [
                                'merchantId' => $phonepe_cred['merchant_id'],
                                'merchantTransactionId' => $transactionID,
                                'merchantUserId' => 'IMPMUID-'.$user->id,
                                'amount' => $amount * 100,
                                'redirectUrl' => 'https://impel.store/ready-processing-order?transaction_id='.$transactionID,
                                'callbackUrl' => url('api/phonepe/payment/callback?transaction_id='.$transactionID),
                                'redirectMode' => 'GET',
                                'mobileNumber' => $phone,
                                'paymentInstrument' => [
                                    'type' => 'PAY_PAGE',
                                ],
                            ];
                        }else{
                            $phonepe_data = [
                                'merchantId' => $phonepe_cred['merchant_id'],
                                'merchantTransactionId' => $transactionID,
                                'merchantUserId' => 'IMPMUID-'.$user->id,
                                'amount' => $amount * 100,
                                'redirectUrl' => 'https://impel.store/processing-order?transaction_id='.$transactionID,
                                'callbackUrl' => url('api/phonepe/payment/callback?transaction_id='.$transactionID),
                                'redirectMode' => 'GET',
                                'mobileNumber' => $phone,
                                'paymentInstrument' => [
                                    'type' => 'PAY_PAGE',
                                ],
                            ];
                        }


                        $encode_data = base64_encode(json_encode($phonepe_data));
                        $string_data = $encode_data.'/pg/v1/pay'.$phonepe_cred['salt_key'];
                        $sha256_data = hash('sha256', $string_data);
                        $finalXHeader = $sha256_data.'###'.$saltIndex;

                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $phonepe_cred['phonepe_url'],
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => false,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode(['request' => $encode_data]),
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json',
                                'X-VERIFY: '.$finalXHeader
                            ),
                        ));

                        $response = curl_exec($curl);
                        curl_close($curl);

                        $response_data = json_decode($response);

                        if(isset($response_data->success) && $response_data->success == 1){
                            return $this->sendResponse(true, $response_data->message, $response_data->data ?? []);
                        }else{
                            return $this->sendResponse(false, $response_data->message);
                        }

                    }else{
                        return $this->sendResponse(false, 'Oops, Credential Not Found!');
                    }
                }else{
                    return $this->sendResponse(false, 'User not Found!');
                }
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(false, 'Oops, Something went wrong!');
        }
    }

    public function phonepePaymentCallback(Request $request){

        $transactionID = $request->transaction_id;
        $admin_settings = getAdminSettings();
        $phonepe_live = (isset($admin_settings['phonepe_live']) && !empty($admin_settings['phonepe_live'])) ? $admin_settings['phonepe_live'] : 0;
        if($phonepe_live == 1){
            $phonepe_cred['merchant_id'] = (isset($admin_settings['phonepe_live_merchant_id'])) ? $admin_settings['phonepe_live_merchant_id'] : '';
            $phonepe_cred['salt_key'] = (isset($admin_settings['phonepe_live_salt_key'])) ? $admin_settings['phonepe_live_salt_key'] : '';
        }else{
            $phonepe_cred['merchant_id'] = (isset($admin_settings['phonepe_sandbox_merchant_id'])) ? $admin_settings['phonepe_sandbox_merchant_id'] : '';
            $phonepe_cred['salt_key'] = (isset($admin_settings['phonepe_sandbox_salt_key'])) ? $admin_settings['phonepe_sandbox_salt_key'] : '';
        }

        $saltKey = $phonepe_cred['salt_key'];
        $saltIndex = 1;
        $finalXHeader = hash('sha256','/pg/v1/status/'.$phonepe_cred['merchant_id'].'/'.$transactionID.''.$saltKey).'###'.$saltIndex;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/status/'.$phonepe_cred['merchant_id'].'/'.$transactionID.'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'accept: application/json',
                'X-VERIFY: '.$finalXHeader,
                'X-MERCHANT-ID: '.$transactionID
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }



    // public function phonePayPayment(Request $request)
    // {
    //     try {
    //         $admin_settings = getAdminSettings();
    //         $phonepe_live = (isset($admin_settings['phonepe_live'])) && !empty($admin_settings['phonepe_live']) ? $admin_settings['phonepe_live'] : 0;
    //         if($phonepe_live == 1){
    //             $phonepe_cred['merchant_id'] = isset($admin_settings['phonepe_live_merchant_id']) ? $admin_settings['phonepe_live_merchant_id'] : '';
    //             $phonepe_cred['salt_key'] = isset($admin_settings['phonepe_live_salt_key']) ? $admin_settings['phonepe_live_salt_key'] : '';
    //             $phonepe_cred['phonepe_url'] = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay';
    //         }else{
    //             $phonepe_cred['merchnant_id'] = isset($admin_settings['phonepe_sandbox_merchant_id']) ? $admin_settings['phonepe_sandbox_merchant_id'] : '';
    //             $phonepe_cred['salt_key'] = isset($admin_settings['phonepe_sandbox_salt_key']) ? $admin_settings['phonepe_sandbox_salt_key'] : '';
    //             $phonepe_cred['phonepe_url'] = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay';
    //         }

    //         if(!isset($request->total_amount) || $request->total_amount <= 0){
    //             return $this->sendResponse(false, 'Please Enter Valid Amount!');
    //         }elseif(!isset($request->user_id) && empty($request->user_id)){
    //             return $this->sendResponse(false, 'User ID is required!');
    //         }else{
    //             $user_id = $request->user_id;
    //             $user = User::find($user_id);
    //             $name = $user->name ?? "";
    //             $email = $user->email ?? "";
    //             $phone = $user->phone ?? "";
    //             $amount = $request->total_amount;
    //             $transactionID = strtoupper(Str::random(15)).$user->id;
    //             $saltIndex = 1;

    //             if(isset($user->id)){
    //                 if(!empty($phonepe_cred['merchant_id'] && !empty($phonepe_cred['salt_key']) && !empty($phonepe_cred['phonepe_url']))){
    //                     $phonepe_data = [
    //                         'merchantId' => $phonepe_cred['merchant_id'],
    //                         'merchantTransactionId' => $transactionID,
    //                         'merchantUserId' => 'IMPMUID-'.$user->id,
    //                         'amount' => $amount * 100,
    //                         'redirectUrl' => 'https://impel.store/processing-order?transaction_id='.$transactionID,
    //                         'callbackUrl' => url('api/phonepe/payment/callback?transaction_id='.$transactionID),
    //                         'redirectMode' => 'GET',
    //                         'mobileNumber' => $phone,
    //                         'paymentInstrument' => [
    //                             'type' => 'PAY_PAGE',
    //                         ],

    //                     ];

    //                     $encode_data = base64_encode(json_encode($phonepe_data));
    //                     $string_data = $encode_data.'/pg/v1/pay'.$phonepe_cred['salt_key'];
    //                     $sha256_data = hash('sha256', $string_data);
    //                     $finalXHeader = $sha256_data.'###'.$saltIndex;

    //                     $curl = curl_init();
    //                     curl_setopt_array($curl, array(
    //                         CURLOPT_URL => $phonepe_cred['phonepe_url'],
    //                         CURLOPT_RETURNTRANSFER => true,
    //                         CURLOPT_ENCODING => '',
    //                         CURLOPT_MAXREDIRS => 10,
    //                         CURLOPT_TIMEOUT => 0,
    //                         CURLOPT_FOLLOWLOCATION => false,
    //                         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                         CURLOPT_CUSTOMREQUEST => 'POST',
    //                         CURLOPT_POSTFIELDS => json_encode(['request' => $encode_data]),
    //                         CURLOPT_HTTPHEADER => array(
    //                             'Content-Type: application/json',
    //                             'X-VERIFY: '.$finalXHeader
    //                         ),
    //                     ));

    //                     $response = curl_exec($curl);
    //                     curl_close($curl);
    //                     $response_data = json_decode($response);
    //                     if(isset($response_data->success) && $response_data->success == 1){
    //                         return $this->sendResponse(true, $response_data->message, $response_data->data ?? []);
    //                     }else{
    //                         return $this->sendResponse(false, $response_data->message);
    //                     }
    //                 }
    //             }else{
    //                 return $this->sendResponse(false, 'User not found!');
    //             }
    //         }

    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return $this->sendResponse(false, 'Oops, Something went wrong!');
    //     }
    // }
}
