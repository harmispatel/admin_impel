@extends('admin.layouts.admin-layout')

@section('title', 'BOTTOM BANNERS - IMPEL JEWELLERS')

@section('content')



    {{-- Page Title --}}

    <div class="pagetitle">

        <h1>Bottom Banners</h1>

        <div class="row">

            <div class="col-md-8">

                <nav>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

                        <li class="breadcrumb-item active">Bottom Banners</li>

                    </ol>

                </nav>

            </div>

            @if($total_bottom_banner < 1)

                @can('bottom-banners.create')

                    <div class="col-md-4" style="text-align: right;">

                        <a href="{{ route('bottom-banners.create') }}" class="btn btn-sm custom-btn"><i class="bi bi-plus"></i></a>

                    </div>

                @endcan

            @endif

        </div>

    </div>



    {{-- Bottom Banners Section --}}

    <section class="section dashboard">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive custom_dt_table">

                            <table class="table w-100" id="bottomBannersTable">

                                <thead>

                                    <tr>

                                        <th>Sr</th>

                                        <th>Banner</th>
<!-- 
                                        <th>Tag</th> -->

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



        // Load all Bottom Banners When Page Reload

        loadBottomBanners();



        // Function for Load Bottom Banners

        function loadBottomBanners(){

            var bottomBannersTable = $('#bottomBannersTable').DataTable();

            // Destroy Old Table

            bottomBannersTable.destroy();

            // Load New Table

            bottomBannersTable = $('#bottomBannersTable').DataTable({

                processing: true,

                serverSide: true,

                pageLength: 25,

                ajax: "{{ route('bottom-banners.load') }}",

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



        // Function for Delete Bottom Banner

        function deleteBottomBanner(id){

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

                        url: "{{ route('bottom-banners.destroy') }}",

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



        // Function for Change Status of Bottom Banner

        function changeStatus(id){

            $.ajax({

                type: "POST",

                url: "{{ route('bottom-banners.status') }}",

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

