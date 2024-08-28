@extends('admin.layouts.admin-layout')

@section('title', 'DEALER PERFORMANCE - REPORT - READY - IMPEL JEWELLERS')

@section('content')



{{-- Page Title --}}
<div class="pagetitle">
    <h1>Ready Order Dealer Performance</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Ready Order Dealer Performance</li>
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
                    <div class="table-responsive p-3">
                        <table class="table nowrap" id="dealerPerformance">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Complete Commission</th>
                                    <th scope="col">Pending Commission</th>
                                    <th scope="col">Ready to Pay</th>
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
    });




    function loadRecords(startDate = null, endDate = null) {

        $('#dealerPerformance').DataTable().destroy();

        // Load All Reports

        var table = $('#dealerPerformance').DataTable({

            processing: true

            , serverSide: true

            , pageLength: 100

            , ajax: {

                url: "{{ route('reports.ready.performance.load') }}"

                , type: "GET"

                , data: {

                    start_date: startDate

                    , end_date: endDate

                , }

            }

            , columns: [{

                    data: 'id'

                    , name: 'id'

                    , orderable: false

                    , searchable: false

                , }

                , {

                    data: 'code'

                    , name: 'code'

                    , searchable: true

                    , orderable: false

                , }

                , {

                    data: 'name'

                    , name: 'name'

                    , searchable: true

                    , orderable: false

                , }

                , {

                    data: 'phone'

                    , name: 'phone'

                    , orderable: false

                    , searchable: false

                }

                , {

                    data: 'complete_commission'

                    , name: 'complete_commission'

                    , orderable: false

                    , searchable: false

                }

                , {

                    data: 'pending_commission'

                    , name: 'pending_commission'

                    , orderable: false

                    , searchable: false

                }

                , {

                    data: 'ready_to_pay'

                    , name: 'ready_to_pay'

                    , orderable: false

                    , searchable: false

                }

                , {

                    data: 'actions'

                    , name: 'actions'

                    , orderable: false

                    , searchable: false

                }

            , ]

        });

    }



    $("input[name='datetimes']").daterangepicker({

        locale: {

            format: 'DD-MM-YYYY' // Set the desired date format here

        },

        startDate: moment().subtract(1, 'months').startOf('month'),

        endDate: moment().subtract(1, 'months').endOf('month')

    }, function(start, end, label) {

        let startDate = start.format("YYYY-MM-DD").toString();

        let endDate = end.format("YYYY-MM-DD").toString();

        loadRecords(startDate, endDate);

    });



</script>

@endsection

