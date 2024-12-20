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
                                    <a id="accepted" onclick="processOrder('accepted', {{ $order->id }})" class="mb-2 btn btn-sm btn-info text-white"><strong>ACCEPT</strong> <i class="fa-solid fa-check-circle"></i></a>

                                    <button class="mb-2 btn-sm btn btn-primary" type="button" disabled style="display: none;">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Accepting...
                                        </button>
                                @endif
                            @endcan

                            @can('orders.process')
                                @if(isset($order->order_status) && ($order->order_status == 'pending' || $order->order_status == 'accepted'))
                                    <a id="processing" onclick="processOrder('processing', {{ $order->id }})" class="ms-1 mb-2 btn btn-sm btn-primary"><strong>PROCESS</strong> <i class="fa-solid fa-check-circle"></i></a>

                                    <button class="mb-2 btn-sm btn btn-primary" type="button" disabled style="display: none;">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Processing...
                                        </button>
                                @endif
                            @endcan

                            @can('ready.orders.complete')
                                @if(isset($order->order_status) && ($order->order_status == 'pending' || $order->order_status == 'accepted' || $order->order_status == 'processing'))
                                    <a id="completed" onclick="processOrder('completed', {{ $order->id }})" class="ms-1 mb-2 btn btn-sm btn-success"><strong>COMPLETE</strong> <i class="fa-solid fa-check-circle"></i></a>

                                    <button class="mb-2 btn-sm btn btn-primary" type="button" disabled style="display: none;">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Completing...
                                        </button>
                                @endif
                            @endcan
                            
                            @if(isset($order->payment_status) && $order->payment_status == 0)
                                <a onclick="paidPayment({{ $order->id }})" class="ms-1 mb-2 btn btn-sm btn-success"><strong>PAID</strong> <i class="fa-solid fa-money-bill"></i> <i class="fa-solid fa-check"></i></a>
                            @endif
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
                                                            <span class="badge bg-warning" style="font-size: 13px;">Pending.</span>
                                                            @elseif($order->order_status == 'accepted')
                                                            <span class="badge bg-info" style="font-size: 13px;">Accepted.</span>
                                                            @elseif($order->order_status == 'processing')
                                                            <span class="badge bg-primary" style="font-size: 13px;">Processing.</span>
                                                            @elseif($order->order_status == 'completed')
                                                            <span class="badge bg-success" style="font-size: 13px;">Completed.</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 47%"><strong>Payment Status : </strong></div>
                                                        <div style="width: 53%">
                                                            @if($order->payment_status == 1)
                                                                <span class="badge bg-success" style="font-size: 13px;">Paid.</span>
                                                            @else
                                                                <span class="badge bg-danger" style="font-size: 13px;">Unpaid.</span>                       
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
                                                    <th scope="col">Qty.</th>
                                                    <th scope="col">Net Weight</th>
                                                    <th scope="col">Metal Value</th>
                                                    <th scope="col">Making Charge</th>
                                                    <th scope="col">Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600">
                                                @if(isset($order->order_items) && count($order->order_items) > 0)
                                                    @foreach ($order->order_items as $order_item)
                                                        <tr>
                                                            <td>
                                                                @if(isset($order_item['barcode']) && !empty($order_item['barcode']))
                                                                    <img src="{{ url('https://api.indianjewelcast.com/TagImage/' . $order_item['barcode'] . '.jpg') }}" style="width: 65px; height: 65px; border-radius: 5px; box-shadow: 3px 3px 3px #ccc; border: 2px solid #575757;" onerror="this.onerror=null; this.src='{{ asset('public/images/default_images/not-found/no_img1.jpg') }}';" />
                                                                @else
                                                                    <img src="{{ asset('public/images/default_images/not-found/no_img1.jpg') }}" style="width: 65px; height: 65px; border-radius: 5px; box-shadow: 3px 3px 3px #ccc; border: 2px solid #575757;" />
                                                                @endif
                                                            </td>
                                                            <td>{{ $order_item['design_name'] }}</td>
                                                            <td>{{ $order_item['quantity'] }}</td>
                                                            <td>{{ $order_item['net_weight'] }} gm.</td>
                                                            <td>₹{{ round($order_item['metal_value']) }}</td>
                                                            <td>
                                                                @if(isset($order_item['making_charge_discount']) && !empty($order_item['making_charge_discount']) && $order_item['making_charge_discount'] > 0)
                                                                    ₹{{ round($order_item['making_charge_discount']) }}
                                                                @else
                                                                    ₹{{ round($order_item['making_charge']) }}
                                                                @endif
                                                            </td>
                                                            <td>₹{{ round($order_item['item_total']) }}</td>
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
                                                    <th scope="col">SUB TOTAL: </th>
                                                    <td class="text-end">₹{{ round($order->sub_total) }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="col">GST (3%): </th>
                                                    <td class="text-end">₹{{ round($order->gst_amount) }}</td>
                                                </tr>

                                                @if(isset($order->dealer_code) && !empty($order->dealer_code) && isset($order->dealer_discount_type) && !empty($order->dealer_discount_type) && isset($order->dealer_discount_value) && !empty($order->dealer_discount_value))
                                                    <tr class="text-success">
                                                        <th>Dealer Discount <br> <span>({{ $order->dealer_code }}) {{ ($order->dealer_discount_type == 'percentage') ? '('.$order->dealer_discount_value.'%)' : '' }}</span></th>
                                                        @if($order->dealer_discount_type == 'percentage')
                                                            <td class="text-end">- ₹{{ round(($order->charges * $order->dealer_discount_value) / 100) }}</td>
                                                        @else
                                                            <td class="text-end">- ₹{{ round($order->dealer_discount_value) }}</td>
                                                        @endif
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <th scope="col">TOTAL: </th>
                                                    <td class="text-end"><strong>₹{{ round($order->total) }}</strong></td>
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
            beforeSend: function(){
                $('#' + status).siblings('button').first().show();
                $('#' + status).hide();
            },
            dataType: "JSON",
            success: function(response) {
                if (response.success == true) {
                    $('#' + status).siblings('button').first().hide();
                    $('#' + status).show();
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

    function paidPayment(id){
        $.ajax({
            type: "POST",
            url: "{{ route('orders.readytodispatch.paid') }}",
            data: {
                "_token": "{{ csrf_token() }}",
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
