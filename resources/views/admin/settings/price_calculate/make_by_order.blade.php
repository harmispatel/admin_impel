@extends('admin.layouts.admin-layout')

@section('title', 'PRICE CALCULATOR -Make By Order- IMPEL JEWELLERS')

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
                    <li class="breadcrumb-item active">Make By Order</li>

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

                <form class="form" action="{{ route('price-calculator.update-make-by-order') }}" method="POST" enctype="multipart/form-data">

                    <div class="card-body">

                        @csrf

                        <div class="form_box">
                            <!-- make by order -->
                            <div class="form_box_inr">
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
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-center">

                        @can('price-calculator.update-make-by-order')
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
