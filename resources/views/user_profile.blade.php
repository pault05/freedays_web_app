@extends('components.layout')

@section('content')

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Pickr CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@simonwep/pickr/dist/themes/classic.min.css">
    <!-- Custom CSS -->
    <style>
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 0 1rem;
        }

        .center-box {
            width: 100%;
            max-width: 2000px;
            padding: 2rem;
            background-color: #007bff;
            color: white;
            text-align: center;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
            margin-bottom: 3rem;
            margin-top: 4rem;
        }

        .profile-container {
            padding: 5rem;
            border-radius: 0.75rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: auto;
            font-size: 1.15rem;
            width: 100%;
        }

        .profile-header {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .rounded-input {
            border-radius: 0.25rem;
            padding: 1rem;
            font-size: 1.1rem;
        }

        .btn-rounded {
            border-radius: 0.25rem;
        }

        .footer {
            text-align: center;
            margin-top: 3rem;
        }

        .help-footer a {
            margin: 0 0.75rem;
        }
    </style>

    <div class="container d-flex flex-column justify-content-center align-items-center py-5">
        <div class="center-box">
            <h1 class="text-center" style="text-shadow: 2px 2px 4px black;">User Profile</h1>
        </div>

        <!-- Profile Form -->
        <form method="POST" action="/user-profile" id="profile-form">
            @csrf
            <div class="profile-container">
                <div class="profile-header">
                    <div>
                        <img src="{{ asset('images/default.jpg') }}" id="profile-img" class="profile-img" alt="">
                        <label for="file-input" class="btn btn-secondary mt-3">
                            <i class="fas fa-upload"></i> Upload Photo
                        </label>
                        <input type="file" id="file-input" style="display: none;" onchange="previewImage(event)">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="first-name" class="form-label">First Name</label>
                    <input type="text" class="form-control rounded-input" id="first-name" name="first_name" value="{{ $user['first_name'] }}">
                </div>
                <div class="mb-4">
                    <label for="last-name" class="form-label">Last Name</label>
                    <input type="text" class="form-control rounded-input" id="last-name" name="last_name" value="{{ $user['last_name'] }}">
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control rounded-input" id="email" name="email" value="{{ $user['email'] }}">
                </div>
                <div class="mb-4">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control rounded-input" id="phone" name="phone" value="{{ $user['phone'] }}">
                </div>
                <div class="mb-4">
                    <label for="days-off" class="form-label">Days Off Left</label>
                    <input type="text" class="form-control rounded-input" id="days-off" value="{{ $user['days_off_left'] }}" disabled>
                </div>
                <div class="mb-4">
                    <label for="hired_at" class="form-label">Hired At</label>
                    <input type="date" class="form-control rounded-input" id="hired_at" value="{{ $user['hired_at'] }}" disabled>
                </div>

                <!-- Color Picker -->
                <div class="mb-4">
                    <label for="profile-color" class="form-label">Profile Color</label>
                    <div class="position-relative">
                        <div id="color-picker"></div>
                        <input type="hidden" id="profile-color" name="profile_color" value="{{ $user['profile_color'] ?? '#ffffff' }}">
                    </div>
                </div>


                <div class="text-center mt-4">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary btn-rounded w-100" id="edit-btn" onclick="enableEditing()">Edit</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-secondary btn-rounded w-100" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success btn-rounded w-100" id="save-btn" onclick="saveChanges()" style="display: none;">Save</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger btn-rounded w-100" id="cancel-btn" onclick="cancelEditing()" style="display: none;">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Change Password Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="change-password-form" method="POST" action="/user-profile">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                @error('current_password')
                                    The current password is incorrect.
                                @enderror
                                @error('new_password')
                                    The new password cannot be the same as current password.
                                <div class="invalid-feedback">The current password is incorrect.</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                <div class="invalid-feedback">Please provide a strong password.</div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
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
                                confirm_password.onkeyup = validatePassword;
                            </script>
                            <button type="submit" class="btn btn-primary btn-rounded">Save changes</button>
                            <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2024 VacationVault. All rights reserved.</p>
            <div class="help-footer">
                <a href="#">Regulament</a>
                <a href="#">Contact Support</a>
            </div>
        </footer>
    </div>
</form>

    <!-- Bootstrap JS and dependencies -->
    {{--    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>--}}

    {{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>--}}
    <!-- Pickr JS -->
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
            document.getElementById('profile-color').disabled = false;
            document.getElementById('edit-btn').style.display = 'none';
            document.getElementById('save-btn').style.display = 'block';
            document.getElementById('cancel-btn').style.display = 'block';
        }

        function saveChanges() {
            document.querySelectorAll('#profile-form input').forEach(input => {
                input.disabled = true;
            });
            document.getElementById('profile-color').disabled = true;
            document.getElementById('edit-btn').style.display = 'block';
            document.getElementById('save-btn').style.display = 'none';
            document.getElementById('cancel-btn').style.display = 'none';
        }

        function cancelEditing() {
            document.querySelectorAll('#profile-form input').forEach(input => {
                input.disabled = true;
            });
            document.getElementById('profile-color').disabled = true;
            document.getElementById('edit-btn').style.display = 'block';
            document.getElementById('save-btn').style.display = 'none';
            document.getElementById('cancel-btn').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const pickr = Pickr.create({
                el: '#color-picker',
                theme: 'classic',
                swatches: [
                    '#000000', '#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF', '#FFFFFF'
                ],
                components: {
                    preview: true,
                    opacity: false,
                    hue: false,
                    interaction: {
                        hex: false,
                        input: false,
                        clear: false,
                        save: false
                    }
                }
            });

            pickr.on('change', (color) => {
                const colorValue = color.toHEXA().toString();
                document.getElementById('profile-color').value = colorValue;
                document.getElementById('profile-color').dispatchEvent(new Event('change'));
            });

            document.addEventListener('click', (event) => {
                if (!document.getElementById('color-picker').contains(event.target)) {
                    document.getElementById('color-picker').classList.add('d-none');
                }
            });
        });
    </script>
@endsection
