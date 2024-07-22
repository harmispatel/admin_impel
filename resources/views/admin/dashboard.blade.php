@extends('admin.layouts.admin-layout')

@section('title', 'DASHBOARD - IMPEL JEWELLERS')

@section('content')



    {{-- Page Title --}}

    <div class="pagetitle">

        <h1>Dashboard</h1>

        <div class="row">

            <div class="col-md-8">

                <nav>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item active">Dashboard</li>

                    </ol>

                </nav>

            </div>

        </div>

    </div>





    {{-- Dashboard Section --}}

    <section class="section dashboard">
        <div class="row">

            <div class="col-md-12">

                <div class="row">

                    {{-- Categories Count --}}

                    @can('categories.count')

                        <div class="col-md-3">

                            <div class="card info-card sales-card">

                                <div class="card-body">

                                    <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('categories.index') }}">Categories</a></h5>

                                    <div class="d-flex align-items-center">

                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                            <i class="fa-solid fa-list"></i>

                                        </div>

                                        <div class="ps-3">

                                            <h6>{{ $active_categories + $inactive_categories }} </h6>

                                            <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_categories }})</span> <br>

                                            <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_categories }})</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endcan



                    {{-- Tags Count --}}

                    @can('tags.count')

                        <div class="col-md-3">

                            <div class="card info-card sales-card">

                                <div class="card-body">

                                    <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('tags.index') }}">Tags</a></h5>

                                    <div class="d-flex align-items-center">

                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                            <i class="fa-solid fa-tags"></i>

                                        </div>

                                        <div class="ps-3">

                                            <h6>{{ $active_tags + $inactive_tags }} </h6>

                                            <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_tags }})</span> <br>

                                            <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_tags }})</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endcan



                    {{-- Designs Count --}}

                    @can('designs.count')

                        <div class="col-md-3">

                            <div class="card info-card sales-card">

                                <div class="card-body">

                                    <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('designs.index') }}">Designs</a></h5>

                                    <div class="d-flex align-items-center">

                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                            <i class="fa-solid fa-pencil"></i>

                                        </div>

                                        <div class="ps-3">

                                            <h6>{{ $active_designs + $inactive_designs }} </h6>

                                            <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_designs }})</span> <br>

                                            <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_designs }})</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endcan



                    {{-- Pages Count --}}

                    @can('pages.count')

                        <div class="col-md-3">

                            <div class="card info-card sales-card">

                                <div class="card-body">

                                    <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('pages.index','faq') }}">Pages</a></h5>

                                    <div class="d-flex align-items-center">

                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                            <i class="fa-solid fa-file-text"></i>

                                        </div>

                                        <div class="ps-3">

                                            <h6>{{ $pages_count }} </h6>

                                            <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $pages_count }})</span> <br>

                                            <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> (0)</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endcan



                    {{-- Orders Count --}}

                    @can('orders.count')

                        <div class="col-md-3">

                            <div class="card info-card sales-card">

                                <div class="card-body">

                                    <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('orders.index') }}">Orders</a></h5>

                                    <div class="d-flex align-items-center">

                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                            <i class="fa-solid fa-cart-shopping"></i>

                                        </div>

                                        <div class="ps-3">

                                            <h6>{{ $pending_orders + $completed_orders }} </h6>

                                            <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Completed</span> ({{ $completed_orders }})</span>

                                            <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Pending</span> ({{ $pending_orders }})</span> <br>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endcan



                    {{-- Users Count --}}

                    @can('users.count')

                        <div class="col-md-3">

                            <div class="card info-card sales-card">

                                <div class="card-body">

                                    <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('users.index') }}">Users</a></h5>

                                    <div class="d-flex align-items-center">

                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                            <i class="fa-solid fa-users"></i>

                                        </div>

                                        <div class="ps-3">

                                            <h6>{{ $active_users + $inactive_users }} </h6>

                                            <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_users }})</span> <br>

                                            <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_users }})</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endcan



                    {{-- Dealers Count --}}

                    @can('dealers.count')

                        <div class="col-md-3">

                            <div class="card info-card sales-card">

                                <div class="card-body">

                                    <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('dealers.index') }}">Dealers</a></h5>

                                    <div class="d-flex align-items-center">

                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                            <i class="fa-solid fa-users"></i>

                                        </div>

                                        <div class="ps-3">

                                            <h6>{{ $active_dealers + $inactive_dealers }} </h6>

                                            <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_dealers }})</span> <br>

                                            <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_dealers }})</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endcan



                    {{-- Customers Count --}}

                    @can('customers.count')

                        <div class="col-md-3">

                            <div class="card info-card sales-card">

                                <div class="card-body">

                                    <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('customers.index') }}">Customers</a></h5>

                                    <div class="d-flex align-items-center">

                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                            <i class="fa-solid fa-users"></i>

                                        </div>

                                        <div class="ps-3">

                                            <h6>{{ $active_customers + $inactive_customers }} </h6>

                                            <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_customers }})</span> <br>

                                            <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_customers }})</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endcan
                </div>

            </div>



            {{-- Pending Orders List --}}

            @can('pending.orders.list')

                <div class="col-md-12 mt-2">

                    <div class="col-12">

                        <div class="card recent-sales">

                            <div class="card-body">

                                <h5 class="card-title">Pending Orders</h5>

                                <div class="table-responsive">

                                    <table class="table">

                                        <thead class="text-uppercase">

                                            <tr>

                                                <th>#</th>

                                                <th>Customer</th>

                                                <th>Phone</th>

                                                <th>Dealer</th>

                                                <th>Status</th>

                                                @canany(['orders.accept', 'orders.show'])

                                                    <th>Actions</th>

                                                @endcan

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @if(isset($pending_orders_datas) && count($pending_orders_datas) > 0)

                                                @foreach ($pending_orders_datas as $order)

                                                    <tr>

                                                        <td>{{ $order->id }}</td>

                                                        <td>{{ $order->name }}</td>

                                                        <td>{{ $order->phone }}</td>

                                                        <td>{{ (isset($order->dealer['name'])) ? $order->dealer['name'] : '-' }}</td>

                                                        <td>

                                                            @if($order['order_status'] == 'pending')

                                                                <span style="font-size: 13px;" class="badge bg-warning">Pending.</span>

                                                            @elseif($order['order_status'] == 'accepted')

                                                                <span style="font-size: 13px;" class="badge bg-info">Accepted.</span>

                                                            @elseif($order['order_status'] == 'processing')

                                                                <span style="font-size: 13px;" class="badge bg-primary">Processing.</span>

                                                            @elseif($order['order_status'] == 'completed')

                                                                <span style="font-size: 13px;" class="badge bg-success">Completed.</span>

                                                            @endif

                                                        </td>



                                                        @canany(['orders.accept', 'orders.show'])

                                                            <td>

                                                                {{-- Accept Button --}}

                                                                @can('orders.accept')

                                                                    <a onclick="processOrder('accepted', {{ $order->id }})" data-bs-toggle="tooltip" data-bs-placement="top" title="Accept Order" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-check-circle"></i></a>

                                                                @endcan



                                                                {{-- Details Page Button --}}

                                                                @can('orders.show')

                                                                    <a href="{{ route('orders.show',encrypt($order->id)) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="View Order" class="btn btn-sm custom-btn"><i class="fa-solid fa-eye"></i></a>

                                                                @endcan

                                                            </td>

                                                        @endcan

                                                    </tr>

                                                @endforeach

                                            @else

                                                <tr class="text-center">

                                                    @canany(['orders.accept', 'orders.show'])

                                                        <td colspan="6">

                                                    @else

                                                        <td colspan="5">

                                                    @endcan

                                                        <h5>Records not found!</h5>

                                                    </td>

                                                </tr>

                                            @endif

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endcan



        </div>

    </section>



@endsection



{{-- Custom JS --}}

@section('page-js')

<script type="text/javascript">



    // Process Order

    function processOrder(status, id){

        $.ajax({

            type: "POST",

            url: "{{ route('orders.process') }}",

            data: {

                "_token": "{{ csrf_token() }}",

                "status": status,

                'id': id,

            },

            dataType: "JSON",

            success: function (response) {

                if(response.success == true){

                    toastr.success(response.message);

                    setTimeout(() => {

                        location.reload();

                    }, 1200);

                }else{

                    toastr.error(response.message);

                }

            }

        });

    }



</script>

@endsection

