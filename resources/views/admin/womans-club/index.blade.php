@extends('admin.layouts.admin-layout')
@section('title', 'WOMAN\'S CLUB - IMPEL JEWELLERS')
@section('content')

{{-- Page Title --}}
<div class="pagetitle">
    <h1>Woman's Club</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Woman's Club</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Woman's Club Section --}}
<section class="section womans_club">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom_dt_table">
                        <table class="table nowrap w-100" id="womans-club-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>City</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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
    // Load All Woman's Club
    $(function() {
        var table = $('#womans-club-table').DataTable({
            processing: true
            , serverSide: true
            , pageLength: 25
            , ajax: "{{ route('womans-club.load') }}"
            , columns: [{
                    data: 'id'
                    , name: 'id'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'name'
                    , name: 'name'
                    , orderable: false
                }
                , {
                    data: 'email'
                    , name: 'email'
                    , orderable: false
                }
                , {
                    data: 'mobile'
                    , name: 'mobile'
                    , orderable: false
                }
                , {
                    data: 'city'
                    , name: 'city'
                    , orderable: false
                }
                , {
                    data: 'actions'
                    , name: 'actions'
                    , orderable: false
                    , searchable: false
                }
            , ]
        });
    });

</script>
@endsection
