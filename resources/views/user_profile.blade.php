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
    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow-sm mb-5 w-50 mt-3 bg-primary">
            <h1 class="text-center w-auto" style="text-shadow: 2px 2px 4px black;color: white">User Profile</h1>
        </div>
        <!-- /.card -->

        <div class="card p-5 shadow w-100">


            <div class="container">

                <div class="row g-5">
                    <div class="col-md-5 col-lg-8 mx-auto">
                        <form method="POST" action="/user-profile">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label text-start w-100">First name</label>
                                    <input type="text" class="form-control " id="firstName" name="first_name"
                                           value="{{ $user['first_name']}}" placeholder="" readonly required>
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="lastName" class="form-label text-start w-100">Last name</label>
                                    <input type="text" class="form-control " id="lastName" name="last_name"
                                           value="{{ $user['last_name']}}" placeholder="" readonly required>
                                    <div class="invalid-feedback">
                                        Valid last name is required.
                                    </div>
                                </div>


                                <div class="col-12">
                                    <label for="email" class="form-label text-start w-100">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ $user['email']}}" placeholder="you@example.com" readonly required>
                                    <div class="invalid-feedback">
                                        Please enter a valid email address for shipping updates.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="phone" class="form-label text-start w-100">Phone Number</label>
                                    <input type="text" class="form-control " value="{{ $user['phone']}}" id="phone"
                                           name="phone" readonly>
                                    <div class="invalid-feedback">
                                        Please enter the phone number.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="position" class="form-label text-start w-100">Position</label>
                                    <input type="text" class="form-control " value="{{ $user['position']}}"
                                           id="position" name="position" readonly>
                                    <div class="invalid-feedback">
                                        Please enter the position.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="free_days" class="form-label text-start w-100">Days Off Left</label>
                                    <input type="number" class="form-control " value="{{ $user['days_off_left']}}"
                                           id="free_days" name="free_days" required min="0" step="1" readonly>
                                    <div class="invalid-feedback">
                                        Please enter the number of free days.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="hired_at" class="form-label text-start w-100">Hired At</label>
                                    <input type="text" class="form-control "
                                           value="{{Carbon::parse($user['hired_at'])->format('d/m/y') }}"
                                           id="hired_at" name="hired_at" readonly>
                                    <div class="invalid-feedback">
                                        Please enter the date of hired.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="selected_color" class="form-label text-start w-100">Profile
                                        Color</label>
                                    <input type="color" class="form-control " value="{{ $user['color'] }}"
                                           id="selected_color" name="selected_color" readonly>
                                    <div class="invalid-feedback">
                                        Please enter the date of hired.
                                    </div>
                                </div>

                                <div class="text-center mt-4">
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

                                                document.getElementById('edit-btn').style.display = 'none';
                                                document.getElementById('save-btn').style.display = 'block';
                                                document.getElementById('cancel-btn').style.display = 'block';
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
                                            document.getElementById('save-btn').onclick = function () {
                                                document.getElementById('firstName').setAttribute('readonly', 'readonly');
                                                document.getElementById('lastName').setAttribute('readonly', 'readonly');
                                                document.getElementById('phone').setAttribute('readonly', 'readonly');
                                                document.getElementById('email').setAttribute('readonly', 'readonly');
                                                document.getElementById('selected_color').setAttribute('readonly', 'readonly');

                                                document.getElementById('edit-btn').style.display = 'block';
                                                document.getElementById('save-btn').style.display = 'none';
                                                document.getElementById('cancel-btn').style.display = 'none';
                                            }

                                            document.getElementById('cancel-btn').onclick = function () {
                                                document.getElementById('firstName').setAttribute('readonly', 'readonly');
                                                document.getElementById('lastName').setAttribute('readonly', 'readonly');
                                                document.getElementById('phone').setAttribute('readonly', 'readonly');
                                                document.getElementById('email').setAttribute('readonly', 'readonly');
                                                document.getElementById('selected_color').setAttribute('readonly', 'readonly');

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
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="changePasswordModalLabel">Change
                                                Password</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="change-password-form" method="POST"
                                                  action="/user-profile/change-password">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="current_password">Current Password</label>
                                                    <input type="password" class="form-control"
                                                           id="current_password" name="current_password"
                                                           required>
                                                    @error('current_password')
                                                    The current password is incorrect.
                                                    @enderror
                                                    @error('new_password')
                                                    The new password cannot be the same as current password.
                                                    <div class="invalid-feedback">The current password is
                                                        incorrect.
                                                    </div>
                                                    @enderror
                                                </div>
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
                                                        if (password.value !== confirm_password.value) {

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
                                            </form>
                                        </div>
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
                <script>

                    @error('current_password')
                    $('#changePasswordModal').modal('show');
                    @enderror
                    @error('new_password')
                    $('#changePasswordModal').modal('show');
                    @enderror
                </script>
            </div>
@endsection
