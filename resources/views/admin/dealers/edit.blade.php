@php

    $documents_errors = [];

    $documents_errors = $errors->toArray();

    if(isset($documents_errors['name'])){

        unset($documents_errors['name']);

    }

    if(isset($documents_errors['city'])){

        unset($documents_errors['city']);

    }

    if(isset($documents_errors['state'])){

        unset($documents_errors['state']);

    }

    if(isset($documents_errors['gst_no'])){

        unset($documents_errors['gst_no']);

    }

    if(isset($documents_errors['address'])){

        unset($documents_errors['address']);

    }

    if(isset($documents_errors['pincode'])){

        unset($documents_errors['pincode']);

    }

    if(isset($documents_errors['comapany_name'])){

        unset($documents_errors['comapany_name']);

    }

    if(isset($documents_errors['discount_value'])){

        unset($documents_errors['discount_value']);

    }

    if(isset($documents_errors['company_logo'])){

        unset($documents_errors['company_logo']);

    }

    if(isset($documents_errors['profile_picture'])){

        unset($documents_errors['profile_picture']);

    }

    if(isset($documents_errors['email'])){

        unset($documents_errors['email']);

    }

    if(isset($documents_errors['phone'])){

        unset($documents_errors['phone']);

    }

    if(isset($documents_errors['dealer_code'])){

        unset($documents_errors['dealer_code']);

    }

    if(isset($documents_errors['password'])){

        unset($documents_errors['password']);

    }

    if(isset($documents_errors['confirm_password'])){

        unset($documents_errors['confirm_password']);

    }
    if(isset($documents_errors['commission_value'])){

        unset($documents_errors['commission_value']);

    }

    if(isset($documents_errors['commission_days'])){

        unset($documents_errors['commission_days']);

    }


@endphp



@extends('admin.layouts.admin-layout')

@section('title', 'EDIT - DEALERS - IMPEL JEWELLERS')

@section('content')



    {{-- Page Title --}}

    <div class="pagetitle">

        <h1>Dealers</h1>

        <div class="row">

            <div class="col-md-8">

                <nav>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>

                        <li class="breadcrumb-item "><a href="{{ route('dealers.index') }}">Dealers</a></li>

                        <li class="breadcrumb-item active">Edit</li>

                    </ol>

                </nav>

            </div>

        </div>

    </div>



    {{-- Edit Dealer Form Section --}}

    <section class="section dashboard">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <form class="form" action="{{ route('dealers.update') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <input type="hidden" name="id" id="id" value="{{ encrypt($dealer->id) }}">

                        <div class="card-body">

                            <div class="form_box">

                                <div class="form_box_inr">

                                    <div class="box_title">

                                        <h2>Dealer Information</h2>

                                    </div>

                                    <div class="form_box_info">

                                        <div class="row">

                                            <div class="col-md-6 mb-3">

                                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>

                                                <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter Dealer Name" value="{{ old('name', $dealer->name) }}">

                                                @if ($errors->has('name'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('name') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="dealer_code" class="form-label">Discount Code <span class="text-danger">*</span></label>

                                                <input type="text" name="dealer_code" id="dealer_code" class="form-control {{ ($errors->has('dealer_code')) ? 'is-invalid' : '' }}" value="{{ old('dealer_code', $dealer->dealer_code) }}" placeholder="Enter Discount Code">

                                                @if ($errors->has('dealer_code'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('dealer_code') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="discount_type" class="form-label">Discount Type</label>

                                                <select name="discount_type" id="discount_type" class="form-select">

                                                    <option value="percentage" {{ (old('discount_type', $dealer->discount_type) == 'percentage') ? 'selected' : '' }}>Percentage</option>

                                                    <option value="fixed"  {{ (old('discount_type', $dealer->discount_type) == 'fixed') ? 'selected' : '' }}>Fixed</option>

                                                </select>

                                                @if ($errors->has('discount_type'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('discount_type') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="discount_value" class="form-label">Discount Value <span class="text-danger">*</span></label>

                                                <input type="number" name="discount_value" id="discount_value" class="form-control {{ ($errors->has('discount_value')) ? 'is-invalid' : '' }}" value="{{ old('discount_value', $dealer->discount_value) }}" placeholder="Enter Discount Value" inputmode="numeric">

                                                @if ($errors->has('discount_value'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('discount_value') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="commission_type" class="form-label">Commission Type</label>

                                                <select name="commission_type" id="commission_type" class="form-select">

                                                    <option value="percentage" {{ (old('commission_type', $dealer->commission_type) == 'percentage') ? 'selected' : '' }}>Percentage</option>

                                                    <option value="fixed"  {{ (old('commission_type', $dealer->commission_type) == 'fixed') ? 'selected' : '' }}>Fixed</option>

                                                </select>

                                                @if ($errors->has('commission_type'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('commission_type') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="commission_value" class="form-label">Commission Value <span class="text-danger">*</span></label>

                                                <input type="number" name="commission_value" id="commission_value" class="form-control {{ ($errors->has('commission_value')) ? 'is-invalid' : '' }}" value="{{ old('commission_value', $dealer->commission_value) }}" placeholder="Enter Commission Value" inputmode="numeric">

                                                @if ($errors->has('commission_value'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('commission_value') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="commission_days" class="form-label">Commission Days <span class="text-danger">*</span></label>

                                                <input type="number" name="commission_days" id="commission_days" class="form-control {{ ($errors->has('commission_days')) ? 'is-invalid' : '' }}" value="{{ old('commission_days', $dealer->commission_days) }}" placeholder="Enter Commission Days" inputmode="numeric">

                                                @if ($errors->has('commission_days'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('commission_days') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>

                                                <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Enter Dealer Email" value="{{ old('email', $dealer->email) }}">

                                                @if ($errors->has('email'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('email') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>

                                                <input type="number" name="phone" id="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" placeholder="Enter Dealer Phone" value="{{ old('phone', $dealer->phone) }}" inputmode="numeric">

                                                @if ($errors->has('phone'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('phone') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="ref_name" class="form-label">Reference Name</label>

                                                <input type="text" name="ref_name" id="ref_name" class="form-control" placeholder="Enter Reference Name" value="{{ old('ref_name', $dealer->ref_name) }}">

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>

                                                <textarea name="address" id="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" style="resize: none;" rows="5" placeholder="Enter Dealer Address">{{ old('address', $dealer->address) }}</textarea>

                                                @if ($errors->has('address'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('address') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="address" class="form-label">Pincode <span class="text-danger">*</span></label>

                                                <input type="text" name="pincode" id="pincode" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" value="{{ old('pincode', $dealer->pincode) }}" placeholder="Enter Dealer Pincode">

                                                @if ($errors->has('pincode'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('pincode') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="state" class="form-label">State <span class="text-danger">*</span></label>

                                                <select name="state" id="state" class="form-select {{ ($errors->has('state')) ? 'is-invalid' : '' }}">

                                                    <option value="">Choose State</option>

                                                    @if (count($states) > 0)

                                                        @foreach ($states as $state)

                                                            <option value="{{ $state->id }}" {{ ($dealer->state == $state->id) ? 'selected' : '' }}>{{ $state->name }}</option>

                                                        @endforeach

                                                    @endif

                                                </select>

                                                @if ($errors->has('state'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('state') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>

                                                <select name="city" id="city" class="form-select {{ ($errors->has('city')) ? 'is-invalid' : '' }}">

                                                    <option value="">Choose City</option>

                                                    @if(count($cities) > 0)

                                                        @foreach ($cities as $city)

                                                            <option value="{{ $city->id }}" {{ ($dealer->city == $city->id) ? 'selected' : '' }}>{{ $city->name }}</option>

                                                        @endforeach

                                                    @endif

                                                </select>

                                                @if ($errors->has('city'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('city') }}

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="form_box_inr">

                                    <div class="box_title">

                                        <h2>Company Information</h2>

                                    </div>

                                    <div class="form_box_info">

                                        <div class="row">

                                            <div class="col-md-6 mb-3">

                                                <label for="comapany_name" class="form-label">Company Name </label>

                                                <input type="text" name="comapany_name" id="comapany_name" class="form-control {{ $errors->has('comapany_name') ? 'is-invalid' : '' }}" placeholder="Enter Company Name" value="{{ old('comapany_name', $dealer->comapany_name) }}">

                                                @if ($errors->has('comapany_name'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('comapany_name') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="gst_no" class="form-label">GST No.</label>

                                                <input type="text" name="gst_no" id="gst_no" class="form-control {{ $errors->has('gst_no') ? 'is-invalid' : '' }}" placeholder="Enter GST No." value="{{ old('gst_no', $dealer->gst_no) }}">

                                                @if ($errors->has('gst_no'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('gst_no') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="password" class="form-label">Password</label>

                                                <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" placeholder="Enter Password">

                                                @if ($errors->has('password'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('password') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="confirm_password" class="form-label">Confirm Password</label>

                                                <input type="password" name="confirm_password" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" id="confirm_password" placeholder="Enter Confirm Password">

                                                @if ($errors->has('confirm_password'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('confirm_password') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="whatsapp_no" class="form-label">Specific Whatsapp No.</label>

                                                <input type="number" name="whatsapp_no" class="form-control" id="whatsapp_no" placeholder="Enter Specific Whatsapp No." value="{{ old('whatsapp_no', $dealer->whatsapp_no) }}" inputmode="numeric">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="form_box_inr">

                                    <div class="box_title">

                                        <h2>Dealer Documents, Image & Company Logo Information</h2>

                                    </div>

                                    <div class="form_box_info">

                                        <div class="row">

                                            <div class="col-md-6 mb-3">

                                                <label for="profile_picture" class="form-label">Profile Picture</label>

                                                <input type="file" name="profile_picture" id="profile_picture" class="form-control {{ $errors->has('profile_picture') ? 'is-invalid' : '' }}">

                                                @if ($errors->has('profile_picture'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('profile_picture') }}

                                                    </div>

                                                @endif

                                                @if(isset($dealer->profile) && !empty($dealer->profile) && file_exists('public/images/uploads/user_images/'.$dealer->profile))

                                                    <div class="mt-2">

                                                        <img src="{{ asset('public/images/uploads/user_images/'.$dealer->profile) }}" width="100">

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="company_logo" class="form-label">Company Logo</label>

                                                <input type="file" name="company_logo" id="company_logo" class="form-control {{ $errors->has('company_logo') ? 'is-invalid' : '' }}">

                                                @if ($errors->has('company_logo'))

                                                    <div class="invalid-feedback">

                                                        {{ $errors->first('company_logo') }}

                                                    </div>

                                                @endif

                                                @if(isset($dealer->company_logo) && !empty($dealer->company_logo) && file_exists('public/images/uploads/companies_logos/'.$dealer->company_logo))

                                                    <div class="mt-2">

                                                        <img src="{{ asset('public/images/uploads/companies_logos/'.$dealer->company_logo) }}" width="100">

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="col-md-6">

                                                <label for="documents" class="form-label">Documents</label>

                                                <input type="file" name="documents[]" id="documents" class="form-control {{ (count($documents_errors) > 0) ? 'is-invalid' : '' }}" multiple>

                                                @if(count($documents_errors))

                                                    @foreach ($documents_errors as $document_error)

                                                        @if(count($document_error) > 0)

                                                            @foreach ($document_error as $error_val)

                                                                <div class="invalid-feedback">

                                                                    {{ $error_val }}

                                                                </div>

                                                            @endforeach

                                                        @endif

                                                    @endforeach

                                                @endif

                                                @if(isset($dealer->document) && count($dealer->document) > 0)

                                                    <div class="div mt-3">

                                                        @foreach ($dealer->document as $document)

                                                            @if(isset($document->document) && file_exists('public/images/uploads/documents/'.$document->document))

                                                                <a href="{{ asset('public/images/uploads/documents/'.$document->document) }}" target="_blank">Document {{ $loop->iteration }}</a> <hr>

                                                            @endif

                                                        @endforeach

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="card-footer text-center">

                            <button class="btn form_button">Update</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </section>



@endsection



@section('page-js')

<script type="text/javascript">



    // Get Cities When Change State

    $('#state').on('change', function() {

        $.ajax({

            type: "POST",

            url: "{{ route('states.cities') }}",

            data: {

                "_token": "{{ csrf_token() }}",

                "state_id": $(this).val(),

            },

            dataType: "JSON",

            success: function(response) {

                if (response.success == 1) {

                    $('#city').html('');

                    $('#city').append(response.cities);

                } else {

                    toastr.error(response.message);

                    setTimeout(() => {

                        location.reload();

                    }, 1200);

                }

            }

        });

    });



</script>

@endsection

