@extends('admin.layouts.admin-layout')

@section('title',' PAGES - IMPEL JEWELLERS')

@section('content')



{{-- Page Title --}}

<div class="pagetitle">

    <h1>Pages</h1>

    <div class="row">

        <div class="col-md-8">

            <nav>

                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Pages</li>

                </ol>

            </nav>

        </div>

    </div>

</div>



{{-- Pages Section --}}

<section class="section dashboard">

    <div class="row">

        <div class="col-md-12 mb-3 text-end">

            <a href="{{ route('pages.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus"></i></a>

        </div>

        <div class="col-md-12">

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive custom_dt_table">

                        <table class="table w-100" id="pagesTable">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Page Name</th>

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



        // Load All Pages

        $(function() {

            var table = $('#pagesTable').DataTable({

                processing: true,

                serverSide: true,

                pageLength: 100,

                ajax: "{{ route('pages.load') }}",

                columns: [{

                        data: 'id',

                        name: 'id',

                        orderable: false,

                        searchable: false,

                    },

                    {

                        data: 'name',

                        name: 'name',

                        searchable: true

                    },

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



        });



        // Function for Change Status of Top Banner

        function changeStatus(id){

            $.ajax({

                type: "POST",

                url: "{{ route('pages.status') }}",

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

