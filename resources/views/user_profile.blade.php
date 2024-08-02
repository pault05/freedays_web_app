@php use Carbon\Carbon; @endphp

@extends('components.layout')

@section('content')
    <br>
    <div class="container-main d-flex flex-column justify-content-center align-items-center">

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
                                    <input type="hidden" id="role_text" name="role_text"
                                           value="{{ auth()->user()->is_admin ? 'Admin' : 'User' }}">
                                    <label for="role" class="form-label text-start">Role</label>
                                    <div class="dropdown ms-1">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="role"
                                                name="role" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                            {{ $user['is_admin'] ? 'Admin' : 'User' }}
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                            <li><a class="dropdown-item" href="#" onclick="setRole('Admin')">Admin</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#" onclick="setRole('User')">User</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-12">
                                    {{--                                    <div class="col-md-6">--}}
                                    <button type="button" class="btn btn-primary btn-rounded w-100"
                                            id="edit-btn">Edit
                                    </button>
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

                                    {{--                                    </div>--}}
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
                                                document.getElementById('role').setAttribute('disabled', 'disabled');
                                                @endif
                                                @endauth

                                                document.getElementById('edit-btn').style.display = 'block';
                                                document.getElementById('save-btn').style.display = 'none';
                                                document.getElementById('cancel-btn').style.display = 'none';
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-12 mt-3">
                            <form action="{{ route('user-profile.change-password', $user->id) }}" method="POST"
                                  class="change-password-form">
                                @csrf
                                <button class="btn-change-password btn btn-primary btn-rounded w-100"
                                        data-id="{{$user->id}}" type="button">Change Password
                                </button>
                            </form>
                        </div>


                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <script src="https://unpkg.com/@simonwep/pickr/dist/pickr.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    $(document).on('click', '.btn-change-password', function (event) {
                        event.preventDefault();

                        var $button = $(this);

                        var $form = $button.closest('form');
                        var actionUrlChangePassword = $form.attr('action');
                        Swal.fire({
                            title: 'Change Password',
                            html: `
            <input type="password" id="newPassword" class="swal2-input" placeholder="New Password">
            <input type="password" id="confirmPassword" class="swal2-input" placeholder="Confirm New Password">
        `,
                            confirmButtonText: 'Change Password',
                            focusConfirm: false,
                            preConfirm: () => {
                                const newPassword = Swal.getPopup().querySelector('#newPassword').value;
                                const confirmPassword = Swal.getPopup().querySelector('#confirmPassword').value;

                                function isStrongPassword(password) {
                                    // Minimum 8 characters, at least one uppercase letter, one lowercase letter, and one number
                                    const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
                                    return strongPasswordRegex.test(password);
                                }

                                if (!newPassword || !confirmPassword) {
                                    Swal.showValidationMessage('Please enter all fields');
                                    return false;
                                }

                                if (newPassword !== confirmPassword) {
                                    Swal.showValidationMessage('New passwords do not match');
                                    return false;
                                }


                                if (!isStrongPassword(newPassword)) {
                                    Swal.showValidationMessage('Password is not strong enough. It must be at least 8 characters long, and include an uppercase letter, a lowercase letter, and a number.');
                                    return false;
                                }

                                return {
                                    newPassword: newPassword
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                console.log("New Password Data: ", result.value.newPassword); // Adaugă acest rând pentru a verifica datele trimise
                                $.ajax({
                                    url: actionUrlChangePassword,
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        newPassword: result.value.newPassword
                                    },
                                    success: function (response) {
                                        Swal.fire({
                                            title: "Success!",
                                            text: "Password changed successfully",
                                            icon: "success"
                                        });
                                    },
                                    error: function (response) {
                                        console.log(actionUrlChangePassword);
                                        Swal.fire({
                                            title: "Error!",
                                            text: "There was an error changing your password.",
                                            icon: "error"
                                        });
                                    }
                                });
                            }
                        });
                    });
                </script>
            </div>
@endsection
