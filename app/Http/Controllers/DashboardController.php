<?php



namespace App\Http\Controllers;



use App\Models\{Admin, Design, Category, Order, Page, ReadyOrder, Tag, User};



class DashboardController extends Controller

{

    public function index()

    {

        // Categories Count

        $data['active_categories'] = Category::where('status',1)->count();

        $data['inactive_categories'] = Category::where('status',0)->count();



        // Tags Count

        $data['active_tags'] = Tag::where('status',1)->count();

        $data['inactive_tags'] = Tag::where('status',0)->count();



        // Designs Count

        $data['active_designs'] = Design::where('status',1)->count();

        $data['inactive_designs'] = Design::where('status',0)->count();



        // Users Count

        $data['active_users'] = Admin::where('status',1)->count();

        $data['inactive_users'] = Admin::where('status',0)->count();



        // Dealers Count

        $data['active_dealers'] = User::where('user_type', 1)->where('status',1)->count();

        $data['inactive_dealers'] = User::where('user_type', 1)->where('status',0)->count();



        // Customers Count

        $data['active_customers'] = User::where('user_type', 2)->where('status',1)->count();

        $data['inactive_customers'] = User::where('user_type', 2)->where('status',0)->count();



        // Pages Count

        $data['pages_count'] = Page::count();



        // Orders Count
        $data['pending_orders'] = Order::where('order_status', 'pending')->count();
        $data['completed_orders'] = Order::where('order_status', 'completed')->count();
        $data['pending_orders_datas'] = Order::where('order_status', 'pending')->orderBy('created_at', 'DESC')->get();


        // Ready To Dispatch
        // $data['pending_ready_orders'] = ReadyOrder::where('order_status','pending')->count();
        // $data['completed_ready_orders'] = ReadyOrder::where('order_status','completed')->count();
        // $data['pending_ready_orders_datas'] = ReadyOrder::where('order_status','pending')->orderBy('created_at','DESC')->get();

        return view('admin.dashboard', $data);

    }

}

