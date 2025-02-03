@extends('admin.layouts.admin-layout')
@section('title', 'Data management form - IMPEL JEWELLERS')
@section('content')

<div class="pagetitle">
        <h1>Data Management Form</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Management Form</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white" style="background-color: #012970!important;">
                    <h4 class="card-title p-0 mb-0 text-white">Data Management Form</h4>
                </div>
                <div class="card-body">
                    <form action="" method="post" id="survayForm">
                        @csrf
                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label"><b>Name</b></label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" required>
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <!-- Mobile No with Verify OTP Button -->
                        <div class="mb-3">
                            <label for="mobile" class="form-label"><b>Mobile No</b></label>
                            <div class="input-group">
                                <input type="tel" name="number" class="form-control" id="number" placeholder="Enter your mobile number">
                                <button type="button" class="btn btn-outline-secondary" onclick="sendOtpBottom()" id="verifyOtpBtn">Send OTP</button>
                            </div>
                            @if ($errors->has('number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('number') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3" id="verifyOtp" style="display: none;">
                            <div class="input-group">
                                <input type="number" name="otp" class="form-control" id="otp" placeholder="Please Enter 6-Digin otp">
                                <button type="button" class="btn btn-outline-secondary" onclick="verifyOtpBottom()" id="verifyOtpBtn">Verify OTP</button>
                                @if ($errors->has('otp'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('otp') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Flat No Field -->
                        <div class="mb-3">
                            <label for="flatNo" class="form-label"><b>Flat No</b></label>
                            <input type="text" name="flat_no" class="form-control" id="flat_no" value="{{ $data->flat_no }}" placeholder="Enter your flat number" required>
                            @if ($errors->has('flat_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('flat_no') }}
                                </div>
                            @endif
                        </div>

                        <!-- Society Name Field -->
                        <div class="mb-3">
                            <label for="society" class="form-label"><b>Society Name</b></label>
                            <input type="text" name="society" class="form-control" id="society" value="{{ $data->society }}" placeholder="Enter your society name" required>
                            @if ($errors->has('society'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('society') }}
                                </div>
                            @endif
                        </div>

                        <!-- Area Name Field -->
                        <div class="mb-3">
                            <label for="area" class="form-label"><b>Area Name</b></label>
                            <input type="text" name="area" class="form-control" id="area" value="{{ $data->area }}" placeholder="Enter your area name" required>
                            @if ($errors->has('area'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('area') }}
                                </div>
                            @endif
                        </div>

                        <!-- City Name Field -->
                        <div class="mb-3">
                            <label for="city" class="form-label"><b>City Name</b></label>
                            <input type="text" name="city" class="form-control" id="city" value="{{ $data->city }}" placeholder="Enter your city name" required>
                            @if ($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                        </div>

                        <!-- State Name Field -->
                        <div class="mb-3">
                            <label for="state" class="form-label"><b>State Name</b></label>
                            <input type="text" name="state" class="form-control" id="state" value="{{ $data->state }}">
                            @if ($errors->has('state'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('state') }}
                                </div>
                            @endif
                        </div>

                        <!--Coupen -->
                        <div class="mb-3">
                            <label for="coupen" class="form-label"><b>Coupen</b></label>
                            <div class="input-group">
                                <input type="tel" name="coupen" class="form-control" id="coupen" value="{{ $data->coupen }}">
                            </div>
                            @if ($errors->has('coupen'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('coupen') }}
                                </div>
                            @endif
                        </div>

                        <!--link -->
                        <div class="mb-3">
                            <label for="link" class="form-label"><b>Link</b></label>
                            <div class="input-group">
                                <input type="tel" name="link" class="form-control" id="link" value="{{ $data->link }}">
                            </div>
                            @if ($errors->has('link'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('link') }}
                                </div>
                            @endif
                        </div>

                         <!--Coupen -->
                         <div class="mb-3">
                            <label for="discount" class="form-label"><b>discount</b></label>
                            <div class="input-group">
                                <input type="tel" name="discount" class="form-control" id="discount" value="{{ $data->discount }}">
                            </div>
                            @if ($errors->has('discount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('discount') }}
                                </div>
                            @endif
                        </div>

                        <!-- Share Message -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-success" onclick="sendOfferMessage()" id="verifyOtpBtn">Offer Message</button>
                            <button type="button" class="btn btn-success" onclick="sendSocialMediaMessage()" id="verifyOtpBtn">Share Social Media Message</button>
                        </div>


                        <!-- Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a onclick="SubmitSurvayForm()" class="btn form_button" id="saveupdatebtn">Save</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-js')
<script type="text/javascript">
    function sendOtpBottom() {
        const mobileNumber = document.getElementById('number').value;

        $.ajax({
            type: "POST",
            url: "{{ route('send.otp') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'number': mobileNumber,
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success == 1) {
                    toastr.success(response.message);
                    $('#verifyOtp').removeAttr('style');
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                console.error(error);
                toastr.error("Something went wrong.");
            }
        });
    }

    function verifyOtpBottom() {
        const mobileNumber = document.getElementById('number').value;
        const otp = document.getElementById('otp').value;

        $.ajax({
            type: "POST",
            url: "{{ route('survay.withotp') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'number': mobileNumber,
                'otp': otp
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success == 1) {
                    $('#verifyOtp').css('display', 'none');
                    swal(response.message, "", "success");
                } else {
                    swal(response.message, "", "error");
                }
            },
            error: function(error) {
                console.error(error);
                toastr.error("Something went wrong.");
            }
        });
    }

    function sendOfferMessage() {
        const mobileNumber = document.getElementById('number').value;
        const discount = document.getElementById('discount').value;
        const coupen = document.getElementById('coupen').value;
        $.ajax({
            type: "POST",
            url: "{{ route('offer.message') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'number': mobileNumber,
                'discount' : discount,
                'coupen' : coupen
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success == 1) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                console.error(error);
                toastr.error("Something went wrong.");
            }
        });
    }

    function sendSocialMediaMessage() {
        const link = document.getElementById('link').value;
        const mobileNumber = document.getElementById('number').value;
        $.ajax({
            type: "POST",
            url: "{{ route('connect.message') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'number': mobileNumber,
                'link':link
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success == 1) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                console.error(error);
                toastr.error("Something went wrong.");
            }
        });
    }

    // Function for Save & Update Company
    function SubmitSurvayForm() {
        
        myFormData = new FormData(document.getElementById('survayForm'));

        // Remove Validation Class
        // $('#company_name').removeClass('is-invalid');
        // $('#company_tag_id').removeClass('is-invalid');
        // Clear all Toastr Messages
        toastr.clear();

        $.ajax({
            type: "POST",
            url: "{{ route('survar.store') }}",
            data: myFormData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "JSON",
            success: function(response) {
                if (response.success) {
                    $('#CompanyForm').trigger('reset');
                    $('#companyModal').modal('hide');
                    toastr.success(response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1200);
                } else {
                    $('#CompanyForm').trigger('reset');
                    $('#companyModal').modal('hide');
                    toastr.error(response.message);
                }
            },
            error: function(response) {
                // All Validation Errors
                const validationErrors = (response?.responseJSON?.errors) ? response.responseJSON.errors : '';

                if (validationErrors != '') {
                    
                    var nameError = (validationErrors.name) ? validationErrors.name : '';
                    if (nameError != '') {
                        $('#name').addClass('is-invalid');
                        toastr.error(nameError);
                    }

                    var cityError = (validationErrors.city) ? validationErrors.city : '';
                    if (cityError != '') {
                        $('#city').addClass('is-invalid');
                        toastr.error(cityError);
                    }

                    var numberError = (validationErrors.number) ? validationErrors.number : '';
                    if (numberError != '') {
                        $('#number').addClass('is-invalid');
                        toastr.error(numberError);
                    }
                    var stateError = (validationErrors.state) ? validationErrors.state : '';
                    if (stateError != '') {
                        $('#state').addClass('is-invalid');
                        toastr.error(stateError);
                    }
                    var coupenError = (validationErrors.coupen) ? validationErrors.coupen : '';
                    if (coupenError != '') {
                        $('#coupen').addClass('is-invalid');
                        toastr.error(coupenError);
                    }
                    var discountError = (validationErrors.discount) ? validationErrors.discount : '';
                    if (discountError != '') {
                        $('#discount').addClass('is-invalid');
                        toastr.error(discountError);
                    }
                    var linkError = (validationErrors.link) ? validationErrors.link : '';
                    if (linkError != '') {
                        $('#link').addClass('is-invalid');
                        toastr.error(linkError);
                    }
                    var flat_noError = (validationErrors.flat_no) ? validationErrors.flat_no : '';
                    if (flat_noError != '') {
                        $('#flat_no').addClass('is-invalid');
                        toastr.error(flat_noError);
                    }
                    var societyError = (validationErrors.society) ? validationErrors.society : '';
                    if (societyError != '') {
                        $('#society').addClass('is-invalid');
                        toastr.error(societyError);
                    }
                    var areaError = (validationErrors.area) ? validationErrors.area : '';
                    if (areaError != '') {
                        $('#area').addClass('is-invalid');
                        toastr.error(areaError);
                    }
                }
            }
        });
    }
</script>
@endsection