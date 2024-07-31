@php use Carbon\Carbon; @endphp
<style>
    input[readonly] {
        pointer-events: none;
    }

    /* Modal styles */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
    }

</style>


@extends('components.layout')

@section('content')
<br>
        <!-- /.card -->

        <div class="card p-5 shadow w-100">


            <div class="container">

                <div class="row g-5">
                    <div class="col-md-5 col-lg-8 mx-auto">
                        <form method="POST" action="/user-profile/{{ $user['id'] }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label text-start w-100">First name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name"
                                           value="{{ $user['first_name'] }}" placeholder="" readonly required>
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="lastName" class="form-label text-start w-100">Last name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name"
                                           value="{{ $user['last_name'] }}" placeholder="" readonly required>
                                    <div class="invalid-feedback">
                                        Valid last name is required.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label text-start w-100">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ $user['email'] }}" placeholder="you@example.com" readonly required>
                                    <div class="invalid-feedback">
                                        Please enter a valid email address for shipping updates.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="phone" class="form-label text-start w-100">Phone Number</label>
                                    <input type="text" class="form-control" value="{{ $user['phone'] }}" id="phone"
                                           name="phone" readonly>
                                    <div class="invalid-feedback">
                                        Please enter the phone number.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="position" class="form-label text-start w-100">Position</label>
                                    <input type="text" class="form-control" value="{{ $user['position'] }}"
                                           id="position" name="position" readonly>
                                    <div class="invalid-feedback">
                                        Please enter the position.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="free_days" class="form-label text-start w-100">Days Off Left</label>
                                    <input type="number" class="form-control" value="{{ $user['free_days'] }}"
                                           id="free_days" name="free_days" required min="0" step="1" readonly>
                                    <div class="invalid-feedback">
                                        Please enter the number of free days.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="hired_at" class="form-label text-start w-100">Hired At</label>
                                    <input type="text" class="form-control"
                                           value="{{ \Carbon\Carbon::parse($user['hired_at'])->format('d/m/y') }}"
                                           id="hired_at" name="hired_at" readonly>
                                    <div class="invalid-feedback">
                                        Please enter the date of hire.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="selected_color" class="form-label text-start w-100">Profile
                                        Color</label>
                                    <input type="color" class="form-control" value="{{ $user['color'] }}"
                                           id="selected_color" name="selected_color" readonly>
                                    <div class="invalid-feedback">
                                        Please enter the profile color.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <input type="hidden" id="role_text" name="role_text" value="{{ auth()->user()->is_admin ? 'Admin' : 'User' }}">
                                    <label for="role" class="form-label text-start">Role</label>
                                    <div class="dropdown ms-1">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="role" name="role" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                            {{ $user['is_admin'] ? 'Admin' : 'User' }}
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                            <li><a class="dropdown-item" href="#" onclick="setRole('Admin')">Admin</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="setRole('User')">User</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="text-center mt-4 col-12">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-primary btn-rounded w-100"
                                                    id="edit-btn">Edit
                                            </button>
                                        </div>
                                        <script>


                                            document.getElementById('edit-btn').onclick = function () {
                                                document.getElementById('firstName').removeAttribute('readonly');
                                                document.getElementById('lastName').removeAttribute('readonly');
                                                document.getElementById('phone').removeAttribute('readonly');
                                                document.getElementById('email').removeAttribute('readonly');
                                                document.getElementById('selected_color').removeAttribute('readonly');

                                                @auth
                                                @if(auth()->user()->is_admin)
                                                document.getElementById('position').removeAttribute('readonly');
                                                document.getElementById('free_days').removeAttribute('readonly');
                                                document.getElementById('role').removeAttribute('disabled');
                                                @endif
                                                @endauth

                                                document.getElementById('edit-btn').style.display = 'none';
                                                document.getElementById('save-btn').style.display = 'block';
                                                document.getElementById('cancel-btn').style.display = 'block';
                                            }

                                            function setRole(role) {
                                                document.getElementById('role').textContent = role;
                                                document.getElementById('role_text').value = role;
                                            }

                                        </script>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-secondary btn-rounded w-100"
                                                    id="change-password-btn" data-toggle="modal"
                                                    data-target="#changePasswordModal">Change Password
                                            </button>
                                        </div>
                                        <script>
                                            const modal = document.getElementById("changePasswordModal");
                                            const btn = document.getElementById("change-password-btn");

                                            btn.onclick = function () {
                                                modal.style.display = "block";
                                            }
                                        </script>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary btn-rounded w-100"
                                                    id="save-btn" style="display: none;">Save
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-secondary btn-rounded w-100"
                                                    id="cancel-btn" style="display: none;">
                                                Cancel
                                            </button>
                                        </div>
                                        <script>
                                            document.getElementById('save-btn').onclick = function (){
                                                var roleText = document.getElementById('role').textContent.trim();
                                                document.getElementById('role_text').value = roleText;
                                            }

                                            document.getElementById('cancel-btn').onclick = function () {
                                                document.getElementById('firstName').setAttribute('readonly', 'readonly');
                                                document.getElementById('lastName').setAttribute('readonly', 'readonly');
                                                document.getElementById('phone').setAttribute('readonly', 'readonly');
                                                document.getElementById('email').setAttribute('readonly', 'readonly');
                                                document.getElementById('selected_color').setAttribute('readonly', 'readonly');

                                                @auth
                                                @if(auth()->user()->is_admin)
                                                document.getElementById('position').setAttribute('readonly', 'readonly');
                                                document.getElementById('free_days').setAttribute('readonly', 'readonly');
                                                document.getElementById('role').setAttribute('disabled','disabled');
                                                @endif
                                                @endauth

                                                document.getElementById('edit-btn').style.display = 'block';
                                                document.getElementById('save-btn').style.display = 'none';
                                                document.getElementById('cancel-btn').style.display = 'none';
                                            }
                                        </script>
                                    </div>
                                </div>
                                <hr class="my-2">
                            </div>
                        </form>
                        <!-- The Modal -->
                        <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
                             aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="change-password-form" method="POST"
                                              action="/user-profile/change-password/{{ $user['id'] }}">
                                            @csrf
                                            <input type="hidden" name="user_id" id="reset_user_id" value="{{$user['id']}}">

                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="new_password">New Password</label>
                                                    <input type="password" class="form-control"
                                                           id="new_password" name="new_password"
                                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                           title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                                           required>
                                                    <div class="invalid-feedback">Please provide a strong
                                                        password.
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm_password">Confirm New
                                                        Password</label>
                                                    <input type="password" class="form-control"
                                                           id="confirm_password" name="confirm_password"
                                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                           title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                                           required>
                                                    <div class="invalid-feedback">The passwords do not
                                                        match.
                                                    </div>
                                                </div>
                                                <div id="password-feedback" class="alert" role="alert"
                                                     style="display: none;"></div>
                                                <script>
                                                    const new_password = document.getElementById("new_password");
                                                    const confirm_password = document.getElementById("confirm_password");

                                                    function validatePassword() {
                                                        if (new_password.value !== confirm_password.value) {

                                                            if (new_password.value !== confirm_password.value) {
                                                                confirm_password.setCustomValidity("Passwords Don't Match");
                                                            } else {
                                                                confirm_password.setCustomValidity('');
                                                            }
                                                        }

                                                        new_password.onchange = validatePassword;
                                                        confirm_password.onkeyup = validatePassword;
                                                    }
                                                </script>
                                                <br>
                                                <button type="submit" class="btn btn-primary btn-rounded">
                                                    Save changes
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-rounded"
                                                        data-dismiss="modal">Cancel
                                                </button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <!-- Bootstrap JS and dependencies -->
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <!-- Pickr JS -->
                <script src="https://unpkg.com/@simonwep/pickr/dist/pickr.min.js"></script>
                <!-- Custom JS -->
            </div>
@endsection
