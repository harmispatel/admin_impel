@extends('admin.layouts.admin-layout')
@section('title', 'TESTIMONIALS - IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Testimonials</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Testimonials</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('testimonials.create') }}" class="btn btn-sm custom-btn"><i class="bi bi-plus"></i></a>
            </div>
        </div>
    </div>

    {{-- Testimonials Section --}}
    <section class="section testimonials">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                            <table class="table w-100" id="TestimonialsTable">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Customer</th>
                                        <th style="width: 35%">Message</th>
                                        <th>Image</th>
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

        // Load all Testimonials When Page Reload
        loadTestimonials();

        // Function for Load Testimonials
        function loadTestimonials() {
            var TestimonialsTable = $('#TestimonialsTable').DataTable();
            // Destroy Old Table
            TestimonialsTable.destroy();
            // Load New Table
            TestimonialsTable = $('#TestimonialsTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: "{{ route('testimonials.load') }}",
                columns:[
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        searchable: false
                    },
                    {
                        data: 'message',
                        name: 'message',
                        orderable: false,
                        searchable: false
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
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        }

        // Function for Delete Testimonial
        function deleteTestimonial(id){
            swal({
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDeleteTestimonial) => {
                if (willDeleteTestimonial){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('testimonials.destroy') }}",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                        },
                        dataType: 'JSON',
                        success: function(response){
                            if (response.success == 1){
                                swal(response.message, "", "success");
                                $('#TestimonialsTable').DataTable().ajax.reload();
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

        // Function for Change Status of Testimonial
        function changeStatus(id){
            $.ajax({
                type: "POST",
                url: "{{ route('testimonials.status') }}",
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
