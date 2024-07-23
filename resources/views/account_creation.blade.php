@extends('components.layout')

@section('content')
    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow-sm mb-5 w-50 mt-3 bg-primary">
            <h1 class="text-center w-auto" style="text-shadow: 2px 2px 4px black;color: white">Account Creation</h1>
        </div>
    <!-- /.card -->

    <div class="card p-5 shadow w-100">

            <style>
                .bd-placeholder-img {
                    font-size: 1.125rem;
                    text-anchor: middle;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    user-select: none;
                }

                @media (min-width: 768px) {
                    .bd-placeholder-img-lg {
                        font-size: 3.5rem;
                    }
                }

                .b-example-divider {
                    width: 100%;
                    height: 3rem;
                    background-color: rgba(0, 0, 0, .1);
                    border: solid rgba(0, 0, 0, .15);
                    border-width: 1px 0;
                    box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
                }

                .b-example-vr {
                    flex-shrink: 0;
                    width: 1.5rem;
                    height: 100vh;
                }

                .bi {
                    vertical-align: -.125em;
                    fill: currentColor;
                }

                .nav-scroller {
                    position: relative;
                    z-index: 2;
                    height: 2.75rem;
                    overflow-y: hidden;
                }

                .nav-scroller .nav {
                    display: flex;
                    flex-wrap: nowrap;
                    padding-bottom: 1rem;
                    margin-top: -1px;
                    overflow-x: auto;
                    text-align: center;
                    white-space: nowrap;
                    -webkit-overflow-scrolling: touch;
                }

                .btn-bd-primary {
                    --bd-violet-bg: #712cf9;
                    --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
                    --bs-white: #ffffff;
                    --bs-btn-font-weight: 600;
                    --bs-btn-color: var(--bs-white);
                    --bs-btn-bg: var(--bd-violet-bg);
                    --bs-btn-border-color: var(--bd-violet-bg);
                    --bs-btn-hover-color: var(--bs-white);
                    --bs-btn-hover-bg: #6528e0;
                    --bs-btn-hover-border-color: #6528e0;
                    --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
                    --bs-btn-active-color: var(--bs-btn-hover-color);
                    --bs-btn-active-bg: #5a23c8;
                    --bs-btn-active-border-color: #5a23c8;
                }

                .bd-mode-toggle {
                    z-index: 1500;
                }

                .bd-mode-toggle .dropdown-menu .active .bi {
                    display: block !important;
                }
            </style>



        <div class="container">

                <div class="row g-5">
                    <div class="col-md-5 col-lg-8 mx-auto">
                        <form method="POST" action="/account-creation" >
                            @csrf

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label text-start w-100">First name*</label>
                                    <input type="text" class="form-control " id="firstName" name="first_name" placeholder="" value="" required>
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="lastName" class="form-label text-start w-100">Last name*</label>
                                    <input type="text" class="form-control " id="lastName" name="last_name" placeholder="" value="" required>
                                    <div class="invalid-feedback">
                                        Valid last name is required.
                                    </div>
                                </div>


                                <div class="col-12">
                                    <label for="email" class="form-label text-start w-100">Email*</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid email address for shipping updates.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="phone" class="form-label text-start w-100">Phone</label>
                                    <input type="text" class="form-control " id="phone" name="phone">
                                    <div class="invalid-feedback">
                                        Please enter the phone number.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="position" class="form-label text-start w-100">Position</label>
                                    <input type="text" class="form-control " id="position" name="position">
                                    <div class="invalid-feedback">
                                        Please enter the position.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="free_days" class="form-label text-start w-100">Free days*</label>
                                    <input type="number" class="form-control " id="free_days" name="free_days" required min="0" step="1">
                                    <div class="invalid-feedback">
                                        Please enter the number of free days.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="hired_at" class="form-label text-start w-100">Hired date</label>
                                    <input type="date" class="form-control " id="hired_at" name="hired_at">
                                    <div class="invalid-feedback">
                                        Please enter the date of hired.
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label for="password" class="form-label text-start w-100">Password*</label>
                                    <input type="password" class="form-control " id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                    <div class="invalid-feedback">
                                        Please provide a strong password.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="confirm_password" class="form-label text-start w-100">Password confirmation*</label>
                                    <input type="password" class="form-control " id="confirm_password" name="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                        <div class="invalid-feedback">
                                        The passwords are not the same.
                                    </div>
                                </div>

                                <script>
                                    var password = document.getElementById("password");
                                    var confirm_password = document.getElementById("confirm_password");

                                    function validatePassword(){
                                        if(password.value !== confirm_password.value){
                                            confirm_password.setCustomValidity("Passwords Don't Match");
                                        }else{
                                            confirm_password.setCustomValidity('');
                                        }
                                    }

                                    password.onchange = validatePassword;
                                    confirm_password.onkeyup = validatePassword;
                                </script>
                            </div>

                            <hr class="my-4">

                            <button class="w-100 btn btn-primary btn-lg" type="submit">Create User Profile</button>
                        </form>
                    </div>
                </div>
        </div>
        <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="checkout.js"></script></dic>
    </div>
@endsection

