@php
    $quote .= '»';
@endphp

@foreach($subcategories as $subcategory)
    <option value="{{ $subcategory->id }}"> {{ $quote }} {{ $subcategory->name }}</option>
    @if(count($subcategory->subcategories) > 0)
        @include('admin.categories.child_categories',['subcategories' => $subcategory->subcategories])
    @endif
@endforeach
