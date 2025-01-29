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
                        <li class="breadcrumb-item active">Ready To Dispatch</li>
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
                                <!-- company master Impel-->
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>IMPEL</h2>
                                    </div>
                                    <div class="form_box_info">
                                        @if (!empty($subItems_IMPEL))
                                            @foreach ($subItems_IMPEL as $subItem)
                                                @php
                                                    $sales_price_24k = isset($settings['price_24k']) && !empty($settings['price_24k']) ? unserialize($settings['price_24k']) : [];
                                                    $sales_wastage = isset($settings['sales_wastage_rtd']) && !empty($settings['sales_wastage_rtd']) ? unserialize($settings['sales_wastage_rtd']) : [];
                                                    $sales_wastage_discount = isset($settings['sales_wastage_discount_rtd']) && !empty($settings['sales_wastage_discount_rtd']) ? unserialize($settings['sales_wastage_discount_rtd']) : [];
                                                    $sales_show_estimate = isset($settings['show_estimate']) && !empty($settings['show_estimate']) ? unserialize($settings['show_estimate']) : [];
                                                @endphp
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-md-2">
                                                        <p style="font-size: 14px; text-align:center; margin:0;">
                                                            <strong>{{ $subItem->SubItemName }}</strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="" class="form-label">24k Price</label>
                                                        <input type="text" class="form-control numeric" name="settings[price_24k][{{ $subItem->SubItemID }}]" value="{{ isset($sales_price_24k[$subItem->SubItemID]) ? $sales_price_24k[$subItem->SubItemID] : '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="form-label">Sales Wastage (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_wastage_rtd][{{ $subItem->SubItemID }}]" value="{{ isset($sales_wastage[$subItem->SubItemID]) ? $sales_wastage[$subItem->SubItemID] : '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="form-label">Sales Wastage Discount (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_wastage_discount_rtd][{{ $subItem->SubItemID }}]" value="{{ isset($sales_wastage_discount[$subItem->SubItemID]) ? $sales_wastage_discount[$subItem->SubItemID] : '' }}">
                                                    </div>
                                                    @php
                                                        $checked = isset($sales_show_estimate[$subItem->SubItemID]) && $sales_show_estimate[$subItem->SubItemID] == 1 ? 'checked' : '';
                                                    @endphp

                                                    <div class="col-md-2">
                                                        <label class="form-label">Show Estimate</label>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch" name="settings[show_estimate][{{ $subItem->SubItemID }}]" value="1" {{$checked}}>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-12">
                                                <p style="font-size: 14px; text-align:center; margin:0;">
                                                    <strong>IMPEL Comapny Master Not Activated</strong>
                                                </p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>


                                <!-- company master IJPL-->
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>IJPL</h2>
                                    </div>
                                    <div class="form_box_info">
                                        @if (!empty($subItems_IJPL))
                                            @foreach ($subItems_IJPL as $subItem)
                                                @php
                                                    $sales_price_24k = isset($settings['price_24k']) && !empty($settings['price_24k']) ? unserialize($settings['price_24k']) : [];
                                                    $sales_wastage = isset($settings['sales_wastage_rtd']) && !empty($settings['sales_wastage_rtd']) ? unserialize($settings['sales_wastage_rtd']) : [];
                                                    $sales_wastage_discount = isset($settings['sales_wastage_discount_rtd']) && !empty($settings['sales_wastage_discount_rtd']) ? unserialize($settings['sales_wastage_discount_rtd']) : [];
                                                    $sales_show_estimate = isset($settings['show_estimate']) && !empty($settings['show_estimate']) ? unserialize($settings['show_estimate']) : [];
                                                @endphp
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-md-2">
                                                        <p style="font-size: 14px; text-align:center; margin:0;">
                                                            <strong>{{ $subItem->SubItemName }}</strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="" class="form-label">24k Price</label>
                                                        <input type="text" class="form-control numeric" name="settings[price_24k][{{ $subItem->SubItemID }}]" value="{{ isset($sales_price_24k[$subItem->SubItemID]) ? $sales_price_24k[$subItem->SubItemID] : '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="form-label">Sales Wastage (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_wastage_rtd][{{ $subItem->SubItemID }}]" value="{{ isset($sales_wastage[$subItem->SubItemID]) ? $sales_wastage[$subItem->SubItemID] : '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="form-label">Sales Wastage Discount (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_wastage_discount_rtd][{{ $subItem->SubItemID }}]" value="{{ isset($sales_wastage_discount[$subItem->SubItemID]) ? $sales_wastage_discount[$subItem->SubItemID] : '' }}">
                                                    </div>
                                                    @php
                                                        $checked = isset($sales_show_estimate[$subItem->SubItemID]) && $sales_show_estimate[$subItem->SubItemID] == 1 ? 'checked' : '';
                                                    @endphp

                                                    <div class="col-md-2">
                                                        <label class="form-label">Show Estimate</label>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch" name="settings[show_estimate][{{ $subItem->SubItemID }}]" value="1" {{$checked}}>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <!-- company master AURAM-->
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>AURAM</h2>
                                    </div>
                                    <div class="form_box_info">
                                        @if (!empty($subItems_AURAM))
                                            @foreach ($subItems_AURAM as $subItem)
                                                @php
                                                    $sales_price_24k = isset($settings['price_24k']) && !empty($settings['price_24k']) ? unserialize($settings['price_24k']) : [];
                                                    $sales_wastage = isset($settings['sales_wastage_rtd']) && !empty($settings['sales_wastage_rtd']) ? unserialize($settings['sales_wastage_rtd']) : [];
                                                    $sales_wastage_discount = isset($settings['sales_wastage_discount_rtd']) && !empty($settings['sales_wastage_discount_rtd']) ? unserialize($settings['sales_wastage_discount_rtd']) : [];
                                                    $sales_show_estimate = isset($settings['show_estimate']) && !empty($settings['show_estimate']) ? unserialize($settings['show_estimate']) : [];
                                                @endphp
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-md-2">
                                                        <p style="font-size: 14px; text-align:center; margin:0;">
                                                            <strong>{{ $subItem->SubItemName }}</strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="" class="form-label">24k Price</label>
                                                        <input type="text" class="form-control numeric" name="settings[price_24k][{{ $subItem->SubItemID }}]" value="{{ isset($sales_price_24k[$subItem->SubItemID]) ? $sales_price_24k[$subItem->SubItemID] : '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="form-label">Sales Wastage (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_wastage_rtd][{{ $subItem->SubItemID }}]" value="{{ isset($sales_wastage[$subItem->SubItemID]) ? $sales_wastage[$subItem->SubItemID] : '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="form-label">Sales Wastage Discount (%)</label>
                                                        <input type="text" class="form-control numeric" name="settings[sales_wastage_discount_rtd][{{ $subItem->SubItemID }}]" value="{{ isset($sales_wastage_discount[$subItem->SubItemID]) ? $sales_wastage_discount[$subItem->SubItemID] : '' }}">
                                                    </div>
                                                    @php
                                                        $checked = isset($sales_show_estimate[$subItem->SubItemID]) && $sales_show_estimate[$subItem->SubItemID] == 1 ? 'checked' : '';
                                                    @endphp

                                                    <div class="col-md-2">
                                                        <label class="form-label">Show Estimate</label>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch" name="settings[show_estimate][{{ $subItem->SubItemID }}]" value="1" {{$checked}}>
                                                        </div>
                                                    </div>
                                                </div>
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
