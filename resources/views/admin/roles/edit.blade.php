@extends('admin.layouts.admin-layout')

@section('title', 'EDIT - ROLES - IMPEL JEWELLERS')

@section('content')



    {{-- Page Title --}}

    <div class="pagetitle">

        <h1>Roles</h1>

        <div class="row">

            <div class="col-md-8">

                <nav>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>

                        <li class="breadcrumb-item active">Edit</li>

                    </ol>

                </nav>

            </div>

        </div>

    </div>



    {{-- Edit Role Section --}}

    <section class="section dashboard">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <form action="{{ route('roles.update') }}" method="POST" enctype="multipart/form-data">

                            @csrf

                            <input type="hidden" name="id" id="id" value="{{ encrypt($role->id) }}">

                            <div class="row">

                                <div class="col-md-12">

                                    <label class="fs-5 fw-bold form-label">Role Name <span class="text-danger">*</span></label>

                                    <input type="text" name="name" id="name" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" value="{{ old('name', $role->name) }}" placeholder="Enter Role Name">

                                    @if($errors->has('name'))

                                        <div class="invalid-feedback">

                                            {{ $errors->first('name') }}

                                        </div>

                                    @endif

                                </div>

                            </div>

                            <div class="row mt-4">

                                <div class="col-md-12">

                                    <label class="fs-5 fw-bold form-label">Role Permissions</label>

                                    <table class="table">

                                        <tbody class="fw-semibold">

                                            <tr>

                                                <td><label style="cursor: pointer;" for="all_permissions" class="text-muted">ADMIN ACCESS</label></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-12">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" id="all_permissions">

                                                                <span class="form-check-label" for="all_permissions"> All Permissions </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Customers --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">CUSTOMERS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['customers.index'])) ? $permissions['customers.index'] : '' }}" name="permissions[]" {{ (isset($permissions['customers.index']) && in_array($permissions['customers.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['customers.edit'])) ? $permissions['customers.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['customers.edit']) && in_array($permissions['customers.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['customers.status'])) ? $permissions['customers.status'] : '' }}" name="permissions[]" {{ (isset($permissions['customers.status']) && in_array($permissions['customers.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Roles --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">ROLES</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.index'])) ? $permissions['roles.index'] : '' }}" name="permissions[]" {{ (isset($permissions['roles.index']) && in_array($permissions['roles.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.create'])) ? $permissions['roles.create'] : '' }}" name="permissions[]" {{ (isset($permissions['roles.create']) && in_array($permissions['roles.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.edit'])) ? $permissions['roles.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['roles.edit']) && in_array($permissions['roles.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.destroy'])) ? $permissions['roles.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['roles.destroy']) && in_array($permissions['roles.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Dealers --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">DEALERS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.index'])) ? $permissions['dealers.index'] : '' }}" name="permissions[]" {{ (isset($permissions['dealers.index']) && in_array($permissions['dealers.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.create'])) ? $permissions['dealers.create'] : '' }}" name="permissions[]" {{ (isset($permissions['dealers.create']) && in_array($permissions['dealers.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.edit'])) ? $permissions['dealers.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['dealers.edit']) && in_array($permissions['dealers.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.destroy'])) ? $permissions['dealers.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['dealers.destroy']) && in_array($permissions['dealers.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.status'])) ? $permissions['dealers.status'] : '' }}" name="permissions[]" {{ (isset($permissions['dealers.status']) && in_array($permissions['dealers.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Users --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">USERS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.index'])) ? $permissions['users.index'] : '' }}" name="permissions[]" {{ (isset($permissions['users.index']) && in_array($permissions['users.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.create'])) ? $permissions['users.create'] : '' }}" name="permissions[]" {{ (isset($permissions['users.create']) && in_array($permissions['users.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.edit'])) ? $permissions['users.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['users.edit']) && in_array($permissions['users.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.destroy'])) ? $permissions['users.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['users.destroy']) && in_array($permissions['users.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.status'])) ? $permissions['users.status'] : '' }}" name="permissions[]" {{ (isset($permissions['users.status']) && in_array($permissions['users.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Pages --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">PAGES</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.index'])) ? $permissions['pages.index'] : '' }}" name="permissions[]" {{ (isset($permissions['pages.index']) && in_array($permissions['pages.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.create'])) ? $permissions['pages.create'] : '' }}" name="permissions[]" {{ (isset($permissions['pages.create']) && in_array($permissions['pages.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.edit'])) ? $permissions['pages.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['pages.edit']) && in_array($permissions['pages.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.destroy'])) ? $permissions['pages.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['pages.destroy']) && in_array($permissions['pages.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.status'])) ? $permissions['pages.status'] : '' }}" name="permissions[]" {{ (isset($permissions['pages.status']) && in_array($permissions['pages.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Categories --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">CATEGORIES</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.index'])) ? $permissions['categories.index'] : '' }}" name="permissions[]" {{ (isset($permissions['categories.index']) && in_array($permissions['categories.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.create'])) ? $permissions['categories.create'] : '' }}" name="permissions[]" {{ (isset($permissions['categories.create']) && in_array($permissions['categories.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.edit'])) ? $permissions['categories.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['categories.edit']) && in_array($permissions['categories.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.destroy'])) ? $permissions['categories.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['categories.destroy']) && in_array($permissions['categories.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.status'])) ? $permissions['categories.status'] : '' }}" name="permissions[]" {{ (isset($permissions['categories.status']) && in_array($permissions['categories.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Top Banners --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">TOP BANNERS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['top-banners.index'])) ? $permissions['top-banners.index'] : '' }}" name="permissions[]" {{ (isset($permissions['top-banners.index']) && in_array($permissions['top-banners.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['top-banners.create'])) ? $permissions['top-banners.create'] : '' }}" name="permissions[]" {{ (isset($permissions['top-banners.create']) && in_array($permissions['top-banners.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['top-banners.edit'])) ? $permissions['top-banners.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['top-banners.edit']) && in_array($permissions['top-banners.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['top-banners.destroy'])) ? $permissions['top-banners.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['top-banners.destroy']) && in_array($permissions['top-banners.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['top-banners.status'])) ? $permissions['top-banners.status'] : '' }}" name="permissions[]" {{ (isset($permissions['top-banners.status']) && in_array($permissions['top-banners.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Middle Banners --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">MIDDLE BANNERS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['middle-banners.index'])) ? $permissions['middle-banners.index'] : '' }}" name="permissions[]" {{ (isset($permissions['middle-banners.index']) && in_array($permissions['middle-banners.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['middle-banners.create'])) ? $permissions['middle-banners.create'] : '' }}" name="permissions[]" {{ (isset($permissions['middle-banners.create']) && in_array($permissions['middle-banners.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['middle-banners.edit'])) ? $permissions['middle-banners.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['middle-banners.edit']) && in_array($permissions['middle-banners.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['middle-banners.destroy'])) ? $permissions['middle-banners.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['middle-banners.destroy']) && in_array($permissions['middle-banners.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['middle-banners.status'])) ? $permissions['middle-banners.status'] : '' }}" name="permissions[]" {{ (isset($permissions['middle-banners.status']) && in_array($permissions['middle-banners.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Bottom Banners --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">BOTTOM BANNERS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['bottom-banners.index'])) ? $permissions['bottom-banners.index'] : '' }}" name="permissions[]" {{ (isset($permissions['bottom-banners.index']) && in_array($permissions['bottom-banners.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['bottom-banners.create'])) ? $permissions['bottom-banners.create'] : '' }}" name="permissions[]" {{ (isset($permissions['bottom-banners.create']) && in_array($permissions['bottom-banners.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['bottom-banners.edit'])) ? $permissions['bottom-banners.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['bottom-banners.edit']) && in_array($permissions['bottom-banners.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['bottom-banners.destroy'])) ? $permissions['bottom-banners.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['bottom-banners.destroy']) && in_array($permissions['bottom-banners.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['bottom-banners.status'])) ? $permissions['bottom-banners.status'] : '' }}" name="permissions[]" {{ (isset($permissions['bottom-banners.status']) && in_array($permissions['bottom-banners.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Orders --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">ORDERS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.index'])) ? $permissions['orders.index'] : '' }}" name="permissions[]" {{ (isset($permissions['orders.index']) && in_array($permissions['orders.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.show'])) ? $permissions['orders.show'] : '' }}" name="permissions[]" {{ (isset($permissions['orders.show']) && in_array($permissions['orders.show'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Details </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.accept'])) ? $permissions['orders.accept'] : '' }}" name="permissions[]" {{ (isset($permissions['orders.accept']) && in_array($permissions['orders.accept'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Accept</span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.process'])) ? $permissions['orders.process'] : '' }}" name="permissions[]" {{ (isset($permissions['orders.process']) && in_array($permissions['orders.process'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Process</span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.complete'])) ? $permissions['orders.complete'] : '' }}" name="permissions[]" {{ (isset($permissions['orders.complete']) && in_array($permissions['orders.complete'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Complete</span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Tags --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">TAGS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.index'])) ? $permissions['tags.index'] : '' }}" name="permissions[]" {{ (isset($permissions['tags.index']) && in_array($permissions['tags.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.create'])) ? $permissions['tags.create'] : '' }}" name="permissions[]" {{ (isset($permissions['tags.create']) && in_array($permissions['tags.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.edit'])) ? $permissions['tags.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['tags.edit']) && in_array($permissions['tags.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.destroy'])) ? $permissions['tags.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['tags.destroy']) && in_array($permissions['tags.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.status'])) ? $permissions['tags.status'] : '' }}" name="permissions[]" {{ (isset($permissions['tags.status']) && in_array($permissions['tags.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.header.status'])) ? $permissions['tags.header.status'] : '' }}" name="permissions[]" {{ (isset($permissions['tags.header.status']) && in_array($permissions['tags.header.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Header Status </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Designs --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">DESIGNS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.index'])) ? $permissions['designs.index'] : '' }}" name="permissions[]" {{ (isset($permissions['designs.index']) && in_array($permissions['designs.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.create'])) ? $permissions['designs.create'] : '' }}" name="permissions[]" {{ (isset($permissions['designs.create']) && in_array($permissions['designs.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.edit'])) ? $permissions['designs.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['designs.edit']) && in_array($permissions['designs.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.destroy'])) ? $permissions['designs.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['designs.destroy']) && in_array($permissions['designs.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.status'])) ? $permissions['designs.status'] : '' }}" name="permissions[]" {{ (isset($permissions['designs.status']) && in_array($permissions['designs.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.top-selling.status'])) ? $permissions['designs.top-selling.status'] : '' }}" name="permissions[]" {{ (isset($permissions['designs.top-selling.status']) && in_array($permissions['designs.top-selling.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Top Selling </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Others --}}

                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">Others</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['settings.index'])) ? $permissions['settings.index'] : '' }}" name="permissions[]" {{ (isset($permissions['settings.index']) && in_array($permissions['settings.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Settings </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['settings.update'])) ? $permissions['settings.update'] : '' }}" name="permissions[]" {{ (isset($permissions['settings.update']) && in_array($permissions['settings.update'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Update Setting</span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['myprofile.index'])) ? $permissions['myprofile.index'] : '' }}" name="permissions[]" {{ (isset($permissions['myprofile.index']) && in_array($permissions['myprofile.index'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Profile </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['myprofile.update'])) ? $permissions['myprofile.update'] : '' }}" name="permissions[]" {{ (isset($permissions['myprofile.update']) && in_array($permissions['myprofile.update'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Update Profile </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Dashboard --}}
                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">Dashboard</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.count'])) ? $permissions['categories.count'] : '' }}" name="permissions[]" {{ (isset($permissions['categories.count']) && in_array($permissions['categories.count'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Categories Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.count'])) ? $permissions['tags.count'] : '' }}" name="permissions[]" {{ (isset($permissions['tags.count']) && in_array($permissions['tags.count'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Tags Count</span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.count'])) ? $permissions['designs.count'] : '' }}" name="permissions[]" {{ (isset($permissions['designs.count']) && in_array($permissions['designs.count'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Designs Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.count'])) ? $permissions['pages.count'] : '' }}" name="permissions[]" {{ (isset($permissions['pages.count']) && in_array($permissions['pages.count'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Pages Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.count'])) ? $permissions['orders.count'] : '' }}" name="permissions[]" {{ (isset($permissions['orders.count']) && in_array($permissions['orders.count'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Orders Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.count'])) ? $permissions['users.count'] : '' }}" name="permissions[]" {{ (isset($permissions['users.count']) && in_array($permissions['users.count'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Users Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.count'])) ? $permissions['dealers.count'] : '' }}" name="permissions[]" {{ (isset($permissions['dealers.count']) && in_array($permissions['dealers.count'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Dealers Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['customers.count'])) ? $permissions['customers.count'] : '' }}" name="permissions[]" {{ (isset($permissions['customers.count']) && in_array($permissions['customers.count'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Customers Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pending.orders.list'])) ? $permissions['pending.orders.list'] : '' }}" name="permissions[]" {{ (isset($permissions['pending.orders.list']) && in_array($permissions['pending.orders.list'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Pending Orders List </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Company Master --}}

                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">COMPANY MASTER</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['comapny.master.index'])) ? $permissions['comapny.master.index'] : '' }}" name="permissions[]" {{ (isset($permissions['comapny.master.index']) && in_array($permissions['comapny.master.index'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['comapny.master.store'])) ? $permissions['comapny.master.store'] : '' }}" name="permissions[]" {{ (isset($permissions['comapny.master.store']) && in_array($permissions['comapny.master.store'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['comapny.master.edit'])) ? $permissions['comapny.master.edit'] : '' }}" name="permissions[]" {{ (isset($permissions['comapny.master.edit']) && in_array($permissions['comapny.master.edit'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">Edit </span>

                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['comapny.master.destroy'])) ? $permissions['comapny.master.destroy'] : '' }}" name="permissions[]" {{ (isset($permissions['comapny.master.destroy']) && in_array($permissions['comapny.master.destroy'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Delete </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['comapny.master.status'])) ? $permissions['comapny.master.status'] : '' }}" name="permissions[]" {{ (isset($permissions['comapny.master.status']) && in_array($permissions['comapny.master.status'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">status </span>
                                                            </label>
                                                        </div>


                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- Ready To Dispatch Orders --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">READT TO DISPATCH ORDERS</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.readytodispatch'])) ? $permissions['orders.readytodispatch'] : '' }}" name="permissions[]" {{ (isset($permissions['orders.readytodispatch']) && in_array($permissions['orders.readytodispatch'], $role_permissions)) ? 'checked' : '' }}
                                                                >

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.readytodispatch.show'])) ? $permissions['orders.readytodispatch.show'] : '' }}" name="permissions[]" {{ (isset($permissions['orders.readytodispatch.show']) && in_array($permissions['orders.readytodispatch.show'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Details </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['ready.orders.accept'])) ? $permissions['ready.orders.accept'] : '' }}" name="permissions[]" {{ (isset($permissions['ready.orders.accept']) && in_array($permissions['ready.orders.accept'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Accept</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.readytodispatch.process'])) ? $permissions['orders.readytodispatch.process'] : '' }}" name="permissions[]" {{ (isset($permissions['orders.readytodispatch.process']) && in_array($permissions['orders.readytodispatch.process'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Process</span>

                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['ready.orders.complete'])) ? $permissions['ready.orders.complete'] : '' }}" name="permissions[]" {{ (isset($permissions['ready.orders.complete']) && in_array($permissions['ready.orders.complete'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Complete</span>
                                                            </label>
                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Price Calculate Make By Order --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">MAKE BY ORDER</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['price-calculator.make-by-order'])) ? $permissions['price-calculator.make-by-order'] : '' }}" name="permissions[]" {{ (isset($permissions['price-calculator.make-by-order']) && in_array($permissions['price-calculator.make-by-order'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['price-calculator.update-make-by-order'])) ? $permissions['price-calculator.update-make-by-order'] : '' }}" name="permissions[]" {{ (isset($permissions['price-calculator.update-make-by-order']) && in_array($permissions['price-calculator.update-make-by-order'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                            {{-- Price Calculate Make By Order Ready to dispatch--}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">READY TO DISPATCH</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['price_calculate.make_by_order_ready_to_dispatch'])) ? $permissions['price_calculate.make_by_order_ready_to_dispatch'] : '' }}" name="permissions[]" {{ (isset($permissions['price_calculate.make_by_order_ready_to_dispatch']) && in_array($permissions['price_calculate.make_by_order_ready_to_dispatch'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['price-calculator.update-ready-to-dispatch'])) ? $permissions['price-calculator.update-ready-to-dispatch'] : '' }}" name="permissions[]" {{ (isset($permissions['price-calculator.update-ready-to-dispatch']) && in_array($permissions['price-calculator.update-ready-to-dispatch'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-3">

                                <div class="col-md-3">

                                    <button class="btn btn-success">Update</button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>



@endsection



@section('page-js')

<script type="text/javascript">



    $("#all_permissions").change(function() {

        if(this.checked) {

            $(".form-check-input:not(#all_permissions)").prop('checked', true);

        } else {

            $(".form-check-input:not(#all_permissions)").prop('checked', false);

        }

    });



    function checkAllAfter(element) {

        let checkboxes = $(element).parent().nextAll('td').find('input[type="checkbox"]');

        checkboxes.each(function() {

            this.checked = !this.checked;

        });

    }





</script>

@endsection

