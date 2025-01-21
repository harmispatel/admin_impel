@extends('admin.layouts.admin-layout')

@section('title', 'COMPANYMASTER - IMPEL JEWELLERS')

@section('content')
    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Items</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('comapny.master.index') }}">Company Master</a></li>
                        <li class="breadcrumb-item active">Item</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Comapny Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="CompanyMasterTable">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse ($itemGroups as $group)
                                @php
                                    $item_id = $group['ItemID'];
                                    $item_status = App\Models\ItemGroup::where('item_id',$item_id)->first();
                                    $exist_status = $item_status ? $item_status->status : 0;
                                @endphp
                                <tr>
                                    <td>{{ $group['ItemName'] }}</td>
                                    <td>
                                        <div class="form-check form-switch me-2">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                onchange="ChnageItemGroupStatus('{{ $group['ItemID'] }}', '{{ $group['ItemName'] }}', {{ $company_master_id }})"
                                                name="status" value="1" {{ $exist_status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No Item Groups Found</td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-js')
<script>
    function ChnageItemGroupStatus(ItemGroupID, GroupName, company_master_id) {
        // Get the status of the checkbox
        let status = event.target.checked ? 1 : 0;

        $.ajax({
            type: "POST",
            url: "{{ route('company.itemgroup.update') }}", // Fix route spelling here
            data: {
                "_token": "{{ csrf_token() }}",
                "item_id": ItemGroupID,
                "item_name": GroupName,
                "company_master_id": company_master_id,
                "status": status
            },
            dataType: "JSON",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (error) {
                console.error(error);
                toastr.error("Something went wrong.");
            }
        });
    }
</script>

@endsection