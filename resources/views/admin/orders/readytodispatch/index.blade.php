@extends('admin.layouts.admin-layout')
@section('title', 'ORDERS - IMPEL JEWELLERS')
@section('content')
    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Ready To Dispatch Orders</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Ready To Dispatch Orders</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Orders Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                            <table class="table w-100" id="ordersTable">
                                <thead>
                                    <tr>
                                        <th>Order No.</th>
                                        <th>Customer</th>
                                        <th>Phone No.</th>
                                        <th>Order Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


{{-- Custom Script --}}
@section('page-js')
    <script type="text/javascript">
        // Load All Orders
        $(function() {
            var table = $('#ordersTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: "{{ route('orders.readytodispatch.load') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        searchable: true
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        searchable: true
                    },
                    {
                        data: 'order_status',
                        name: 'order_status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection

