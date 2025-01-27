@extends('admin.layouts.admin-layout')

@section('title', 'MIDDLE BANNERS - IMPEL JEWELLERS')

@section('content')



    {{-- Page Title --}}

    <div class="pagetitle">

        <h1>Middle Banners</h1>

        <div class="row">

            <div class="col-md-8">

                <nav>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

                        <li class="breadcrumb-item active">Middle Banners</li>

                    </ol>

                </nav>

            </div>

            @if($total_middle_banner < 1)

                @can('middle-banners.create')

                    <div class="col-md-4" style="text-align: right;">

                        <a href="{{ route('middle-banners.create') }}" class="btn btn-sm custom-btn"><i class="bi bi-plus"></i></a>

                    </div>

                @endcan

            @endif

        </div>

    </div>



    {{-- Middle Banners Section --}}

    <section class="section dashboard">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive custom_dt_table">

                            <table class="table w-100" id="middleBannersTable">

                                <thead>

                                    <tr>

                                        <th>Sr</th>

                                        <th>Banner</th>

                                        <!-- <th>Tag</th> -->

                                        <th>Status</th>

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



        // Load all Middle Banners When Page Reload

        loadMiddleBanners();



        // Function for Load Middle Banners

        function loadMiddleBanners(){

            var middleBannersTable = $('#middleBannersTable').DataTable();

            // Destroy Old Table

            middleBannersTable.destroy();

            // Load New Table

            middleBannersTable = $('#middleBannersTable').DataTable({

                processing: true,

                serverSide: true,

                pageLength: 25,

                ajax: "{{ route('middle-banners.load') }}",

                columns:[

                    {

                        data: 'id',

                        name: 'id'

                    },

                    {

                        data: 'image',

                        name: 'image',

                        orderable: false,

                        searchable: false

                    },

                    // {

                    //     data: 'tag',

                    //     name: 'tag',

                    //     orderable: false,

                    //     searchable: false

                    // },

                    {

                        data: 'status',

                        name: 'status',

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



        // Function for Delete Middle Banner

        function deleteMiddleBanner(id){

            swal({

                title: "Are you sure You want to Delete It ?",

                icon: "warning",

                buttons: true,

                dangerMode: true,

            })

            .then((willDeleteBanner) => {

                if (willDeleteBanner){

                    $.ajax({

                        type: "POST",

                        url: "{{ route('middle-banners.destroy') }}",

                        data:{

                            "_token": "{{ csrf_token() }}",

                            'id': id,

                        },

                        dataType: 'JSON',

                        success: function(response){

                            if (response.success == 1){

                                swal(response.message, "", "success");

                                setTimeout(() => {

                                    location.reload();

                                }, 1200);

                            }else{

                                swal(response.message, "", "error");

                            }

                        }

                    });

                }else{

                    swal("Cancelled", "", "error");

                }

            });

        }



        // Function for Change Status of Middle Banner

        function changeStatus(id){

            $.ajax({

                type: "POST",

                url: "{{ route('middle-banners.status') }}",

                data:{

                    "_token": "{{ csrf_token() }}",

                    "id": id

                },

                dataType: 'JSON',

                success: function(response){

                    if (response.success == 1){

                        toastr.success(response.message);

                    }else{

                        toastr.error(response.message);

                    }

                }

            })

        }



    </script>

@endsection

