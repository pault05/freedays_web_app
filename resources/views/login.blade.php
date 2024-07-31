@extends('Components.login-layout')

@section('content')
    <link media="all" type="text/css" rel="stylesheet" href="https://cloud.spinoffice-crm.com/ubold_light/css/common_style.css?ver=20240731.1">
    <link media="all" type="text/css" rel="stylesheet" href="https://cloud.spinoffice-crm.com/ubold_light/css/ubold.css?ver=20240731.1">
    <link href="../../public/css/login.css" rel="stylesheet">
    <body class="d-flex align-items-center py-4 bg-body-tertiary">

    <div id="wrapper">
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">
                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto">
                                    <a href='/login'>
                                        <h4 class="text-secondary">
                                            <img class="mb-4 img-fluid" src={{asset("/images/login_logo.png")}} alt="" width="293" height="52">
                                        </h4>
                                    </a>
                                    <p class="text-muted mb-4 mt-3">Log in to your account</p>

                                </div>

                                <form method="POST" action="/login">
                                    @csrf
                                    <div class="form-group mb-3" style="padding: 2px">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email"
                                               value="{{old('email')}}" required>
                                    </div>
                                    <x-form-error name="email"/>
                                    <div class="form-group mb-3" style="padding: 2px">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit">Log In</button>
                                    <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>
                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
    </div>

@endsection
