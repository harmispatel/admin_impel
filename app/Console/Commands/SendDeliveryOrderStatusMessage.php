<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\ReadyOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SendDeliveryOrderStatusMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:send-message-for-order-status-complate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Message For Order Status Complate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $this->DeliveryTrack();
    }

    public function DeliveryTrack()
    {
        try {
            $curl = curl_init();
           
            $token = seqaulCredentials()['sequel_api_token'];

            $url = seqaulCredentials()['sequel_api_url'] . '/api/track';

            $order_details = Order::where('order_status','completed')->where('deliverd_status',0)->get();

            $ready_order_details = ReadyOrder::where('order_status','completed')->where('deliverd_status',0)->get();

            $all_order_details = $order_details->merge($ready_order_details);
          
            if(!empty($all_order_details)){
                foreach ($all_order_details as $order_detail) {
                   
                    if(!empty($order_detail->docate_number)){
                    
                        $data = [
                            "token" => $token,
                            "docket" => $order_detail->docate_number
                        ];
                
                        $data = json_encode($data);
                        curl_setopt_array($curl,[
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $data,
                            CURLOPT_HTTPHEADER => [
                                'Content-Type: application/json',
                            ],
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_CONNECTTIMEOUT => 10
                        ]);
                        
                        $response = curl_exec($curl);
                       
                        if(curl_errno($curl)){
                            $error = curl_errno($curl);
                            curl_close($curl);
                            return $error;
                        }
                        curl_close($curl);
                
                        $responseData = json_decode($response);
                      
                        $email = $order_detail->email;
                        $order_id = $order_detail->id;
                        $order_number = $order_detail->order_number;
                        $formattedDateTime = $responseData->data->tracking[0]->date_time;
                        $status = $responseData->data->tracking[0]->code;
                        $phone = $order_detail->phone;

                        $time_date = date('F j, Y, g:i A', strtotime($formattedDateTime));
                
                        $this->SendOrderTrackMessage($order_number,$order_id,$phone,$email,$time_date,$status,$order_detail);
                        
                        //$order_detail->update(['deliverd_status' => 1]);
    
                        return $response;
                    }
                }
            }

            $this->info('Order Delivered Check SuccessFully.');

        } catch (\Exception $e) {
            return response()->json([
                'message'=> $e->getMessage(),
            ]);
        }
    }

    public function SendOrderTrackMessage($order_number,$order_id,$phone,$email,$time_date,$status,$order_detail)
    {
        
        if ($status == 'SDELVD') 
        {   
            $text = "Dear customer your Order no - {$order_number}. Delivered at {$time_date}. See you soon again. - From-IMPEL";
          
            $dlttemplateid = 1707173132372429334;
            $subject = "Order Delivered Confirmation";
                
            $curl = curl_init();
            $APIKey = 'q9o165ctikCFWUQWnqLBww';
            $senderid = 'IMPELE';
            $channel = 2;
            $DCS = 0;
            $flashsms = 0;
            $route = 31;
            $EntityId = 1701172630214402951;
            // Set the POST URL
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS';

            // Set the query parameters
            $queryParams = http_build_query([
                'APIKey' => $APIKey,
                'senderid' => $senderid,
                'channel' => $channel,
                'DCS' => $DCS,
                'flashsms' => $flashsms,
                'number' => $phone,
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
            
             if (isset($responseData['ErrorCode']) && $responseData['ErrorCode'] === '000') 
             {
                $order_detail->update(['deliverd_status' => 1]);

                try {
            
                    Mail::send('mail.complated_order',['title' => $text],function ($message) use ($email,$subject) {
                        $message->from(env('MAIL_USERNAME'));
                        $message->to($email);
                        $message->subject($subject);
                    });
                } catch (\Throwable $th) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Mail Not Send!',
                    ]);
                }
            }
        }
    }
}
