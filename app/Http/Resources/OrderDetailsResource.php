<?php



namespace App\Http\Resources;



use Illuminate\Http\Resources\Json\JsonResource;



class OrderDetailsResource extends JsonResource

{

    /**

     * Transform the resource into an array.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable

     */

    public function toArray($request)

    {

        $order = isset($this->resource) ? $this->resource : [];



        $order_details['order_id'] = (isset($order['id'])) ? $order['id'] : '';

        $order_details['dealer'] = (isset($order->dealer['name'])) ? $order->dealer['name'] : '';

        $order_details['order_status'] = (isset($order['order_status'])) ? $order['order_status'] : '';

        $order_details['customer'] = (isset($order['name'])) ? $order['name'] : '';

        $order_details['customer_email'] = (isset($order['email'])) ? $order['email'] : '';

        $order_details['customer_phone'] = (isset($order['phone'])) ? $order['phone'] : '';

        $order_details['address'] = (isset($order['address'])) ? $order['address'] : '';

        $order_details['city'] = (isset($order->City['name'])) ? $order->City['name'] : '';

        $order_details['state'] = (isset($order->State['name'])) ? $order->State['name'] : '';

        $order_details['pincode'] = (isset($order['pincode'])) ? $order['pincode'] : '';

        $order_details['dealer_code'] = (isset($order['dealer_code'])) ? $order['dealer_code'] : '';

        $order_details['dealer_discount_type'] = (isset($order['dealer_discount_type'])) ? $order['dealer_discount_type'] : '';

        $order_details['dealer_discount_value'] = (isset($order['dealer_discount_value'])) ? $order['dealer_discount_value'] : '';

        $order_details['gold_price'] = (isset($order['gold_price'])) ? $order['gold_price'] : '';

        $order_details['sub_total'] = (isset($order['sub_total'])) ? $order['sub_total'] : '';

        $order_details['charges'] = (isset($order['charges'])) ? $order['charges'] : '';

        $order_details['total'] = (isset($order['total'])) ? $order['total'] : '';

        $order_details['order_date'] = (isset($order['created_at'])) ? date('d-m-Y', strtotime($order['created_at'])) : '';

        $order_details['order_time'] = (isset($order['created_at'])) ? date('h:i:s a', strtotime($order['created_at'])) : '';
        $order_details['docate_number'] = (isset($order['docate_number'])) ? $order['docate_number'] : '';
        $order_details['order_type'] = "make_by_order";


        $order_items = [];

        if(isset($order['order_items']) && count($order['order_items']) > 0){

            foreach($order['order_items'] as $order_item){



                $design_code = isset($order_item->design['code']) ? $order_item->design['code'] : '';



                $item['design_id'] = $order_item['design_id'];

                $item['design_code'] = $design_code;

                $item['design_name'] = $order_item['design_name'];

                $item['design_image'] = (isset($order_item->design['image']) && !empty($order_item->design['image']) && file_exists('public/images/uploads/item_images/'.$design_code.'/'.$order_item->design['image'])) ?  asset('public/images/uploads/item_images/'.$design_code.'/'.$order_item->design['image']) : asset('public/images/default_images/not-found/no_img1.jpg');

                $item['quantity'] = $order_item['quantity'];

                $item['gold_type'] = $order_item['gold_type'];

                $item['gold_color'] = $order_item['gold_color'];

                $item['gross_weight'] = $order_item['gross_weight'];

                $item['net_weight'] = $order_item['net_weight'];

                $item['less_gems_stone'] = $order_item['less_gems_stone'];

                $item['less_cz_stone'] = $order_item['less_cz_stone'];

                $item['less_gems_stone_price'] = $order_item['less_gems_stone_price'];

                $item['less_cz_stone_price'] = $order_item['less_cz_stone_price'];

                $item['item_sub_total'] = $order_item['item_sub_total'];

                $item['percentage'] = $order_item['percentage'];

                $item['item_total'] = $order_item['item_total'];



                $order_items[] = $item;

            }

        }

        $order_details['order_items'] = $order_items;



        return $order_details;

    }

}

