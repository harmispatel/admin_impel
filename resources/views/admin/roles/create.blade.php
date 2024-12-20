@extends('admin.layouts.admin-layout')

@section('title', 'CREATE - ROLES - IMPEL JEWELLERS')

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

                        <li class="breadcrumb-item active">Create</li>

                    </ol>

                </nav>

            </div>

        </div>

    </div>



    {{-- Create Role Section --}}

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fs-5 fw-bold form-label">Role Name <span class="text-danger">*</span></label>

                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" placeholder="Enter Role Name">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['customers.index'])) ? $permissions['customers.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['customers.edit'])) ? $permissions['customers.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['customers.status'])) ? $permissions['customers.status'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.index'])) ? $permissions['roles.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.create'])) ? $permissions['roles.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.edit'])) ? $permissions['roles.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.destroy'])) ? $permissions['roles.destroy'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.index'])) ? $permissions['dealers.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.create'])) ? $permissions['dealers.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.edit'])) ? $permissions['dealers.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.destroy'])) ? $permissions['dealers.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.status'])) ? $permissions['dealers.status'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.index'])) ? $permissions['users.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.create'])) ? $permissions['users.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.edit'])) ? $permissions['users.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.destroy'])) ? $permissions['users.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.status'])) ? $permissions['users.status'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.index'])) ? $permissions['pages.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.create'])) ? $permissions['pages.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.edit'])) ? $permissions['pages.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.destroy'])) ? $permissions['pages.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.status'])) ? $permissions['pages.status'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.index'])) ? $permissions['categories.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.create'])) ? $permissions['categories.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.edit'])) ? $permissions['categories.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.destroy'])) ? $permissions['categories.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.status'])) ? $permissions['categories.status'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['top-banners.index'])) ? $permissions['top-banners.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['top-banners.create'])) ? $permissions['top-banners.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['top-banners.edit'])) ? $permissions['top-banners.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['top-banners.destroy'])) ? $permissions['top-banners.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['top-banners.status'])) ? $permissions['top-banners.status'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['middle-banners.index'])) ? $permissions['middle-banners.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['middle-banners.create'])) ? $permissions['middle-banners.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['middle-banners.edit'])) ? $permissions['middle-banners.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['middle-banners.destroy'])) ? $permissions['middle-banners.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['middle-banners.status'])) ? $permissions['middle-banners.status'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['bottom-banners.index'])) ? $permissions['bottom-banners.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['bottom-banners.create'])) ? $permissions['bottom-banners.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['bottom-banners.edit'])) ? $permissions['bottom-banners.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['bottom-banners.destroy'])) ? $permissions['bottom-banners.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['bottom-banners.status'])) ? $permissions['bottom-banners.status'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.index'])) ? $permissions['orders.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.show'])) ? $permissions['orders.show'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Details </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.accept'])) ? $permissions['orders.accept'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Accept</span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.process'])) ? $permissions['orders.process'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Process</span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.complete'])) ? $permissions['orders.complete'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.index'])) ? $permissions['tags.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.create'])) ? $permissions['tags.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.edit'])) ? $permissions['tags.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.destroy'])) ? $permissions['tags.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.status'])) ? $permissions['tags.status'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.header.status'])) ? $permissions['tags.header.status'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.index'])) ? $permissions['designs.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.create'])) ? $permissions['designs.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.edit'])) ? $permissions['designs.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.destroy'])) ? $permissions['designs.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.status'])) ? $permissions['designs.status'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Status </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.top-selling.status'])) ? $permissions['designs.top-selling.status'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['settings.index'])) ? $permissions['settings.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Settings </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['settings.update'])) ? $permissions['settings.update'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Update Setting</span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['myprofile.index'])) ? $permissions['myprofile.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Profile </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['myprofile.update'])) ? $permissions['myprofile.update'] : '' }}" name="permissions[]">

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['categories.count'])) ? $permissions['categories.count'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Categories Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['tags.count'])) ? $permissions['tags.count'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Tags Count</span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['designs.count'])) ? $permissions['designs.count'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Designs Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pages.count'])) ? $permissions['pages.count'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Pages Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.count'])) ? $permissions['orders.count'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Orders Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['users.count'])) ? $permissions['users.count'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Users Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['dealers.count'])) ? $permissions['dealers.count'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Dealers Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['customers.count'])) ? $permissions['customers.count'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Customers Count </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2 mb-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pending.orders.list'])) ? $permissions['pending.orders.list'] : '' }}" name="permissions[]">

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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['comapny.master.index'])) ? $permissions['comapny.master.index'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['comapny.master.store'])) ? $permissions['comapny.master.store'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['comapny.master.edit'])) ? $permissions['comapny.master.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['comapny.master.destroy'])) ? $permissions['comapny.master.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['comapny.master.status'])) ? $permissions['comapny.master.status'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Status </span>
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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.readytodispatch'])) ? $permissions['orders.readytodispatch'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.readytodispatch.show'])) ? $permissions['orders.readytodispatch.show'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Details </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['ready.orders.accept'])) ? $permissions['ready.orders.accept'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Accept</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['orders.readytodispatch.process'])) ? $permissions['orders.readytodispatch.process'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Process</span>

                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['ready.orders.complete'])) ? $permissions['ready.orders.complete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Complete</span>
                                                            </label>
                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- Make By Order --}}

                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">MAKE BY ORDER</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['price-calculator.make-by-order'])) ? $permissions['price-calculator.make-by-order'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['price-calculator.update-make-by-order'])) ? $permissions['price-calculator.update-make-by-order'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                            {{-- Make By Order Ready to dispatch--}}

                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">READY TO DISPATCH</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['price_calculate.make_by_order_ready_to_dispatch'])) ? $permissions['price_calculate.make_by_order_ready_to_dispatch'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['price-calculator.update-ready-to-dispatch'])) ? $permissions['price-calculator.update-ready-to-dispatch'] : '' }}" name="permissions[]">

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
                                    <button class="btn btn-success">Save</button>
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

