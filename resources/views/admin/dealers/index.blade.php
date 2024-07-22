@extends('admin.layouts.admin-layout')
@section('title', 'DEALERS - IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Dealers</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dealers</li>
                    </ol>
                </nav>
            </div>
            @can('dealers.create')
                <div class="col-md-4" style="text-align: right;">
                    <a href="{{ route('dealers.create') }}" class="btn btn-sm new-category custom-btn">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    {{-- Dealers Section --}}
    <section class="section dealers">
        <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                            <table class="table nowrap w-100" id="DealersTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Profile</th>
                                        <th>Status</th>
                                        <th>Joined On</th>
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

        // Load All Dealers
        $(function() {
            var table = $('#DealersTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: "{{ route('dealers.load') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'dealer_code',
                        name: 'dealer_code'
                    },
                    {
                        data: 'profile_picture',
                        name: 'profile_picture',
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
                        data: 'joined_on',
                        name: 'joined_on',
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

        // Change Status of Dealer
        function changeStatus(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('dealers.status') }}",
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
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                }
            })
        }

        // Delete Dealer
        function deleteDealer(id) {
            swal({
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDeleteDealer) => {
                if (willDeleteDealer) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('dealers.destroy') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            if (response.success == 1) {
                                swal(response.message, "", "success");
                                $('#DealersTable').DataTable().ajax.reload();
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
