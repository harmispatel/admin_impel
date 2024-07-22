@extends('admin.layouts.admin-layout')
@section('title', 'STAR REPORT - IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Star Report</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Star Report</li>
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
                                        <th scope="col">Design Code</th>
                                        <th scope="col">Design Name</th>
                                        <th scope="col">Stars</th>
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

    loadRecords();

    // Load All Reports
    function loadRecords(){
        var table = $('#starReport').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 100,
            ajax: {
                url: "{{ route('reports.star.load') }}",
                type: "GET",
                data: {
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'code',
                    name: 'code',
                    searchable: true,
                    orderable: false,
                },
                {
                    data: 'name',
                    name: 'name',
                    searchable: true,
                    orderable: false,
                },
                {
                    data: 'stars',
                    name: 'stars',
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

</script>
@endsection
