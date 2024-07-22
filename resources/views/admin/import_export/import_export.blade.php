@extends('admin.layouts.admin-layout')

@section('title', 'Impel Jewellers | Imports & Exports')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Import & Export</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">Imports & Exports</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    {{-- New Import Export Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12 text-end">
                                        <a href="{{ asset('public/files/demo_files/design_import_demo.xlsx') }}" class="btn btn-sm btn-primary" download><i class="fa fa-download"></i> Download Demo File</a>
                                        <a href="{{ route('export.designs') }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-file-export"></i> Export</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <form class="form" id="ImportForm" action="javascript:void(0)" enctype="multipart/form-data">
                                        <div class="col-md-12">
                                            @csrf
                                            <div class="form_box">
                                                <div class="form_box_inr">
                                                    <div class="box_title">
                                                        <h2>Import / Export Information</h2>
                                                    </div>
                                                    <div class="form_box_info">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="import_file" class="form-label">Import File <span class="text-danger">*</span></label>
                                                                <input type="file" name="import_file" id="import_file" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a class="btn btn-sm btn-success" id="import-btn">Import</a>
                                                                <button class="btn btn-sm btn-success" id="import-btn-spin" type="button" disabled style="display: none;">
                                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                    Importing...
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-js')
    <script type="text/javascript">

            // Toastr Options
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": 10000
            }

            @if (Session::has('success'))
                toastr.success('{{ Session::get('success') }}')
            @endif

            // Import Design
            $('#import-btn').on('click', function(){

                // Remove Validation Class
                $('#import_file').removeClass('is-invalid');

                // Clear all Toastr Messages
                toastr.clear();

                myFormData = new FormData(document.getElementById('ImportForm'));

                $.ajax({
                    type: "POST",
                    url: "{{ route('import.designs') }}",
                    beforeSend: function(){
                        $('#import-btn').hide();
                        $('#import-btn-spin').show();
                    },
                    data: myFormData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response)
                    {
                        if (response.success == 1)
                        {
                            $('#import-btn').show();
                            $('#import-btn-spin').hide();
                            $('#ImportForm').trigger('reset');
                            toastr.success(response.message);
                        }
                        else
                        {
                            $('#import-btn').show();
                            $('#import-btn-spin').hide();
                            $('#ImportForm').trigger('reset');
                            toastr.error(response.message);
                        }
                    },
                    error: function(response)
                    {
                        $('#import-btn').show();
                        $('#import-btn-spin').hide();
                        // All Validation Errors
                        const validationErrors = (response?.responseJSON?.errors) ? response.responseJSON.errors : '';

                        if (validationErrors != '')
                        {
                            // File Error
                            var fileError = (validationErrors.import_file) ? validationErrors.import_file : '';
                            if (fileError != '')
                            {
                                $('#import_file').addClass('is-invalid');
                                toastr.error(fileError);
                            }
                        }
                    }
                });

            });

    </script>
@endsection
