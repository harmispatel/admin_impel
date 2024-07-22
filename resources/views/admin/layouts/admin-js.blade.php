<!-- Vendor JS Files -->
<script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('public/assets/js/sweet-alert.js') }}"></script>
<script src="{{ asset('public/assets/vendor/toastr/js/toastr.min.js') }}"></script>
<script src="{{ asset('public/assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@php
    $route = Route::current()->getName();
@endphp

{{-- Common Script --}}
<script type="text/javascript">

    //Initialize Select2 Elements
    $('.select2bs4').select2({
    theme: 'bootstrap5'
    })

    // Toastr Msg Settings
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        timeOut: 4000
    }

    @if(Session::has('message'))
        toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif

    var isDesktop = window.innerWidth > 768; // You can adjust this value as per your requirements
    if (isDesktop) {
        var routes = [
            'designs.create', 'designs.edit', 'dealers.create', 'dealers.edit',
            'sliders.add-slider', 'sliders.edit-slider', 'categories.add',
            'categories.edit', 'users.create', 'users.edit', 'roles.create',
            'roles.edit', 'orders.show'
        ];
        var currentRoute = '{{ $route }}';
        if ($.inArray(currentRoute, routes) !== -1) {
            $('body').addClass('toggle-sidebar');
        }
    }

</script>
