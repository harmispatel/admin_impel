@extends('admin.layouts.admin-layout')
@section('title', 'DESIGNS - IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Designs</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Designs</li>
                    </ol>
                </nav>
            </div>
            {{-- <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('designs.create') }}" class="btn btn-sm new-category custom-btn"><i class="bi bi-plus-lg"></i></a>
            </div> --}}
        </div>
    </div>


    {{-- Designs Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                            <table class="table w-100" id="designsTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Top Selling ?</th>
                                        {{-- <th>Actions</th> --}}
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

        // Load All Designes
        $(function() {
            var table = $('#designsTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: "{{ route('designs.load') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        searchable: true
                    },
                    {
                        data: 'code',
                        name: 'code',
                        searchable: true
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'top_selling',
                        name: 'top_selling',
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //     data: 'actions',
                    //     name: 'actions',
                    //     orderable: false,
                    //     searchable: false
                    // },
                ]
            });

        });

        // Change Status of Design
        function changeStatus(id) {
            toastr.clear();
            $.ajax({
                type: "POST",
                url: "{{ route('designs.status') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success == 1) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            })
        }

        // Add / Remove Design to Top Selling.
        function changeTopSelling(id) {
            toastr.clear();
            $.ajax({
                type: "POST",
                url: "{{ route('designs.top-selling') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success == 1) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            })
        }

        // Delete Design
        function deleteDesign(id) {
            swal({
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDeleteDesign) => {
                if (willDeleteDesign) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('designs.destroy') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            if (response.success == 1) {
                                swal(response.message, "", "success");
                                $('#designsTable').DataTable().ajax.reload();
                            } else {
                                swal(response.message, "", "error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "", "error");
                }
            });
        }
    </script>

@endsection
