@extends('admin.layouts.admin-layout')

@section('title', 'SETTINGS - IMPEL JEWELLERS')

@section('content')



    {{-- Page Title --}}

    <div class="pagetitle">

        <h1>Settings</h1>

        <div class="row">

            <div class="col-md-8">

                <nav>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>

                        <li class="breadcrumb-item active">Settings</li>

                    </ol>

                </nav>

            </div>

        </div>

    </div>



    {{-- Settings Form Section --}}

    <section class="section dashboard">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <form class="form" action="{{ route('settings.update') }}" method="POST"
                        enctype="multipart/form-data">

                        <div class="card-body">

                            @csrf

                            <div class="form_box">

                                <div class="form_box_inr">

                                    <div class="box_title">

                                        <h2>Google Sheet Settings</h2>

                                    </div>

                                    <div class="form_box_info">

                                        <div class="row">

                                            <div class="col-md-12 mb-3">

                                                <div class="form-group">

                                                    <label for="sheets_names" class="form-label">Sheets Names</label>

                                                    <input type="text" name="settings[sheets_names]" id="sheets_names"
                                                        class="form-control" placeholder="Enter Google Sheets Names"
                                                        value="{{ isset($settings['sheets_names']) ? $settings['sheets_names'] : '' }}">

                                                    <code>Note : Enter Your Google Sheets Name Like
                                                        (Sheet1,Sheet2,Sheet3,...)</code>

                                                </div>

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <div class="form-group">

                                                    <label for="spread_sheet_id" class="form-label">Spread Sheet ID</label>

                                                    <input type="text" name="settings[spread_sheet_id]"
                                                        id="spread_sheet_id" class="form-control"
                                                        placeholder="Enter Google Spread Sheet ID"
                                                        value="{{ isset($settings['spread_sheet_id']) ? $settings['spread_sheet_id'] : '' }}">

                                                </div>

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <div class="form-group">

                                                    <label for="developer_key" class="form-label">Developer Key</label>

                                                    <input type="text" name="settings[developer_key]" id="developer_key"
                                                        class="form-control" placeholder="Enter Developer Key"
                                                        value="{{ isset($settings['developer_key']) ? $settings['developer_key'] : '' }}">

                                                </div>

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <div class="form-group">

                                                    <a id="xcel-upload-btn" class="btn btn-sm btn-primary">Update Designes
                                                        <i class="fa-solid fa-upload"></i></a>

                                                    <button id="xcel-upload-btn-loader" class="btn btn-sm btn-primary"
                                                        type="button" disabled style="display: none;"><span
                                                            class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span> Uploading...</button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="form_box_inr">

                                    <div class="box_title">

                                        <h2>Social Links Settings</h2>

                                    </div>

                                    <div class="form_box_info">

                                        <div class="row">

                                            <div class="col-md-6 mb-3">

                                                <label for="instagram_link" class="form-label">Instagram Link</label>

                                                <input type="text" name="settings[instagram_link]" id="instagram_link"
                                                    class="form-control"
                                                    value="{{ isset($settings['instagram_link']) ? $settings['instagram_link'] : '' }}">

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="facebook_link" class="form-label">Facebook Link</label>

                                                <input type="text" name="settings[facebook_link]" id="facebook_link"
                                                    class="form-control"
                                                    value="{{ isset($settings['facebook_link']) ? $settings['facebook_link'] : '' }}">

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="pinterest_link" class="form-label">Pinterest Link</label>

                                                <input type="text" name="settings[pinterest_link]" id="pinterest_link"
                                                    class="form-control"
                                                    value="{{ isset($settings['pinterest_link']) ? $settings['pinterest_link'] : '' }}">

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="youtube_link" class="form-label">Youtube Link</label>

                                                <input type="text" name="settings[youtube_link]" id="youtube_link"
                                                    class="form-control"
                                                    value="{{ isset($settings['youtube_link']) ? $settings['youtube_link'] : '' }}">

                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="form_box_inr">

                                    <div class="box_title">

                                        <h2>Phonepe Settings</h2>

                                    </div>

                                    <div class="form_box_info">

                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-check form-switch me-2">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="phonepe_live" name="settings[phonepe_live]"
                                                            value="1"
                                                            {{ isset($settings['phonepe_live']) && $settings['phonepe_live'] == 1 ? 'checked' : '' }}>
                                                    </div>
                                                    <label for="phonepe_live"><strong>Live Mode</strong></label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="phonepe_live_merchant_id" class="form-label">Live Merchant
                                                    ID</label>

                                                <input type="text" name="settings[phonepe_live_merchant_id]"
                                                    id="phonepe_live_merchant_id" class="form-control"
                                                    value="{{ isset($settings['phonepe_live_merchant_id']) ? $settings['phonepe_live_merchant_id'] : '' }}">

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="phonepe_live_salt_key" class="form-label">Live Salt
                                                    Key</label>

                                                <input type="text" name="settings[phonepe_live_salt_key]"
                                                    id="phonepe_live_salt_key" class="form-control"
                                                    value="{{ isset($settings['phonepe_live_salt_key']) ? $settings['phonepe_live_salt_key'] : '' }}">

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="phonepe_sandbox_merchant_id" class="form-label">SandBox
                                                    Merchant ID</label>

                                                <input type="text" name="settings[phonepe_sandbox_merchant_id]"
                                                    id="phonepe_sandbox_merchant_id" class="form-control"
                                                    value="{{ isset($settings['phonepe_sandbox_merchant_id']) ? $settings['phonepe_sandbox_merchant_id'] : '' }}">

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label for="phonepe_sandbox_salt_key" class="form-label">SandBox Salt
                                                    Key</label>

                                                <input type="text" name="settings[phonepe_sandbox_salt_key]"
                                                    id="phonepe_sandbox_salt_key" class="form-control"
                                                    value="{{ isset($settings['phonepe_sandbox_salt_key']) ? $settings['phonepe_sandbox_salt_key'] : '' }}">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Price Calculator (Make By Order)</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="gold_price_24k_1gm_mbo" class="form-label">24K Gold Price 1Gm.</label>
                                                <input type="text" name="settings[gold_price_24k_1gm_mbo]" id="gold_price_24k_1gm_mbo" class="form-control numeric" inputmode="numeric" value="{{ (isset($settings['gold_price_24k_1gm_mbo'])) ? $settings['gold_price_24k_1gm_mbo'] : '' }}">
                                            </div>
                                        </div>
                                        @if (count($categories) > 0)
                                            @foreach ($categories as $category)
                                                @php
                                                    $sales_wastage = (isset($settings['sales_wastage']) && !empty($settings['sales_wastage'])) ? unserialize($settings['sales_wastage']) : [];
                                                    $sales_wastage_discount = (isset($settings['sales_wastage_discount']) && !empty($settings['sales_wastage_discount'])) ? unserialize($settings['sales_wastage_discount']) : [];
                                                @endphp
                                                <div class="row align-items-center">
                                                    <div class="col-md-4">
                                                        <p style="font-size: 14px; text-align:center; margin:0;"><strong>{{ $category->name }}</strong></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">Sales Wastage (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_wastage][{{$category->id}}]" value="{{ (isset($sales_wastage[$category->id])) ? $sales_wastage[$category->id] : '' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">Sales Wastage Discount (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_wastage_discount][{{$category->id}}]" value="{{ (isset($sales_wastage_discount[$category->id])) ? $sales_wastage_discount[$category->id] : '' }}">
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        @endif
                                    </div>
                                </div> -->

                                <div class="form_box_inr">

                                    <div class="box_title">

                                        <h2>Other Settings</h2>

                                    </div>

                                    <div class="form_box_info">

                                        <div class="row">

                                            <div class="col-md-12 mb-3">

                                                <label for="frontend_copyright" class="form-label">Frontend
                                                    Copyright</label>

                                                <input type="text" name="settings[frontend_copyright]"
                                                    id="frontend_copyright" class="form-control"
                                                    value="{{ isset($settings['frontend_copyright']) ? $settings['frontend_copyright'] : '' }}">

                                                <code>Note : Do not remove the {year} tag. it is used to get the current
                                                    year. You can place it wherever you want.</code>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Sequal Settings</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-check form-switch me-2">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="sequel_live" name="settings[sequel_live]"
                                                            value="1"
                                                            {{ isset($settings['sequel_live']) && $settings['sequel_live'] == 1 ? 'checked' : '' }}>
                                                    </div>
                                                    <label for="sequel_live"><strong>Live Mode</strong></label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="sequel_live_api_token" class="form-label">Live Api Token</label>
                                                <input type="text" name="settings[sequel_live_api_token]"
                                                    id="sequel_live_api_token" class="form-control"
                                                    value="{{ isset($settings['sequel_live_api_token']) ? $settings['sequel_live_api_token'] : '' }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="sequel_live_api_url" class="form-label">Live Api Url</label>

                                                <input type="text" name="settings[sequel_live_api_url]"
                                                    id="sequel_live_api_url" class="form-control"
                                                    value="{{ isset($settings['sequel_live_api_url']) ? $settings['sequel_live_api_url'] : '' }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="sequel_test_api_token" class="form-label">Test Api Token</label>
                                                <input type="text" name="settings[sequel_test_api_token]"
                                                    id="sequel_test_api_token" class="form-control"
                                                    value="{{ isset($settings['sequel_test_api_token']) ? $settings['sequel_test_api_token'] : '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="sequel_test_api_url" class="form-label">Test Api Url</label>
                                                <input type="text" name="settings[sequel_test_api_url]"
                                                    id="sequel_test_api_url" class="form-control"
                                                    value="{{ isset($settings['sequel_test_api_url']) ? $settings['sequel_test_api_url'] : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            @can('settings.update')
                                <button class="btn form_button">Update</button>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



@endsection



@section('page-js')

    <script type="text/javascript">
        @cannot('settings.update')

            $('input').prop('disabled', true);
        @endcannot

        $('#xcel-upload-btn').on('click', function() {

            $.ajax({

                type: "POST",

                url: "{{ route('fetch.design.excel') }}",

                beforeSend: function() {

                    $('#xcel-upload-btn').hide();

                    $('#xcel-upload-btn-loader').show();

                },

                data: {

                    "_token": "{{ csrf_token() }}",

                },

                dataType: "JSON",

                success: function(response) {

                    if (response.success == 1) {

                        toastr.success(response.message);

                        $('#xcel-upload-btn').show();

                        $('#xcel-upload-btn-loader').hide();

                    } else {

                        toastr.error(response.message);

                        $('#xcel-upload-btn').show();

                        $('#xcel-upload-btn-loader').hide();

                    }

                }

            });

        });

        $('.numeric').on('input', function(){
            var inputValue = $(this).val();
            var numericValue = inputValue.replace(/[^\d.]/g, '');
            var parts = numericValue.split('.');
            if (parts.length > 2) {
                numericValue = parts[0] + '.' + parts.slice(1).join('');
            }

            $(this).val(numericValue);
        });

    </script>

@endsection
