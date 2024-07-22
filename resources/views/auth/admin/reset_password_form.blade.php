<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>RESET PASSWORD - IMPEL JEWELLERS</title>
    <link href="{{ asset('public/images/default_images/favicons/impel_apple_touch.png') }}" rel="icon">

    <!-- Favicons -->
    <link href="{{ asset('public/images/default_images/favicons/impel.png') }}" rel="icon">
    <link sizes="180x180" href="{{ asset('public/images/default_images/favicons/impel_apple_touch.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('public/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    {{-- Toastr --}}
    <link href="{{ asset('public/assets/vendor/toastr/css/toastr.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet">

</head>

<body>

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('public/images/default_images/logos/impel-logo2.png') }}" style="width: 100px; max-height: 100px;">
                                </a>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4" style="padding: 0;">Reset Password</h5>
                                    </div>
                                    <form class="row g-3" action="{{ route('admin.reset.password.post') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="token" id="token" value="{{ $token }}">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" name="password" class="form-control {{ ($errors->has('password')) ? 'is-invalid' : '' }}" id="password">
                                                @if($errors->has('password'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('password') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                                <input type="password" name="confirm_password" class="form-control {{ ($errors->has('confirm_password')) ? 'is-invalid' : '' }}" id="confirm_password">
                                                @if($errors->has('confirm_password'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('confirm_password') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Vendor JS Files -->
    <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Jquery --}}
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>

    {{-- Sweet Alert --}}
    <script src="{{ asset('public/assets/js/sweet-alert.js') }}"></script>

    {{-- Toastr --}}
    <script src="{{ asset('public/assets/vendor/toastr/js/toastr.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('public/assets/js/main.js') }}"></script>

    {{-- Custom Script --}}
    <script type="text/javascript">

        // Error Message
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}')
        @endif

    </script>

</body>

</html>
