<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order {{ $order['id'] }}</title>
    <link href="{{ asset('public/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/custom.css') }}" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a class="ms-1 mb-2 btn btn-sm btn-primary" href="{{ route('orders.print', encrypt($order->id)) }}" target="_blank">Print <i class="bi bi-printer"></i></a>
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
                                                                    @if(isset($order_item->design['image']) && !empty($order_item->design['image']) && file_exists('public/images/uploads/item_images/'.$design_code.'/'.$order_item->design['image']))
                                                                        <img src="{{ asset('public/images/uploads/item_images/'.$design_code.'/'.$order_item->design['image']) }}" style="width: 65px; height: 65px; border-radius: 5px; box-shadow: 3px 3px 3px #ccc; border: 2px solid #575757;" />
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
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
