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
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            border: none;
        }

        .badge {
            font-size: 15px;
        }

        img {
            width: 100px;
            height: 100px;
            border-radius: 5px;
            box-shadow: 3px 3px 3px #ccc;
            border: 2px solid #575757;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row mb-3">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="card h-100 mb-0">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><strong>Order No. :</strong></td>
                                    <td>{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Order Status :</strong></td>
                                    <td>
                                        @if($order->order_status == 'pending')
                                            Pending.
                                        @elseif($order->order_status == 'accepted')
                                            Accepted.
                                        @elseif($order->order_status == 'processing')
                                            Processing.
                                        @elseif($order->order_status == 'completed')
                                            Completed.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Order Date :</strong></td>
                                    <td>{{ date('d-M-Y', strtotime($order->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Order Time :</strong></td>
                                    <td>{{ date('h:i:s A', strtotime($order->created_at)) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                    <thead class="text-uppercase">
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>Image</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Qty.</th>
                            <th>Gold Type</th>
                            <th>Gold Color</th>
                            <th>Net Weight</th>
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
                                            <img src="{{ asset('public/images/uploads/item_images/'.$design_code.'/'.$order_item->design['image']) }}"/>
                                        @else
                                            <img src="{{ asset('public/images/default_images/not-found/no_img1.jpg') }}"/>
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

    <script>
        // Function to open the print popup automatically
        function openPrintPopup() {
            window.print();
        }

        // Event listener to close the tab when the print popup is closed
        window.addEventListener('afterprint', function() {
            window.close();
        });

        // Trigger the print popup on page load
        document.addEventListener('DOMContentLoaded', function() {
            openPrintPopup();
        });
    </script>

</body>
</html>
