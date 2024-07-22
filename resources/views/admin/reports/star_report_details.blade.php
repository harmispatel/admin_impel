@extends('admin.layouts.admin-layout')
@section('title', 'STAR REPORT DETAILS - IMPEL JEWELLERS')
@section('content')

    <input type="hidden" name="design_id" id="design_id" value="{{ $design->id }}">

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Star Report Details</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.star') }}">Star Report</a></li>
                        <li class="breadcrumb-item active">Star Report Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Page Content --}}
    <section class="section dealer_performance">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive p-3">
                            <table class="table nowrap" id="starReport">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Dealer Code</th>
                                        <th scope="col">Dealer Name</th>
                                        <th scope="col">Dealer Contact</th>
                                        <th scope="col">Dealer City</th>
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

    loadRecords();

    // Load All Reports
    function loadRecords(){
        var table = $('#starReport').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 100,
            ajax: {
                url: "{{ route('reports.star.details.load') }}",
                type: "GET",
                data: {
                    'design_id' : $('#design_id').val(),
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'dealer_code',
                    name: 'dealer_code',
                    searchable: true,
                    orderable: false,
                },
                {
                    data: 'dealer_name',
                    name: 'dealer_name',
                    searchable: true,
                    orderable: false,
                },
                {
                    data: 'dealer_contact',
                    name: 'dealer_contact',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'dealer_city',
                    name: 'dealer_city',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    }

</script>
@endsection
