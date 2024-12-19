@extends('admin.layouts.admin-layout')

@section('title', 'COMPANYMASTER - IMPEL JEWELLERS')

@section('content')
    {{-- Modal for Add New Comapny master & Edit Comapny master --}}
    <div class="modal fade" id="companyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CompanyModalLabel" aria-hidden="true">
        <div class="modal-dialog desktop_modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CompanyModalLabel">Edit Company Master</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="javascript:void(0)" class="form" id="CompanyForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>Comapny Master Details</h2>
                               </div>
                                <div class="form_box_info">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Company Master ID <span class="text-danger">*</span></label>
                                                <input type="text" name="company_tag_id" id="company_tag_id" class="form-control" placeholder="Comapny Master Tag">
                                                @if ($errors->has('company_tag_id'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('company_tag_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                                <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter Comapny Master">
                                                @if ($errors->has('company_name'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('company_name') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a onclick="saveUpdateCompany('add')" class="btn form_button" id="saveupdatebtn">Save</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Company Master</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Company Master</li>
                    </ol>
                </nav>
            </div>
                <div class="col-md-4" style="text-align: right;">
                    <a data-bs-toggle="modal" data-bs-target="#companyModal" class="btn btn-sm new-company custom-btn">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                </div>
        </div>
    </div>

    {{-- Comapny Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="CompanyMasterTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Company Tag Id</th>
                                        <th>Company Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($companymaster))
                                        @foreach ($companymaster as $company)
                                            <tr>
                                                <td>{{ $company->id }}</td>
                                                <td>{{ $company->company_tag_id }}</td>
                                                <td>{{ $company->company_name }}</td>
                                                    <td>
                                                        @can('comapny.master.edit')
                                                            <a onclick="editCompany('{{ encrypt($company->id) }}')" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>
                                                        @endcan

                                                        @can('comapny.master.destroy')
                                                            <a onclick="deleteCompany('{{ encrypt($company->id) }}')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>
                                                            <a href="{{ route('comapny.master.show', encrypt($company->company_tag_id)) }}" class="btn btn-sm custom-btn"><i class="fa-solid fa-eye"></i></a>
                                                        @endcan
                                                    </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
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
        $(document).ready(function(){
            $('#CompanyMasterTable').DataTable({
                "ordering": false,
                "pageLength" : 50
            });
        });


         // Reset Category Modal

         $('.new-company').on('click', function(){
            // Reset CompanyForm
            $('#CompanyForm').trigger('reset');

            // Empty Comapny ID
            var checkbox = $('#id').val();


            // Remove Validation Class
            $('#company_name').removeClass('is-invalid');
            $('#company_tag_id').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            // Change Modal Title
            $('#companyModalLabel').html('');
            $('#companyModalLabel').append('New Company Master');


            // Chage Button Name
            $('#saveupdatebtn').html('');
            $('#saveupdatebtn').append('Save');

            // Change Button Value
            $('#saveupdatebtn').attr('onclick', "saveUpdateCompany('add')");
        });

        // Function for Edit Company
        function editCompany(id){
            // Reset CompanyForm
            $('#CompanyForm').trigger('reset');

            // Remove Validation Class
            $('#company_name').removeClass('is-invalid');
            $('#company_tag_id').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();
            $.ajax({
                type: "POST",
                url: "{{ route('comapny.master.edit') }}",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': id,
                },
                success: function(response){
                    if (response.success) {
                        // Company Data's
                        const company = response.data;

                        // Add values in CouponForm
                        $('#company_name').val(company.company_name);
                        $('#company_tag_id').val(company.company_tag_id);
                        $('#id').val(company.id);

                        // Change Modal Title

                        $('#CompanyModalLabel').html('');
                        $('#CompanyModalLabel').append('Edit Comapny Master');

                        // Chage Button Name

                        $('#saveupdatebtn').html('');
                        $('#saveupdatebtn').append('Update');


                        // Show Modal
                        $('#companyModal').modal('show');
                        // Change Button Value
                        $('#saveupdatebtn').attr('onclick', "saveUpdateCompany('edit')");
                    }else{
                        toastr.error(response.message);
                    }
                }
            });
        }

        // Function for Save & Update Company
        function saveUpdateCompany(type)
        {
            // Data Type (Save/Update)
            var dType = type;
            if (dType == 'add'){
                var redirectUrl = "{{ route('comapny.master.store') }}";
            }
            else{
                var redirectUrl = "{{ route('comapny.master.update') }}";
            }


            // Get all form data from CouponForm
            myFormData = new FormData(document.getElementById('CompanyForm'));

            // Remove Validation Class
            $('#company_name').removeClass('is-invalid');
            $('#company_tag_id').removeClass('is-invalid');
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
                    if (response.success){
                        $('#CompanyForm').trigger('reset');
                        $('#companyModal').modal('hide');
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1200);
                    }else{
                        $('#CompanyForm').trigger('reset');
                        $('#companyModal').modal('hide');
                        toastr.error(response.message);
                    }
                },
                error: function(response){
                    // All Validation Errors
                    const validationErrors = (response?.responseJSON?.errors) ? response.responseJSON.errors : '';

                    if (validationErrors != ''){
                        //Company Master Name Error
                        var nameError = (validationErrors.company_name) ? validationErrors.company_name : '';
                        if (nameError != ''){
                            $('#company_name').addClass('is-invalid');
                            toastr.error(nameError);
                        }

                        // Company Master Tag Error
                        var nameError = (validationErrors.company_tag_id) ? validationErrors.company_tag_id : '';
                        if (nameError != ''){
                            $('#company_tag_id').addClass('is-invalid');
                            toastr.error(nameError);
                        }
                    }
                }
            });
        }

        function deleteCompany(id){
            swal({
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((deleteCompany) =>{
                if(deleteCompany){
                    $.ajax({
                        url:"{{ route('comapny.master.destroy') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                        },
                        success: function(response){
                            if(response.success == 1){
                                swal(response.message, "", "success");
                                setTimeout(() => {
                                    location.reload();
                                }, 1300);
                            }else{
                                swal(response.message, "", "error");
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
