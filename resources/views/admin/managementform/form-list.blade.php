@extends('admin.layouts.admin-layout')

@section('title', 'CUSTOMERS - IMPEL JEWELLERS')

@section('content')
    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Data Management Form</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Management Form List</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('management.form') }}" class="btn btn-sm new-category custom-btn">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Customers Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                            </div>
                        </div>
                        <div class="table-responsive custom_dt_table">
                        <table class="table w-100" id="SurvayFormTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Coupen</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">City</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Flat No</th>
                                    <th scope="col">Society</th>
                                    <th scope="col">Area</th>
                                    <th scope="col">Link</th>
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
    $(function() {
        var table = $('#SurvayFormTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            ajax: "{{ route('management.form.list') }}", // URL for AJAX request
            columns: [
                { data: null, name: 'count', orderable: false, searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'name', name: 'name', orderable: true, searchable: true },
                { data: 'number', name: 'number', orderable: true, searchable: true },
                { data: 'coupen', name: 'coupen', orderable: true, searchable: true },
                { data: 'date', name: 'date', orderable: true, searchable: true },
                { data: 'city', name: 'city', orderable: true, searchable: true },
                { data: 'state', name: 'state', orderable: true, searchable: true },
                { data: 'flat_no', name: 'flat_no', orderable: true, searchable: true },
                { data: 'society', name: 'society', orderable: true, searchable: true },
                { data: 'area', name: 'area', orderable: true, searchable: true },
                 { data: 'link', name: 'link', orderable: true, searchable: true }
            ]
        });
    });
</script>
@endsection

