@extends('admin.layouts.admin-layout')
@section('title', 'EDIT - USERS - IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Users</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Edit Users Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{encrypt($user->id)}}">
                        <div class="card-body">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>User Details</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" name="firstname" id="firstname" value="{{ old('firstname', $user->firstname)}}" class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" placeholder="Enter First Name">
                                                @if ($errors->has('firstname'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('firstname') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for = "lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" name="lastname" id="lastname" value="{{old('lastname', $user->lastname)}}" class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" placeholder="Enter User Name">
                                                @if ($errors->has('lastname'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('lastname') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" id="email" value="{{old('email', $user->email)}}" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" placeholder="Enter Email">
                                                @if ($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="phone" class="form-label">Phone No.</label>
                                                <input type="number" name="phone" id="phone" value="{{old('phone', $user->phone)}}" class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}" placeholder="Enter Phone Number">
                                                @if ($errors->has('phone'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('phone') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" name="password" id="password" value="{{old('password')}}" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Enter Password">
                                                @if ($errors->has('password'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('password') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                                <input type="password" name="confirm_password" id="confirm_password" value="{{old('confirm_password')}}" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : ''}}" placeholder="Enter Confirm Password">
                                                @if ($errors->has('confirm_password'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('confirm_password') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                                <select name="role" id="role" name="role" class="form-select {{ ($errors->has('role')) ? 'is-invalid' : '' }}" {{ ($user->id == 1) ? 'disabled' : '' }}>
                                                    <option value="">Select Role</option>
                                                    @if(count($roles) > 0)
                                                        @foreach ($roles as $role)
                                                            <option value="{{$role->id}}" {{ (old('role', $user->user_type) == $role->id) ? "selected" :""}}>{{ $role->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('role'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('role') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>User Image</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="image" class="form-label">Image </label>
                                                <input type="file" name="image" class="form-control {{ ($errors->has('image')) ? 'is-invalid' : '' }}">
                                                @if ($errors->has('image'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('image') }}
                                                    </div>
                                                @endif
                                                @if (isset($user->image) && !empty($user->image) && file_exists('public/images/uploads/user_images/'.$user->image))
                                                    <div class="mt-3">
                                                        <img src="{{ asset('public/images/uploads/user_images/'.$user->image) }}" width="100">
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
