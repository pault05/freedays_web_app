{{--@extends('components.layout')--}}

{{--@section('content')--}}

{{--    <!-- Bootstrap CSS -->--}}
{{--    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">--}}
{{--    <!-- FontAwesome for icons -->--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">--}}
{{--    <!-- Pickr CSS -->--}}
{{--    <link rel="stylesheet" href="https://unpkg.com/@simonwep/pickr/dist/themes/classic.min.css">--}}
{{--    <!-- Custom CSS -->--}}
{{--    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">--}}

{{--<div class="profile-text">--}}
{{--    <h1 class="title">User Profile</h1>--}}
{{--</div>--}}
{{--<form method="POST" action="/user-profile">--}}
{{--    @csrf--}}
{{--    <div class="container">--}}
{{--        <div class="profile-container mx-auto">--}}
{{--            <div class="profile-header">--}}
{{--                <div>--}}
{{--                    <img src="{{ asset('images/default.jpg') }}" id="profile-img" class="profile-img" alt="">--}}
{{--                    <label for="file-input" class="custom-file-upload">--}}
{{--                        <i class="fas fa-upload"></i> Upload Photo--}}
{{--                    </label>--}}
{{--                    <input type="file" id="file-input" style="display: none;" onchange="previewImage(event)">--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <form id="profile-form">--}}
{{--                <div class="form-group">--}}
{{--                    <label for="first-name">First Name</label>--}}
{{--                    <input type="text" class="form-control rounded-input" id="first-name" name="first_name" value="{{ $user['first_name'] }}">--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="last-name">Last Name</label>--}}
{{--                    <input type="text" class="form-control rounded-input" id="last-name" name="last_name" value="{{ $user['last_name'] }}">--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="email">Email</label>--}}
{{--                    <input type="email" class="form-control rounded-input" id="email" name="email" value="{{ $user['email'] }}">--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="phone">Phone Number</label>--}}
{{--                    <input type="tel" class="form-control rounded-input" id="phone" name="phone" value="{{ $user['phone'] }}">--}}
{{--                </div>--}}
{{--                <div class="form-group mt-4">--}}
{{--                    <label for="days-off">Days Off Left</label>--}}
{{--                    <input type="text" class="form-control rounded-input" id="days-off" value="{{ $user['days_off_left'] }}" disabled>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="hired_at">Hired At</label>--}}
{{--                    <input type="date" class="form-control rounded-input" id="hired_at" value="{{ $user['hired_at'] }}" disabled>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="selected_color">Profile Color</label>--}}
{{--                    <br>--}}
{{--                    <input type="color" value="{{ $user['color'] }}" id="selected_color" name="selected_color"/>--}}
{{--                </div>--}}


{{--                <div class="text-center mt-4">--}}
{{--                    <div class="row mb-2">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <button type="button" class="btn btn-edit btn-rounded w-100" id="edit-btn" onclick="enableEditing()">Edit</button>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <button type="button" class="btn btn-change-password btn-rounded w-100" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <button type="submit" class="btn btn-save btn-rounded w-100" id="save-btn" onclick="saveChanges()" style="display: none;">Save</button>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <button type="button" class="btn btn-cancel btn-rounded w-100" id="cancel-btn" onclick="cancelEditing()" style="display: none;">Cancel</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}

{{--        <!-- Change Password Modal -->--}}
{{--        <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">--}}
{{--            <div class="modal-dialog" role="document">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                            <span aria-hidden="true">&times;</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        <form id="change-password-form" method="POST" action="/user-profile/change-password">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="current_password">Current Password</label>--}}
{{--                                <input type="password" class="form-control" id="current_password" name="current_password" required>--}}
{{--                                @error('current_password')--}}
{{--                                    The current password is incorrect.--}}
{{--                                @enderror--}}
{{--                                @error('new_password')--}}
{{--                                    The new password cannot be the same as current password.--}}
{{--                                <div class="invalid-feedback">The current password is incorrect.</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="new_password">New Password</label>--}}
{{--                                <input type="password" class="form-control" id="new_password" name="new_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>--}}
{{--                                <div class="invalid-feedback">Please provide a strong password.</div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="confirm_password">Confirm New Password</label>--}}
{{--                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>--}}
{{--                                <div class="invalid-feedback">The passwords do not match.</div>--}}
{{--                            </div>--}}
{{--                            <div id="password-feedback" class="alert" role="alert" style="display: none;"></div>--}}
{{--                            <script>--}}

{{--                                var new_password = document.getElementById("new_password");--}}
{{--                                var confirm_password = document.getElementById("confirm_password");--}}

{{--                                function validatePassword(){--}}
{{--                                    if(password.value !== confirm_password.value){--}}

{{--                                    if(new_password.value !== confirm_password.value){--}}
{{--                                        confirm_password.setCustomValidity("Passwords Don't Match");--}}
{{--                                    }--}}
{{--                                    else{--}}
{{--                                        confirm_password.setCustomValidity('');--}}
{{--                                    }--}}
{{--                                }--}}

{{--                                new_password.onchange = validatePassword;--}}
{{--                                confirm_password.onkeyup = validatePassword;--}}
{{--                            </script>--}}
{{--                            <button type="submit" class="btn btn-primary btn-rounded">Save changes</button>--}}
{{--                            <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cancel</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</form>--}}

{{--<!-- Bootstrap JS and dependencies -->--}}
{{--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>--}}
{{--<!-- Pickr JS -->--}}
{{--<script src="https://unpkg.com/@simonwep/pickr/dist/pickr.min.js"></script>--}}
{{--<script>--}}
{{--    function previewImage(event) {--}}
{{--        const reader = new FileReader();--}}
{{--        reader.onload = function() {--}}
{{--            const output = document.getElementById('profile-img');--}}
{{--            output.src = reader.result;--}}
{{--        };--}}
{{--        reader.readAsDataURL(event.target.files[0]);--}}
{{--    }--}}

{{--    function enableEditing() {--}}
{{--        document.querySelectorAll('#profile-form input').forEach(input => {--}}
{{--            input.disabled = false;--}}
{{--        });--}}
{{--        document.getElementById('edit-btn').style.display = 'none';--}}
{{--        document.getElementById('save-btn').style.display = 'block';--}}
{{--        document.getElementById('cancel-btn').style.display = 'block';--}}
{{--    }--}}

{{--    function saveChanges() {--}}
{{--        document.querySelectorAll('#profile-form input').forEach(input => {--}}
{{--            input.disabled = true;--}}
{{--        });--}}
{{--        document.getElementById('edit-btn').style.display = 'block';--}}
{{--        document.getElementById('save-btn').style.display = 'none';--}}
{{--        document.getElementById('cancel-btn').style.display = 'none';--}}
{{--    }--}}

{{--    function cancelEditing() {--}}
{{--        document.querySelectorAll('#profile-form input').forEach(input => {--}}
{{--            input.disabled = true;--}}
{{--        });--}}
{{--        document.getElementById('edit-btn').style.display = 'block';--}}
{{--        document.getElementById('save-btn').style.display = 'none';--}}
{{--        document.getElementById('cancel-btn').style.display = 'none';--}}
{{--    }--}}

{{--</script>--}}
{{--@endsection--}}


@extends('components.layout')

@section('content')
    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow-sm mb-5 w-50 mt-3 bg-primary">
            <h1 class="text-center w-auto" style="text-shadow: 2px 2px 4px black;color: white">User Profile</h1>
        </div>
        <!-- /.card -->

        <div class="card p-5 shadow w-100">

{{--            <style>--}}
{{--                .bd-placeholder-img {--}}
{{--                    font-size: 1.125rem;--}}
{{--                    text-anchor: middle;--}}
{{--                    -webkit-user-select: none;--}}
{{--                    -moz-user-select: none;--}}
{{--                    user-select: none;--}}
{{--                }--}}

{{--                @media (min-width: 768px) {--}}
{{--                    .bd-placeholder-img-lg {--}}
{{--                        font-size: 3.5rem;--}}
{{--                    }--}}
{{--                }--}}

{{--                .b-example-divider {--}}
{{--                    width: 100%;--}}
{{--                    height: 3rem;--}}
{{--                    background-color: rgba(0, 0, 0, .1);--}}
{{--                    border: solid rgba(0, 0, 0, .15);--}}
{{--                    border-width: 1px 0;--}}
{{--                    box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);--}}
{{--                }--}}

{{--                .b-example-vr {--}}
{{--                    flex-shrink: 0;--}}
{{--                    width: 1.5rem;--}}
{{--                    height: 100vh;--}}
{{--                }--}}

{{--                .bi {--}}
{{--                    vertical-align: -.125em;--}}
{{--                    fill: currentColor;--}}
{{--                }--}}

{{--                .nav-scroller {--}}
{{--                    position: relative;--}}
{{--                    z-index: 2;--}}
{{--                    height: 2.75rem;--}}
{{--                    overflow-y: hidden;--}}
{{--                }--}}

{{--                .nav-scroller .nav {--}}
{{--                    display: flex;--}}
{{--                    flex-wrap: nowrap;--}}
{{--                    padding-bottom: 1rem;--}}
{{--                    margin-top: -1px;--}}
{{--                    overflow-x: auto;--}}
{{--                    text-align: center;--}}
{{--                    white-space: nowrap;--}}
{{--                    -webkit-overflow-scrolling: touch;--}}
{{--                }--}}

{{--                .btn-bd-primary {--}}
{{--                    --bd-violet-bg: #712cf9;--}}
{{--                    --bd-violet-rgb: 112.520718, 44.062154, 249.437846;--}}
{{--                    --bs-white: #ffffff;--}}
{{--                    --bs-btn-font-weight: 600;--}}
{{--                    --bs-btn-color: var(--bs-white);--}}
{{--                    --bs-btn-bg: var(--bd-violet-bg);--}}
{{--                    --bs-btn-border-color: var(--bd-violet-bg);--}}
{{--                    --bs-btn-hover-color: var(--bs-white);--}}
{{--                    --bs-btn-hover-bg: #6528e0;--}}
{{--                    --bs-btn-hover-border-color: #6528e0;--}}
{{--                    --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);--}}
{{--                    --bs-btn-active-color: var(--bs-btn-hover-color);--}}
{{--                    --bs-btn-active-bg: #5a23c8;--}}
{{--                    --bs-btn-active-border-color: #5a23c8;--}}
{{--                }--}}

{{--                .bd-mode-toggle {--}}
{{--                    z-index: 1500;--}}
{{--                }--}}

{{--                .bd-mode-toggle .dropdown-menu .active .bi {--}}
{{--                    display: block !important;--}}
{{--                }--}}
{{--            </style>--}}



            <div class="container">

                <div class="row g-5">
                    <div class="col-md-5 col-lg-8 mx-auto">
                        <form method="POST" action="/user-profile">
                            @csrf

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label text-start w-100">First name</label>
                                    <input type="text" class="form-control " id="firstName" name="first_name" value="{{ $user['first_name']}}" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="lastName" class="form-label text-start w-100">Last name</label>
                                    <input type="text" class="form-control " id="lastName" name="last_name" value="{{ $user['last_name']}}" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Valid last name is required.
                                    </div>
                                </div>


                                <div class="col-12">
                                    <label for="email" class="form-label text-start w-100">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user['email']}}" placeholder="you@example.com" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid email address for shipping updates.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="phone" class="form-label text-start w-100">Phone Number</label>
                                    <input type="text" class="form-control " value="{{ $user['phone']}}" id="phone" name="phone">
                                    <div class="invalid-feedback">
                                        Please enter the phone number.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="position" class="form-label text-start w-100">Position</label>
                                    <input type="text" class="form-control " value="{{ $user['position']}}" id="position" name="position">
                                    <div class="invalid-feedback">
                                        Please enter the position.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="free_days" class="form-label text-start w-100">Days Off Left</label>
                                    <input type="number" class="form-control " value="{{ $user['days_off_left']}}" id="free_days" name="free_days" required min="0" step="1">
                                    <div class="invalid-feedback">
                                        Please enter the number of free days.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="hired_at" class="form-label text-start w-100">Hired At</label>
                                    <input type="date" class="form-control " value="{{ $user['hired_at']}}" id="hired_at" name="hired_at">
                                    <div class="invalid-feedback">
                                        Please enter the date of hired.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="selected_color" class="form-label text-start w-100">Profile Color</label>
                                    <input type="color" class="form-control " value="{{ $user['color'] }}" id="selected_color" name="selected_color">
                                    <div class="invalid-feedback">
                                        Please enter the date of hired.
                                    </div>
                                </div>

                            </div>

                            <hr class="my-4">

                            <div class="text-center mt-4">
                                        <div class="row mb-2">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-edit btn-rounded w-100" id="edit-btn" onclick="enableEditing()">Edit</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-change-password btn-rounded w-100" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-save btn-rounded w-100" id="save-btn" onclick="saveChanges()" style="display: none;">Save</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-cancel btn-rounded w-100" id="cancel-btn" onclick="cancelEditing()" style="display: none;">Cancel</button>
                                        </div>
                                    </div>
                            </div>

                     </form>
                    </div>
                            <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="change-password-form" method="POST" action="/user-profile/change-password">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="current_password">Current Password</label>
                                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                                    @error('current_password')
                                                        The current password is incorrect.
                                                    @enderror
                                                    @error('new_password')
                                                        The new password cannot be the same as current password.
                                                    <div class="invalid-feedback">The current password is incorrect.</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="new_password">New Password</label>
                                                    <input type="password" class="form-control" id="new_password" name="new_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                                    <div class="invalid-feedback">Please provide a strong password.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm_password">Confirm New Password</label>
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                                    <div class="invalid-feedback">The passwords do not match.</div>
                                                </div>
                                                <div id="password-feedback" class="alert" role="alert" style="display: none;"></div>
                                                <script>

                                                    var new_password = document.getElementById("new_password");
                                                    var confirm_password = document.getElementById("confirm_password");

                                                    function validatePassword(){
                                                        if(password.value !== confirm_password.value){

                                                        if(new_password.value !== confirm_password.value){
                                                            confirm_password.setCustomValidity("Passwords Don't Match");
                                                        }
                                                        else{
                                                            confirm_password.setCustomValidity('');
                                                        }
                                                    }

                                                    new_password.onchange = validatePassword;
                                                    confirm_password.onkeyup = validatePassword;}
                                                </script>
                                                <div class="row ms-1 mt-5">
                                                    <div class="d-flex justify-content-end" style="margin-left: 89%; width: 1%">
                                                <button type="submit" class="btn btn-primary ms-3">Save changes</button>
                                                <button type="button" class="btn btn-secondary ms-3" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
            <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <script src="checkout.js"></script></dic>
        <script src="https://unpkg.com/@simonwep/pickr/dist/pickr.min.js"></script>
        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    const output = document.getElementById('profile-img');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }

            function enableEditing() {
                document.querySelectorAll('#profile-form input').forEach(input => {
                    input.disabled = false;
                });
                document.getElementById('edit-btn').style.display = 'none';
                document.getElementById('save-btn').style.display = 'block';
                document.getElementById('cancel-btn').style.display = 'block';
            }

            function saveChanges() {
                document.querySelectorAll('#profile-form input').forEach(input => {
                    input.disabled = true;
                });
                document.getElementById('edit-btn').style.display = 'block';
                document.getElementById('save-btn').style.display = 'none';
                document.getElementById('cancel-btn').style.display = 'none';
            }

            function cancelEditing() {
                document.querySelectorAll('#profile-form input').forEach(input => {
                    input.disabled = true;
                });
                document.getElementById('edit-btn').style.display = 'block';
                document.getElementById('save-btn').style.display = 'none';
                document.getElementById('cancel-btn').style.display = 'none';
            }

        </script>
        </div>
@endsection


