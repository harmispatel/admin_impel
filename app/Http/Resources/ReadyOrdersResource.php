<?php



namespace App\Http\Resources;



use Illuminate\Http\Resources\Json\JsonResource;



class ReadyOrdersResource extends JsonResource

{

    /**

     * Transform the resource into an array.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable

     */

    public function toArray($request)
    {
        $orders_arr = isset($this->resource) ? $this->resource : [];
        $orders = [];

        if(isset($orders_arr) && count($orders_arr) > 0){

            foreach($orders_arr as $order){
                $order_details['order_id'] = (isset($order['id'])) ? $order['id'] : '';
                $order_details['dealer'] = (isset($order->dealer['name'])) ? $order->dealer['name'] : '';
                $order_details['dealer_code'] = (isset($order['dealer_code'])) ? $order['dealer_code'] : '';
                $order_details['dealer_discount_type'] = (isset($order['dealer_discount_type'])) ? $order['dealer_discount_type'] : '';
                $order_details['dealer_discount_value'] = (isset($order['dealer_discount_value'])) ? $order['dealer_discount_value'] : '';
                $order_details['dealer_commission'] = (isset($order['dealer_commission'])) ? $order['dealer_commission'] : '';
                $order_details['commission_status'] = (isset($order['commission_status'])) ? $order['commission_status'] : '';
                $order_details['order_status'] = (isset($order['order_status'])) ? $order['order_status'] : '';
                $order_details['customer'] = (isset($order['name'])) ? $order['name'] : '';
                $order_details['customer_email'] = (isset($order['email'])) ? $order['email'] : '';
                $order_details['customer_phone'] = (isset($order['phone'])) ? $order['phone'] : '';
                $order_details['address'] = (isset($order['address'])) ? $order['address'] : '';
                $order_details['city'] = (isset($order->City['name'])) ? $order->City['name'] : '';
                $order_details['state'] = (isset($order->State['name'])) ? $order->State['name'] : '';
                $order_details['pincode'] = (isset($order['pincode'])) ? $order['pincode'] : '';
                $order_details['gold_price'] = (isset($order['gold_price'])) ? $order['gold_price'] : '';
                $order_details['sub_total'] = (isset($order['sub_total'])) ? $order['sub_total'] : '';
                $order_details['total'] = (isset($order['total'])) ? $order['total'] : '';
                $order_details['order_date'] = (isset($order['created_at'])) ? date('d-m-Y', strtotime($order['created_at'])) : '';
                $order_details['order_time'] = (isset($order['created_at'])) ? date('h:i:s a', strtotime($order['created_at'])) : '';
                $orders[] = $order_details;
            }
        }
        return $orders;
    }
}
