@extends('admin.layouts.admin-layout')
@section('title', 'TAGS - IMPEL JEWELLERS')
@section('content')

    {{-- Modal for Add New Tag & Edit Tag --}}
    <div class="modal fade" id="tagModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tagModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tagModalLabel">New Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="javascript:void(0)" class="form" id="TagForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Tag Name">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a onclick="saveUpdateTag('add')" class="btn btn-success" id="saveupdatebtn">Save</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Tags</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tags</li>
                    </ol>
                </nav>
            </div>
            {{-- <div class="col-md-4" style="text-align: right;">
                <a data-bs-toggle="modal" data-bs-target="#tagModal" class="btn btn-sm new-tag custom-btn">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div> --}}
        </div>
    </div>

    {{-- Tags Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                            <table class="table w-100" id="TagsTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th style="width: 40%">Name</th>
                                        <th>Status</th>
                                        <th>Display on Header</th>
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

        // Reset Tag Modal
        $('.new-tag').on('click', function(){
            // Reset TagForm
            $('#TagForm').trigger('reset');

            // Empty Tag ID
            $('#id').val('');

            // Remove Validation Class
            $('#name').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            // Change Modal Title
            $('#tagModalLabel').html('');
            $('#tagModalLabel').append('New Tag');

            // Chage Button Name
            $('#saveupdatebtn').html('');
            $('#saveupdatebtn').addClass('custom-btn');
            $('#saveupdatebtn').append('Save');

            // Change Button Value
            $('#saveupdatebtn').attr('onclick', "saveUpdateTag('add')");
        });

        // Load all Tags Records
        loadTags();
        // Function for get all Tags Records.
        function loadTags(){
            // Assign Tags Table to Variable;
            var tagsTable = $('#TagsTable').DataTable();

            // Destroy old Data
            tagsTable.destroy();

            // ReGenerate Tags Table
            tagsTable = $('#TagsTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: "{{ route('tags.load') }}",
                columns:[
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'display_on_header',
                        name: 'display_on_header',
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
        }

        // Function for Save & Update Tags
        function saveUpdateTag(type){
            // Data Type (Save/Update)
            var dType = type;
            if (dType == 'add'){
                var redirectUrl = "{{ route('tags.store') }}";
            }else{
                var redirectUrl = "{{ route('tags.update') }}";
            }

            // Get all form data from TagForm
            myFormData = new FormData(document.getElementById('TagForm'));

            // Remove Validation Class
            $('#name').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: redirectUrl,
                data: myFormData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function(response){
                    if (response.success == 1){
                        $('#TagForm').trigger('reset');
                        $('#tagModal').modal('hide');
                        toastr.success(response.message);
                        loadTags();
                    }else{
                        $('#TagForm').trigger('reset');
                        $('#tagModal').modal('hide');
                        toastr.error(response.message);
                    }
                },
                error: function(response){
                    // All Validation Errors
                    const validationErrors = (response?.responseJSON?.errors) ? response.responseJSON.errors : '';

                    if (validationErrors != ''){
                        // Name Error
                        var nameError = (validationErrors.name) ? validationErrors.name : '';
                        if (nameError != ''){
                            $('#name').addClass('is-invalid');
                            toastr.error(nameError);
                        }
                    }
                }
            });
        }

        // Function for Edit Tag
        function editTag(id){
            // Reset TagForm
            $('#TagForm').trigger('reset');

            // Remove Validation Class
            $('#name').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('tags.edit') }}",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': id,
                },
                success: function(response){
                    if (response.success){
                        // Tags Data's
                        const tags = response.data;

                        // Add values in TagForm
                        $('#name').val(tags.name);
                        $('#id').val(tags.id);

                        // Change Modal Title
                        $('#tagModalLabel').html('');
                        $('#tagModalLabel').append('Edit Tag');

                        // Chage Button Name
                        $('#saveupdatebtn').html('');
                        $('#saveupdatebtn').append('Update');

                        // Show Modal
                        $('#tagModal').modal('show');

                        // Change Button Value
                        $('#saveupdatebtn').attr('onclick', "saveUpdateTag('edit')");
                    }else{
                        toastr.error(response.message);
                    }
                }
            });
        }

        // Function for Delete Tags
        function deleteTag(id){
            swal({
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDeleteTag) => {
                if (willDeleteTag){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('tags.destroy') }}",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                        },
                        dataType: 'JSON',
                        success: function(response){
                            if (response.success == 1){
                                swal(response.message, "", "success");
                                $('#TagsTable').DataTable().ajax.reload();
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

        // Function for change status of Tag
        function changeStatus(id){
            toastr.clear();
            $.ajax({
                type: "POST",
                url: "{{ route('tags.status') }}",
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

        // Function for Change Display on Header Status
        function displayHeaderStatus(id){
            toastr.clear();
            $.ajax({
                type: "POST",
                url: "{{ route('tags.header.status') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'JSON',
                success: function(response){
                    if (response.success == 1){
                        toastr.success(response.message);
                    }
                    else{
                        toastr.error(response.message);
                    }
                }
            })
        }

    </script>


@endsection
