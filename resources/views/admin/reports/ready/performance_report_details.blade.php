@extends('admin.layouts.admin-layout')

@section('title', 'DEALER PERFORMANCE - REPORT DETAILS - IMPEL JEWELLERS')

@section('content')



    <input type="hidden" name="dealer_id" id="dealer_id" value="{{ (isset($dealer->id)) ? $dealer->id : '' }}">



    <div class="modal fade" id="commissionApplyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="commissionApplyModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="commissionApplyModalLabel">Please Fill Details to Process Order Commission</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <form method="POST" id="process_order_commission" enctype="multipart/form-data">

                        @csrf

                        <input type="hidden" name="order_id" id="order_id" value="">

                        <div class="row">

                            <div class="col-md-12 mb-3">

                                <label for="labour_value" class="form-label">Labour Value</label>

                                <input type="number" name="labour_value" id="labour_value" class="form-control">

                            </div>

                            <div class="col-md-12 mb-3">

                                <label for="bill_date" class="form-label">Bill Date</label>

                                <input type="date" name="bill_date" id="bill_date" class="form-control">

                            </div>

                            <div class="col-md-12 mb-3">

                                <label for="bill_number" class="form-label">Bill Number</label>

                                <input type="text" name="bill_number" id="bill_number" class="form-control">

                            </div>

                            <div class="col-md-12">

                                <a class="btn btn-sm btn-success" id="proOrderBtn">Save</a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="commissionPayModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="commissionPayModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="commissionPayModalLabel">Please Fill Details to Pay Order Commission</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <form id="pay_order_commission" enctype="multipart/form-data">

                        @csrf

                        <input type="hidden" name="order_id" id="order_id" value="">

                        <div class="row">

                            <div class="col-md-12 mb-3">

                                <label for="payment_date" class="form-label">Payment Date</label>

                                <input type="date" name="payment_date" id="payment_date" class="form-control">

                            </div>

                            <div class="col-md-12 mb-3">

                                <label for="transaction_id" class="form-label">Transaction ID</label>

                                <input type="text" name="transaction_id" id="transaction_id" class="form-control">

                            </div>

                            <div class="col-md-12">

                                <a class="btn btn-sm btn-success" id="payOrderBtn">Save</a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>



    {{-- Page Title --}}

    <div class="pagetitle">

        <h1>Dealer Performance Report Details</h1>

        <div class="row">

            <div class="col-md-8">

                <nav>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('reports.ready.performance') }}">Dealer Performance Report</a></li>

                        <li class="breadcrumb-item active">Dealer Performance Report Details</li>

                    </ol>

                </nav>

            </div>

        </div>

    </div>



    {{-- Page Content --}}

    <section class="section dealer_performance">

        <div class="row">

            <div class="col-md-4 mb-3"></div>

            <div class="col-md-4 mb-3"></div>

            <div class="col-md-4 mb-3">

                <input type="text" name="datetimes" id="dateRangePicker" class="form-control" />

            </div>

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 text-start">

                                <h5><strong>Dealer -: {{ $dealer->name }}</strong></h5>

                            </div>

                            <div class="col-md-6 text-end">

                                <h5><strong>Dealer Code -: {{ $dealer->dealer_code }}</strong></h5>

                            </div>

                        </div>

                        <div class="table-responsive p-3">

                            <table class="table nowrap" id="orderDetails">

                                <thead>

                                    <tr>

                                        <th scope="col">#</th>

                                        <th scope="col">Order No.</th>

                                        <th scope="col">Customer</th>

                                        <th scope="col">Commission Value</th>

                                        <th scope="col">Commission Status</th>

                                        <th scope="col">Actions</th>

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



@section('page-js')

<script type="text/javascript">



    $(document).ready(function () {

        let selectedStartDate = $("input[name='datetimes']").data('daterangepicker').startDate.format("YYYY-MM-DD");

        let selectedEndDate = $("input[name='datetimes']").data('daterangepicker').endDate.format("YYYY-MM-DD");

        loadRecords(selectedStartDate, selectedEndDate);

        $('#pay_order_commission, #process_order_commission').on('keypress', function(e) {
            if (e.which === 13) { // 13 is the Enter key
                e.preventDefault();
                return false;
            }
        });

    });



    function loadRecords(startDate = null, endDate = null){

        $('#orderDetails').DataTable().destroy();

        // Load All Order Details

        var table = $('#orderDetails').DataTable({

            processing: true,

            serverSide: true,

            pageLength: 100,

            ajax: {

                url: "{{ route('reports.ready.performance.details.load') }}",

                type: "GET",

                data: {

                    'dealer_id' : $('#dealer_id').val(),

                    start_date: startDate,

                    end_date: endDate,

                }

            },

            drawCallback: function(settings) {

                $('[data-bs-toggle="tooltip"]').tooltip();

            },

            columns: [{

                    data: 'id',

                    name: 'id',

                    orderable: false,

                    searchable: false,

                },

                {

                    data: 'orderno',

                    name: 'orderno',

                    searchable: true,

                    orderable: false,

                },

                {

                    data: 'customer',

                    name: 'customer',

                    searchable: true,

                    orderable: false,

                },

                {

                    data: 'commission_value',

                    name: 'commission_value',

                    orderable: false,

                    searchable: false

                },

                {

                    data: 'commission_status',

                    name: 'commission_status',

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

    }



    $("input[name='datetimes']").daterangepicker({

        locale: {

            format: 'DD-MM-YYYY' // Set the desired date format here

        },
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month')
        // startDate: moment().subtract(1, 'months').startOf('month'),

        // endDate: moment().subtract(1, 'months').endOf('month')

    }, function(start, end, label) {

        let startDate = start.format("YYYY-MM-DD").toString();

        let endDate = end.format("YYYY-MM-DD").toString();

        loadRecords(startDate, endDate);

    });



    $('#proOrderBtn').on('click', function(){

        var myFormData = new FormData(document.getElementById('process_order_commission'));

        var orderID = $('#process_order_commission #order_id').val();

        $('#labour_value, #bill_date, #bill_number').removeClass('is-invalid');

        toastr.clear();



        $.ajax({

            type: "POST",

            url: "{{ route('orders.ready.process.commission') }}",

            data: myFormData,

            dataType: "JSON",

            contentType: false,

            cache: false,

            processData: false,

            success: function (response) {

                if(response.success == 1){

                    toastr.success(response.message);

                    setTimeout(() => {

                        location.reload();

                    }, 1200);

                }else{

                    toastr.error(response.message);

                }

            },

            error: function (response) {

                // All Validation Errors

                const validationErrors = response?.responseJSON?.errors || {};

                // Validation Error Handling

                const handleValidationError = (field, errorKey) => {

                    const error = validationErrors[errorKey] || '';

                    if (error !== '') {

                        $(field).addClass('is-invalid');

                        toastr.error(error);

                    }

                };

                // Labour Value Error

                handleValidationError('#labour_value', 'labour_value');

                // Bill Date Error

                handleValidationError('#bill_date', 'bill_date');

                // Bill No. Error

                handleValidationError('#bill_number', 'bill_number');

            }

        });



    });



    $('#payOrderBtn').on('click', function(){

        var myFormData = new FormData(document.getElementById('pay_order_commission'));

        var orderID = $('#pay_order_commission #order_id').val();

        $('#payment_date, #transaction_id').removeClass('is-invalid');

        toastr.clear();



        $.ajax({

            type: "POST",

            url: "{{ route('orders.ready.pay.commission') }}",

            data: myFormData,

            dataType: "JSON",

            contentType: false,

            cache: false,

            processData: false,

            success: function (response) {

                if(response.success == 1){

                    toastr.success(response.message);

                    setTimeout(() => {

                        location.reload();

                    }, 1200);

                }else{

                    toastr.error(response.message);

                }

            },

            error: function (response) {

                // All Validation Errors

                const validationErrors = response?.responseJSON?.errors || {};

                // Validation Error Handling

                const handleValidationError = (field, errorKey) => {

                    const error = validationErrors[errorKey] || '';

                    if (error !== '') {

                        $(field).addClass('is-invalid');

                        toastr.error(error);

                    }

                };

                // Transaction ID Error

                handleValidationError('#transaction_id', 'transaction_id');

                // Payment Date Error

                handleValidationError('#payment_date', 'payment_date');

            }

        });



    });



</script>

@endsection

