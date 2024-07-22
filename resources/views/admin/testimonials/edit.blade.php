@extends('admin.layouts.admin-layout')
@section('title', 'EDIT - TESTIMONIALS - IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Testimonials</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('testimonials.index') }}">Testimonials</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    {{-- Edit Testimonials Section --}}
    <section class="section testimonials">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('testimonials.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ encrypt($testimonial->id) }}">
                        <div class="card-body">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Testimonials Details</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="customer" class="form-label">Customer Name <span class="text-danger">*</span></label>
                                                <input type="text" name="customer" id="customer" placeholder="Enter Customer Name" class="form-control {{ ($errors->has('customer')) ? 'is-invalid' : '' }}" value="{{ old('customer', $testimonial->customer) }}">
                                                @if($errors->has('customer'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('customer') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" name="image" id="image" class="form-control {{ ($errors->has('image')) ? 'is-invalid' : '' }}">
                                                @if($errors->has('image'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('image') }}
                                                    </div>
                                                @endif
                                                @if(isset($testimonial->image) && !empty($testimonial->image) && file_exists('public/images/uploads/testimonials_users/'.$testimonial->image))
                                                    <div class="mt-3">
                                                        <img src="{{ asset('public/images/uploads/testimonials_users/'.$testimonial->image) }}" alt="Customer Image" width="100">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                                <textarea name="message" id="message" rows="5" class="form-control {{ ($errors->has('message')) ? 'is-invalid' : '' }}">{{ $testimonial->message }}</textarea>
                                                @if($errors->has('message'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('message') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn form_button">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
