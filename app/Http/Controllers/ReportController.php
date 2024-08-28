<?php



namespace App\Http\Controllers;



use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Models\{DealerCollection, Design, Order, ReadyOrder, User};



class ReportController extends Controller

{

    public function summaryReport()
    {
        return view('admin.reports.summary_report');
    }

    public function starReport()
    {
        return view('admin.reports.star_report');
    }

    public function loadStarReport(Request $request)
    {

        if ($request->ajax()){



            $limit = $request->request->get('length');

            $start = $request->request->get('start');

            $search = $request->input('search.value');



            $designes = Design::withCount(['dealer_collections']);



            if (!empty($search)) {

                $designes->where(function ($query) use ($search) {

                    $query->where('code', 'LIKE', "%{$search}%")

                    ->orWhere('name', 'LIKE', "%{$search}%");

                });

            }



            // Filter designs with dealer_collections_count greater than 0

            $designes = $designes->get()->filter(function ($design) {

                return $design->dealer_collections_count > 0;

            });



            // Order designs by dealer_collections_count in descending order

            $designes = $designes->sortByDesc('dealer_collections_count')->values();



            $totalData = clone $designes;

            $totalFiltered = $totalData->count();

            $totalData = $totalData->count();



            // Apply offset and limit after filtering

            $designes = $designes->slice($start)->take($limit);



            $all_items = [];



            if(count($designes) > 0){

                $srno = 1;

                foreach($designes as $design){

                    $item = [

                        'id' => $srno,

                        'code' => $design->code ?? '',

                        'name' => $design->name ?? '',

                        'stars' => "<strong>$design->dealer_collections_count</strong>" ?? 0,

                        'actions' => '<a href="'.route('reports.star.details', $design->id).'" class="btn btn-sm btn-primary"><i class="fa-solid fa-info-circle"></i></a>',

                    ];



                    $all_items[] = $item;

                    $srno++;

                }

            }



            return response()->json([

                "draw"            => intval($request->request->get('draw')),

                "recordsTotal"    => intval($totalData),

                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),

                "data"            => $all_items

            ]);

        }

    }

    public function starReportDetails($id)
    {

        try {

            $design = Design::where('id', $id)->first();

            return view('admin.reports.star_report_details', compact(['design']));

        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Oops, Something went wrong!');

        }

    }

    public function loadStarReportDetails(Request $request)
    {

        if ($request->ajax()){



            $limit = $request->request->get('length');

            $start = $request->request->get('start');

            $search = $request->input('search.value');

            $design_id = $request->design_id;

            $dealer_collections = DealerCollection::with(['dealer'])->where('design_id', $design_id);



            if (!empty($search)) {

                $dealer_collections->whereHas('dealer',function ($query) use ($search) {

                    $query->where('dealer_code', 'LIKE', "%{$search}%")

                    ->orWhere('name', 'LIKE', "%{$search}%")

                    ->orWhere('phone', 'LIKE', "%{$search}%")

                    ->orWhereHas('company_city', function ($subquery) use ($search) {

                        $subquery->where('name', 'LIKE', "%{$search}%");

                    });

                });

            }



            $totalData = clone $dealer_collections;

            $totalFiltered = $totalData->count();

            $totalData = $totalData->count();

            $dealer_collections = $dealer_collections->offset($start)->limit($limit)->latest()->get();



            $all_items = [];



            if(count($dealer_collections) > 0){

                $srno = 1;

                foreach($dealer_collections as $dealer_collection){

                    $item = [

                        'id' => $srno,

                        'dealer_code' => $dealer_collection->dealer->dealer_code ?? '',

                        'dealer_name' => $dealer_collection->dealer->name ?? '',

                        'dealer_contact' => $dealer_collection->dealer->phone ?? '',

                        'dealer_city' => $dealer_collection->dealer->company_city->name ?? '',

                    ];



                    $all_items[] = $item;

                    $srno++;

                }

            }



            return response()->json([

                "draw"            => intval($request->request->get('draw')),

                "recordsTotal"    => intval($totalData),

                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),

                "data"            => $all_items

            ]);

        }

    }

    public function schemeReport()
    {

        return view('admin.reports.scheme_report');

    }

    public function performanceReport()
    {

        return view('admin.reports.performance_report');

    }

    public function loadPerformanceReport(Request $request)
    {

        if ($request->ajax()){



            $limit = $request->request->get('length');

            $start = $request->request->get('start');

            $search = $request->input('search.value');

            $start_date = $request->start_date;

            $end_date = $request->end_date;



            $dealers = User::where('user_type', 1);



            if (!empty($search)) {

                $dealers->where(function ($query) use ($search) {

                    $query->where('dealer_code', 'LIKE', "%{$search}%")

                        ->orWhere('name', 'LIKE', "%{$search}%")

                        ->orWhere('phone', 'LIKE', "%{$search}%");

                });

            }



            // Apply date range condition

            if (!empty($start_date) && !empty($end_date)) {

                $dealers->whereHas('orders', function ($subquery) use ($start_date, $end_date) {

                    $subquery->whereBetween('created_at', [$start_date, $end_date]);

                });

            }



            $dealers->with('orders');

            $totalData = clone $dealers;

            $totalFiltered = $totalData->count();

            $totalData = $totalData->count();

            $dealers = $dealers->offset($start)->limit($limit)->get();

            $dealers = $dealers->sortByDesc(function ($dealer) {

                return $dealer->orders->where('commission_status', 1)->sum('dealer_commission');

            });



            $all_items = [];



            if(count($dealers) > 0){

                $srno = 1;

                foreach($dealers as $dealer){

                    $complete_commission = $dealer->orders->where('commission_status', 1)->sum('dealer_commission');

                    $pending_commission = $dealer->orders->where('commission_status', 0)->sum('dealer_commission');



                    $item = [

                        'id' => $srno,

                        'code' => $dealer->dealer_code ?? '',

                        'name' => $dealer->name ?? '',

                        'phone' => $dealer->phone ?? '',

                        'complete_commission' => number_format($complete_commission, 2),

                        'pending_commission' => number_format($pending_commission, 2),

                        'actions' => '<a href="'.route('reports.performance.details', $dealer->id).'" class="btn btn-sm btn-primary"><i class="fa-solid fa-info-circle"></i></a>',

                    ];





                    if(isset($dealer->orders) && count($dealer->orders) > 0)

                    {

                        $payable_orders = 0;

                        foreach($dealer->orders as $order){

                            $commission_date = strtotime($order->commission_date);

                            if(!empty($commission_date)){

                                $current_date = Carbon::now();

                                $commission_date = Carbon::parse($order->commission_date);

                                if(strtotime($current_date) > strtotime($commission_date)){

                                    $remaining_days = 0;

                                }else{

                                    $remaining_days = $current_date->diffInDays($commission_date);

                                }



                                if($remaining_days == 0 && $order->commission_status == 0){

                                    $payable_orders += 1;

                                }

                            }

                        }

                    }



                    if($payable_orders > 0){

                        $item['ready_to_pay'] = '<div class="bg-success text-white p-1" style="border-radius: 50%; width: 30px!important; height: 30px!important; text-align: center;">'.$payable_orders.'</div>';

                    }else{

                        $item['ready_to_pay'] = '<div class="bg-danger text-white p-1" style="border-radius: 50%; width: 30px!important; height: 30px!important; text-align: center;">'.$payable_orders.'</div>';

                    }





                    $all_items[] = $item;

                    $srno++;

                }

            }



            return response()->json([

                "draw"            => intval($request->request->get('draw')),

                "recordsTotal"    => intval($totalData),

                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),

                "data"            => $all_items

            ]);

        }

    }

    public function performanceReportDetails($id)
    {

        try {

            $dealer = User::where('id', $id)->where('user_type', 1)->first();

            return view('admin.reports.performance_report_details', compact(['dealer']));

        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Oops, Something went wrong!');

        }

    }


    public function loadPerformanceReportDetails(Request $request)
    {

        if ($request->ajax()){



            $current_date = strtotime(Carbon::now());

            $limit = $request->request->get('length');

            $start = $request->request->get('start');

            $search = $request->input('search.value');

            $start_date = $request->start_date;

            $end_date = $request->end_date;

            $dealer_id = $request->dealer_id;

            $orders = Order::where('dealer_id', $dealer_id);



            if(!empty($start_date) && !empty($end_date)){

                $orders = $orders->whereBetween('created_at', [$start_date, $end_date]);

            }



            if (!empty($search)) {

                $orders->where(function ($query) use ($search) {

                    $query->where('id', 'LIKE', "%{$search}%")

                    ->orWhere('name', 'LIKE', "%{$search}%");

                });

            }



            $totalData = clone $orders;

            $totalFiltered = $totalData->count();

            $totalData = $totalData->count();

            $orders = $orders->offset($start)->limit($limit)->get();



            $all_items = [];



            if(count($orders) > 0){

                $srno = 1;

                foreach($orders as $order){

                    $commission_date = strtotime($order->commission_date);

                    $current_date = Carbon::now();

                    $commission_date = Carbon::parse($order->commission_date);

                    if(strtotime($current_date) > strtotime($commission_date)){

                        $remaining_days = 0;

                    }else{

                        $remaining_days = $current_date->diffInDays($commission_date);

                    }



                    $item = [

                        'id' => $srno,

                        'orderno' => $order->id ?? '',

                        'customer' => $order->name ?? '',

                        'commission_value' => number_format($order->dealer_commission, 2) ?? 0.00,

                    ];



                    if($order->commission_status === 1){

                        $item['commission_status'] = '<span class="badge bg-success">COMPLETED</span>';

                    }else if($order->commission_status === 0){

                        $item['commission_status'] = '<span class="' . ($remaining_days == 0 ? 'text-success' : '') . ' fs-5">' . $remaining_days . ' Days Left.</span>';

                    }else{

                        $item['commission_status'] = ' - ';

                    }



                    $actions = '';



                    if($order->commission_status === 0){

                        if($remaining_days == 0){

                            $actions .= '<a class="btn btn-sm btn-success"  onclick="$(\'#commissionPayModal\').modal(\'show\'); $(\'#pay_order_commission #order_id\').val('.$order->id.')" data-bs-toggle="tooltip" data-bs-placement="top" title="Pay Commission"><i class="fa fa-check-circle"></i></a>';

                        }else{

                            $actions .= '<button class="btn btn-sm btn-success" disabled><i class="fa fa-check-circle"></i></button>';

                        }

                    }elseif($order->commission_status === NULL){

                        $actions .= '<a class="btn btn-sm btn-primary" onclick="$(\'#commissionApplyModal\').modal(\'show\'); $(\'#process_order_commission #order_id\').val('.$order->id.')" data-bs-toggle="tooltip" data-bs-placement="top" title="Issue Commission"><i class="fa fa-check-circle"></i></a>';

                    }





                    $item['actions'] = $actions;

                    $all_items[] = $item;

                    $srno++;

                }

            }



            return response()->json([

                "draw"            => intval($request->request->get('draw')),

                "recordsTotal"    => intval($totalData),

                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),

                "data"            => $all_items

            ]);

        }

    }

    //Ready to dispatch reports

    public function ReadyPerformanceReport()
    {
        return view('admin.reports.ready.performance_report');
    }

    public function ReadyloadPerformanceReport(Request $request)
    {

        if ($request->ajax()){
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $search = $request->input('search.value');
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $dealers = User::where('user_type', 1);

            if (!empty($search)) {
                $dealers->where(function ($query) use ($search) {
                    $query->where('dealer_code', 'LIKE', "%{$search}%")
                        ->orWhere('name', 'LIKE', "%{$search}%")
                        ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            }

            // Apply date range condition
            if (!empty($start_date) && !empty($end_date)) {
                $dealers->whereHas('readyOrders', function ($subquery) use ($start_date, $end_date) {
                    $subquery->whereBetween('created_at', [$start_date, $end_date]);
                });
            }

            $dealers->with('readyOrders');
            $totalData = clone $dealers;
            $totalFiltered = $totalData->count();
            $totalData = $totalData->count();
            $dealers = $dealers->offset($start)->limit($limit)->get();
            $dealers = $dealers->sortByDesc(function ($dealer) {
                return $dealer->readyOrders->where('commission_status', 1)->sum('dealer_commission');
            });

            $all_items = [];
            if(count($dealers) > 0){
                $srno = 1;
                foreach($dealers as $dealer){
                    $complete_commission = $dealer->readyOrders->where('commission_status', 1)->sum('dealer_commission');
                    $pending_commission = $dealer->readyOrders->where('commission_status', 0)->sum('dealer_commission');

                    $item = [
                        'id' => $srno,
                        'code' => $dealer->dealer_code ?? '',
                        'name' => $dealer->name ?? '',
                        'phone' => $dealer->phone ?? '',
                        'complete_commission' => number_format($complete_commission, 2),
                        'pending_commission' => number_format($pending_commission, 2),
                        'actions' => '<a href="'.route('reports.ready.performance.details', $dealer->id).'" class="btn btn-sm btn-primary"><i class="fa-solid fa-info-circle"></i></a>',
                    ];


                    if(isset($dealer->readyOrders) && count($dealer->readyOrders) > 0)
                    {
                        $payable_orders = 0;
                        foreach($dealer->readyOrders as $order){
                            $commission_date = strtotime($order->commission_date);
                            if(!empty($commission_date)){
                                $current_date = Carbon::now();
                                $commission_date = Carbon::parse($order->commission_date);
                                if(strtotime($current_date) > strtotime($commission_date)){
                                    $remaining_days = 0;
                                }else{
                                    $remaining_days = $current_date->diffInDays($commission_date);
                                }

                                if($remaining_days == 0 && $order->commission_status == 0){
                                    $payable_orders += 1;
                                }
                            }
                        }
                    }

                    if($payable_orders > 0){
                        $item['ready_to_pay'] = '<div class="bg-success text-white p-1" style="border-radius: 50%; width: 30px!important; height: 30px!important; text-align: center;">'.$payable_orders.'</div>';
                    }else{
                        $item['ready_to_pay'] = '<div class="bg-danger text-white p-1" style="border-radius: 50%; width: 30px!important; height: 30px!important; text-align: center;">'.$payable_orders.'</div>';
                    }

                    $all_items[] = $item;
                    $srno++;
                }
            }


            return response()->json([
                "draw"            => intval($request->request->get('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
                "data"            => $all_items
            ]);
        }
    }

    public function ReadyperformanceReportDetails($id)
    {

        try {

            $dealer = User::where('id', $id)->where('user_type', 1)->first();
            return view('admin.reports.ready.performance_report_details', compact(['dealer']));

        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Oops, Something went wrong!');

        }

    }

    public function ReadyloadPerformanceReportDetails(Request $request)
    {

        if ($request->ajax()){

            $current_date = strtotime(Carbon::now());
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $search = $request->input('search.value');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $dealer_id = $request->dealer_id;
            $orders = ReadyOrder::where('dealer_id', $dealer_id);

            if(!empty($start_date) && !empty($end_date)){
                $orders = $orders->whereBetween('created_at', [$start_date, $end_date]);
            }

            if (!empty($search)) {
                $orders->where(function ($query) use ($search) {
                    $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%");
                });
            }


            $totalData = clone $orders;
            $totalFiltered = $totalData->count();
            $totalData = $totalData->count();
            $orders = $orders->offset($start)->limit($limit)->get();

            $all_items = [];
            if(count($orders) > 0){

                $srno = 1;
                foreach($orders as $order){
                    $commission_date = strtotime($order->commission_date);
                    $current_date = Carbon::now();
                    $commission_date = Carbon::parse($order->commission_date);

                    if(strtotime($current_date) > strtotime($commission_date)){
                        $remaining_days = 0;
                    }else{
                        $remaining_days = $current_date->diffInDays($commission_date);
                    }

                    $item = [
                        'id' => $srno,
                        'orderno' => $order->id ?? '',
                        'customer' => $order->name ?? '',
                        'commission_value' => number_format($order->dealer_commission, 2) ?? 0.00,
                    ];

                    if($order->commission_status === 1){
                        $item['commission_status'] = '<span class="badge bg-success">COMPLETED</span>';
                    }else if($order->commission_status === 0){
                        $item['commission_status'] = '<span class="' . ($remaining_days == 0 ? 'text-success' : '') . ' fs-5">' . $remaining_days . ' Days Left.</span>';
                    }else{
                        $item['commission_status'] = ' - ';
                    }

                    $actions = '';
                    if($order->commission_status === 0){
                        if($remaining_days == 0){
                            $actions .= '<a class="btn btn-sm btn-success"  onclick="$(\'#commissionPayModal\').modal(\'show\'); $(\'#pay_order_commission #order_id\').val('.$order->id.')" data-bs-toggle="tooltip" data-bs-placement="top" title="Pay Commission"><i class="fa fa-check-circle"></i></a>';
                        }else{
                            $actions .= '<button class="btn btn-sm btn-success" disabled><i class="fa fa-check-circle"></i></button>';
                        }

                    }elseif($order->commission_status === NULL){
                        $actions .= '<a class="btn btn-sm btn-primary" onclick="$(\'#commissionApplyModal\').modal(\'show\'); $(\'#process_order_commission #order_id\').val('.$order->id.')" data-bs-toggle="tooltip" data-bs-placement="top" title="Issue Commission"><i class="fa fa-check-circle"></i></a>';
                    }

                    $item['actions'] = $actions;
                    $all_items[] = $item;
                    $srno++;
                }
            }

            return response()->json([
                "draw"            => intval($request->request->get('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
                "data"            => $all_items
            ]);
        }
    }
}

