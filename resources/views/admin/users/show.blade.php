@extends('admin.layouts.admin-layout')

@section('title', 'PROFILE - USERS - IMPEL JEWELLERS')

@section('content')



    {{-- Page Title --}}

    <div class="pagetitle">

        <h1>Users</h1>

        <div class="row">

            <div class="col-md-8">

                <nav>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>

                        <li class="breadcrumb-item active">Profile</li>

                    </ol>

                </nav>

            </div>

        </div>

    </div>



    {{-- Profile Section --}}

    <section class="section profile">

        <div class="row">

            <div class="col-xl-4">

                <div class="card">

                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ (isset($user->image) && !empty($user->image) && file_exists('public/images/uploads/user_images/'.$user->image)) ? asset('public/images/uploads/user_images/'.$user->image) : asset('public/images/default_images/profiles/profile1.jpg') }}" alt="Profile" class="rounded-circle">

                        <h2>{{ (isset($user->firstname)) ? $user->firstname : '' }} {{ (isset($user->lastname)) ? $user->lastname : '' }}</h2>

                        <h3>{{ (isset($user->role->name)) ? $user->role->name : '' }}</h3>

                    </div>

                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">

                    <div class="card-body pt-3">

                       <div class="row">

                            <div class="col-md-6"><h5 class="card-title">Profile Details</h5></div>



                            @can('myprofile.update')

                                <div class="col-md-6 text-end"><a href="{{ route('users.edit', encrypt($user->id)) }}" class="btn btn-sm custom-btn"><i class="fa-solid fa-edit"></i></a></div>

                            @endcan



                       </div>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="table-responsive">                        
                                    <table class="table">
    
                                        <tbody>
    
                                            <tr>
    
                                                <th scope="col">Firstname</th>
    
                                                <td>{{ (isset($user->firstname)) ? $user->firstname : '' }}</td>
    
                                            </tr>
    
                                            <tr>
    
                                                <th scope="col">Lastname</th>
    
                                                <td>{{ (isset($user->lastname)) ? $user->lastname : '' }}</td>
    
                                            </tr>
    
                                            <tr>
    
                                                <th scope="col">Email</th>
    
                                                <td>{{ (isset($user->email)) ? $user->email : '' }}</td>
    
                                            </tr>
    
                                            <tr>
    
                                                <th scope="col">Phone</th>
    
                                                <td>{{ (isset($user->phone)) ? $user->phone : '' }}</td>
    
                                            </tr>
    
                                            <tr>
    
                                                <th scope="col">Role</th>
    
                                                <td>{{ (isset($user->role->name)) ? $user->role->name : '' }}</td>
    
                                            </tr>
    
                                            <tr>
    
                                                <th scope="col">Permissions</th>
    
                                                <td>
    
                                                    @if(isset($user->role->permissions) && count($user->role->permissions) > 0)
    
                                                        @foreach ($user->role->permissions as $permission)
    
                                                            @php
    
                                                                $permission_name = $permission->name;
    
                                                                $permission_name = str_replace('.', ' ', $permission_name);
    
                                                            @endphp
    
                                                            <span class="badge bg-dark m-1" style="font-size:14px;">{{ ucwords($permission_name) }}</span>
    
                                                        @endforeach
    
                                                    @endif
    
                                                </td>
    
                                            </tr>
    
                                        </tbody>
    
                                    </table>
                                </div>

                            </div>

                            {{-- <div class="col-lg-3 col-md-4 label">Email</div>

                            <div class="col-lg-9 col-md-8">{{ (isset($user->email)) ? $user->email : '' }}</div>

                        </div>

                        <div class="row">

                            <div class="col-lg-3 col-md-4 label">Phone</div>

                            <div class="col-lg-9 col-md-8">{{ (isset($user->phone)) ? $user->phone : '' }}</div>

                        </div>

                        <div class="row">

                            <div class="col-lg-3 col-md-4 label">Country</div>

                            <div class="col-lg-9 col-md-8">USA</div>

                        </div>

                        <div class="row">

                            <div class="col-lg-3 col-md-4 label">Address</div>

                            <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>

                        </div>

                        <div class="row">

                            <div class="col-lg-3 col-md-4 label">Phone</div>

                            <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>

                        </div>

                        <div class="row">

                            <div class="col-lg-3 col-md-4 label">Email</div>

                            <div class="col-lg-9 col-md-8">k.anderson@example.com</div>

                        </div>

                        </div> --}}

                    </div>

                </div>

            </div>

        </div>

    </section>



@endsection



