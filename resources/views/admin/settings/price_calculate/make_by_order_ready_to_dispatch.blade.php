@extends('admin.layouts.admin-layout')
@section('title', 'PRICE CALCULATOR -Make By Order- Ready To Dispatch -IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Price Calculator</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item">Price Calculator</li>
                        <li class="breadcrumb-item active">Make By Order Ready To Dispatch</li>
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
                    <form class="form" action="{{ route('price-calculator.update-ready-to-dispatch') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <!-- make by order -->
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Price Calculator For Gold</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="gold_price_24k_1gm_mbo_rtd" class="form-label">
                                                    24K Gold Price 1Gm.
                                                </label>
                                                <input type="text" name="settings[gold_price_24k_1gm_mbo_rtd]" id="gold_price_24k_1gm_mbo_rtd" class="form-control numeric" inputmode="numeric" value="{{ isset($settings['gold_price_24k_1gm_mbo_rtd']) ? $settings['gold_price_24k_1gm_mbo_rtd'] : '' }}">
                                            </div>
                                        </div>

                                        @if (count($categories) > 0)
                                            @foreach ($categories as $category)
                                                @php
                                                    $sales_wastage = isset($settings['sales_wastage_rtd']) && !empty($settings['sales_wastage_rtd']) ? unserialize($settings['sales_wastage_rtd']) : [];
                                                    $sales_wastage_discount = isset($settings['sales_wastage_discount_rtd']) && !empty($settings['sales_wastage_discount_rtd']) ? unserialize($settings['sales_wastage_discount_rtd']) : [];
                                                @endphp
                                                <div class="row align-items-center">
                                                    <div class="col-md-4">
                                                        <p style="font-size: 14px; text-align:center; margin:0;">
                                                            <strong>{{ $category->GroupName }}</strong>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">Sales Wastage (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_wastage_rtd][{{ $category->ItemGroupID }}]" value="{{ isset($sales_wastage[$category->ItemGroupID]) ? $sales_wastage[$category->ItemGroupID] : '' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">Sales Wastage Discount (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_wastage_discount_rtd][{{ $category->ItemGroupID }}]" value="{{ isset($sales_wastage_discount[$category->ItemGroupID]) ? $sales_wastage_discount[$category->ItemGroupID] : '' }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Price Calculator For Silver</h2>
                                    </div>
                                    <div class="form_box_info">                                       
                                        @if (count($silver_categories) > 0)
                                            @foreach ($silver_categories as $silver_category)
                                                @php
                                                    $sales_price_rtd_silver = isset($settings['sales_price_rtd_silver']) && !empty($settings['sales_price_rtd_silver']) ? unserialize($settings['sales_price_rtd_silver']) : [];
                                                    $sales_discount_rtd_silver = isset($settings['sales_discount_rtd_silver']) && !empty($settings['sales_discount_rtd_silver']) ? unserialize($settings['sales_discount_rtd_silver']) : [];
                                                @endphp
                                                <div class="row align-items-center">
                                                    <div class="col-md-4">
                                                        <p style="font-size: 14px; text-align:center; margin:0;">
                                                            <strong>{{ $silver_category->SubItemName }}</strong>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">Sales Price</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_price_rtd_silver][{{ $silver_category->SubItemID }}]" value="{{ isset($sales_price_rtd_silver[$silver_category->SubItemID]) ? $sales_price_rtd_silver[$silver_category->SubItemID] : '' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">Sales Discount (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_discount_rtd_silver][{{ $silver_category->SubItemID }}]" value="{{ isset($sales_discount_rtd_silver[$silver_category->SubItemID]) ? $sales_discount_rtd_silver[$silver_category->SubItemID] : '' }}">
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            @can('price-calculator.update-ready-to-dispatch')
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

        $('.numeric').on('input', function() {
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
