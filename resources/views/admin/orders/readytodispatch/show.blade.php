@extends('admin.layouts.admin-layout')
@section('title', 'DETAILS - ORDERS - IMPEL JEWELLERS')
@section('content')

{{-- Page Title --}}
<div class="pagetitle">
    <h1>Ready To Dispatch Orders</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item "><a href="{{ route('orders.readytodispatch') }}">Ready To Dispatch Order</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Order Details Section --}}
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-end">

                            @can('ready.orders.accept')
                            @if(isset($order->order_status) && $order->order_status == 'pending')
                            <a onclick="processOrder('accepted', {{ $order->id }})" class="mb-2 btn btn-sm btn-info text-white"><strong>ACCEPT</strong> <i class="fa-solid fa-check-circle"></i></a>
                            @endif
                            @endcan

                            @can('orders.process')
                            @if(isset($order->order_status) && ($order->order_status == 'pending' || $order->order_status == 'accepted'))
                            <a onclick="processOrder('processing', {{ $order->id }})" class="ms-1 mb-2 btn btn-sm btn-primary"><strong>PROCESS</strong> <i class="fa-solid fa-check-circle"></i></a>
                            @endif
                            @endcan

                            @can('ready.orders.complete')
                            @if(isset($order->order_status) && ($order->order_status == 'pending' || $order->order_status == 'accepted' || $order->order_status == 'processing'))
                            <a onclick="processOrder('completed', {{ $order->id }})" class="ms-1 mb-2 btn btn-sm btn-success"><strong>COMPLETE</strong> <i class="fa-solid fa-check-circle"></i></a>
                            @endif
                            @endcan

                            <!-- <a class="ms-1 mb-2 btn btn-sm btn-primary" href="{{ route('orders.print', encrypt($order->id)) }}" target="_blank">Print <i class="fa fa-print"></i></a>

                                <a onclick="share()" class="btn btn-sm btn-primary ms-1 mb-2">Share <i class="bi bi-share"></i></a> -->
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4 mt-3">
                            <div class="card h-100 mb-0">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>Order No. : </strong></div>
                                                        <div style="width: 53%">{{ $order->id }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>Order Status : </strong></div>
                                                        <div style="width: 53%">
                                                            @if($order->order_status == 'pending')
                                                            <span class="badge bg-warning" style="font-size: 15px;">Pending.</span>
                                                            @elseif($order->order_status == 'accepted')
                                                            <span class="badge bg-info" style="font-size: 15px;">Accepted.</span>
                                                            @elseif($order->order_status == 'processing')
                                                            <span class="badge bg-primary" style="font-size: 15px;">Processing.</span>
                                                            @elseif($order->order_status == 'completed')
                                                            <span class="badge bg-success" style="font-size: 15px;">Completed.</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>Order Date : </strong></div>
                                                        <div style="width: 53%">{{ date('d-M-Y', strtotime($order->created_at)) }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>Order Time : </strong></div>
                                                        <div style="width: 53%">{{ date('h:i:s A', strtotime($order->created_at)) }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="card h-100 mb-0">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>Customer : </strong></div>
                                                        <div style="width: 53%">{{ $order->name }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>Email : </strong></div>
                                                        <div style="width: 53%">{{ $order->email }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div style="width: 47%"><strong>Phone : </strong></div>
                                                    <div style="width: 53%">{{ $order->phone }}</div>
                                                </div>
                                            </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>Address : </strong></div>
                                                        <div style="width: 53%">{{ $order->address }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>City : </strong></div>
                                                        <div style="width: 53%">{{ (isset($order->City['name'])) ? $order->City['name'] : '' }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>State : </strong></div>
                                                        <div style="width: 53%">{{ (isset($order->State['name'])) ? $order->State['name'] : '' }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>Pincode : </strong></div>
                                                        <div style="width: 53%">{{ $order->pincode }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                            <thead class="text-uppercase">
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Code</th>
                                                    <th scope="col">Qty.</th>
                                                    <th scope="col">Gold Type</th>
                                                    <th scope="col">Gold Color</th>
                                                    <th scope="col">Net Weight</th>
                                                    <th scope="col">Metal Price</th>
                                                    <th scope="col">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600">
                                                @if(isset($order->order_items) && count($order->order_items) > 0)
                                                @foreach ($order->order_items as $order_item)
                                                @php
                                                $design_code = isset($order_item->design['code']) ? $order_item->design['code'] : '';
                                                @endphp
                                                <tr>
                                                    <td>
                                                        @if(isset($order_item['barcode']) && !empty($order_item['barcode']))
                                                        <img src="{{ url('https://api.indianjewelcast.com/TagImage/' . $order_item['barcode'] . '.jpg') }}" style="width: 65px; height: 65px; border-radius: 5px; box-shadow: 3px 3px 3px #ccc; border: 2px solid #575757;" onerror="this.onerror=null; this.src='{{ asset('public/images/default_images/not-found/no_img1.jpg') }}';" />
                                                        @else
                                                        <img src="{{ asset('public/images/default_images/not-found/no_img1.jpg') }}" style="width: 65px; height: 65px; border-radius: 5px; box-shadow: 3px 3px 3px #ccc; border: 2px solid #575757;" />
                                                        @endif
                                                    </td>
                                                    <td>{{ $order_item['design_name'] }}</td>
                                                    <td>{{ (isset($design_code)) ? $design_code : '-' }}</td>
                                                    <td>{{ $order_item['quantity'] }}</td>
                                                    <td>{{ $order_item['gold_type'] }}</td>
                                                    <td>{{ $order_item['gold_color'] }}</td>
                                                    <td>{{ $order_item['net_weight'] }} gm.</td>
                                                    <td>₹ {{ $order_item['item_sub_total'] }}</td>
                                                    <td>₹ {{ $order_item['item_total'] }}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 justify-content-end">
                        <div class="col-md-4">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th scope="col">Metal Price : </th>
                                                    <td class="text-end">₹ {{ $order->sub_total  }}</td>
                                                </tr>
                                                <!-- <tr>
                                                        <th scope="col">Charges : </th>
                                                        <td class="text-end">₹ {{ $order->charges  }}</td>
                                                    </tr> -->
                                                <tr>
                                                    <th scope="col">GST (3%) : </th>
                                                    <td class="text-end">₹ {{ $order->gst_amount  }}</td>
                                                </tr>
                                                @if(isset($order->dealer_code) && !empty($order->dealer_code) && isset($order->dealer_discount_type) && !empty($order->dealer_discount_type) && isset($order->dealer_discount_value) && !empty($order->dealer_discount_value))
                                                <tr class="text-success">
                                                    <th>Dealer Discount <br> <span>({{ $order->dealer_code }}) {{ ($order->dealer_discount_type == 'percentage') ? '('.$order->dealer_discount_value.'%)' : '' }}</span></th>
                                                    @if($order->dealer_discount_type == 'percentage')
                                                    <td class="text-end">- ₹ {{ ($order->charges * $order->dealer_discount_value) / 100 }}</td>
                                                    @else
                                                    <td class="text-end">- ₹ {{ $order->dealer_discount_value }}</td>
                                                    @endif
                                                </tr>
                                                @endif
                                                <tr>
                                                    <th scope="col">Total (Approx.) : </th>
                                                    <td class="text-end"><strong>₹ {{ $order->total }}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('page-js')
<script type="text/javascript">
    // Process Order
    function processOrder(status, id) {
        $.ajax({
            type: "POST",
            url: "{{ route('orders.readytodispatch.process') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "status": status,
                'id': id,
            },
            dataType: "JSON",
            success: function(response) {
                if (response.success == true) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1200);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    }

    function share() {
        var currenturl = window.location.href;
        if (navigator.share) {
            navigator.share({
                    title: 'IMPEL JEWELLERS ORDER :  {{ $order->id }}',
                    url: '{{ route("orders.shared",encrypt($order->id)) }}',
                })
                .then(() => console.log('Successful share'))
                .catch(error => console.log('Error sharing: ', error));
        } else {
            console.log('web share api not supported.');
        }
    }
</script>
@endsection
