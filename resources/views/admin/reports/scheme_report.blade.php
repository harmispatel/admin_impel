@extends('admin.layouts.admin-layout')

@section('title', 'Scheme Report')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Scheme Report</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                        <li class="breadcrumb-item active">Scheme Report</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Scheme Report Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Errors Message --}}
            @if (session()->has('errors'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('errors') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection

{{-- Custom JS --}}
@section('page-js')

    <script type="text/javascript">

        toastr.options = 
        {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            timeOut: 10000
        }

        @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}')
        @endif

        // @if (Session::has('error'))
        //     toastr.error('{{ Session::get('error') }}')
        // @endif

    </script>

@endsection
