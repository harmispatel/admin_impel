@extends('admin.layouts.admin-layout')
@section('title', 'DETAILS - WOMAN\'S CLUB - IMPEL JEWELLERS')
@section('content')

{{-- Page Title --}}
<div class="pagetitle">
    <h1>Woman's Club</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('womans-club.index') }}">Woman's Club</a></li>
                    <li class="breadcrumb-item active">Details</li>
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
                    <h3 class="text-center"><strong>Request Details</strong></h3>
                    <table class="table">
                        <tr>
                            <th width="25%">Name</th>
                            <td>{{ $woman_club_request->name }}</td>
                        </tr>
                        <tr>
                            <th width="25%">Email</th>
                            <td>{{ $woman_club_request->email }}</td>
                        </tr>
                        <tr>
                            <th width="25%">Mobile No.</th>
                            <td>{{ $woman_club_request->mobile }}</td>
                        </tr>
                        <tr>
                            <th width="25%">City</th>
                            <td>{{ $woman_club_request->city }}</td>
                        </tr>
                        <tr>
                            <th width="25%">How You Know ?</th>
                            <td>
                                @php
                                    $how_you_know = (isset($woman_club_request->how_you_know) && !empty($woman_club_request->how_you_know)) ? unserialize($woman_club_request->how_you_know) : [];
                                @endphp
                                @if(count($how_you_know) > 0)
                                    <ul>
                                        @foreach ($how_you_know as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th width="25%">Request Message</th>
                            <td>{{ $woman_club_request->message }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
