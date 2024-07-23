@extends('components.layout')

@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Pickr CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@simonwep/pickr/dist/themes/classic.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>

<div class="profile-text">
    <h1 class="title">User Profile</h1>
</div>
<form method="POST" action="/user-profile">
    @csrf
    <div class="container">
        <div class="profile-container mx-auto">
            <div class="profile-header">
                <div>
                    <img src="{{ asset('images/default.jpg') }}" id="profile-img" class="profile-img" alt="">
                    <label for="file-input" class="custom-file-upload">
                        <i class="fas fa-upload"></i> Upload Photo
                    </label>
                    <input type="file" id="file-input" style="display: none;" onchange="previewImage(event)">
                </div>
            </div>

            <form id="profile-form">
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" class="form-control rounded-input" id="first-name" name="first_name" value="{{ $user['first_name'] }}">
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" class="form-control rounded-input" id="last-name" name="last_name" value="{{ $user['last_name'] }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control rounded-input" id="email" name="email" value="{{ $user['email'] }}">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" class="form-control rounded-input" id="phone" name="phone" value="{{ $user['phone'] }}">
                </div>
                <div class="form-group mt-4">
                    <label for="days-off">Days Off Left</label>
                    <input type="text" class="form-control rounded-input" id="days-off" value="{{ $user['days_off_left'] }}" disabled>
                </div>
                <div class="form-group">
                    <label for="hired_at">Hired At</label>
                    <input type="date" class="form-control rounded-input" id="hired_at" value="{{ $user['hired_at'] }}" disabled>
                </div>

                <!-- Color Picker -->
                <div class="form-group">
                    <label for="profile-color">Profile Color</label>
                    <div class="position-relative">
                        <div id="color-swatch" class="color-swatch" style="background-color: {{ $user['profile_color'] ?? '#ffffff' }};"></div>
                        <button type="button" id="color-picker-btn" aria-label="Pick Color">
                            <i class="fas fa-palette"></i>
                        </button>
                        <div id="color-picker"></div>
                        <input type="hidden" id="profile-color" name="profile_color" value="{{ $user['profile_color'] ?? '#ffffff' }}">
                        <!-- Hidden HEX code -->
                        <input type="hidden" id="color-hex-code" value="{{ $user['profile_color'] ?? '#ffffff' }}">
                        <!-- Label for HEX code visibility -->
                        <div id="hex-code-label" class="d-none">HEX Code: <span id="hex-code-value"></span></div>
                    </div>
                </div>

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

        <!-- Change Password Modal -->
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
                        <form id="change-password-form" method="POST" action="/user-profile">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                @error('current_password')
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
                                var password = document.getElementById("new_password");
                                var confirm_password = document.getElementById("confirm_password");

                                function validatePassword(){
                                    if(password.value !== confirm_password.value){
                                        confirm_password.setCustomValidity("Passwords Don't Match");
                                    } else {
                                        confirm_password.setCustomValidity('');
                                    }
                                }

                                password.onchange = validatePassword;
                                confirm_password.onkeyup = validatePassword;
                            </script>
                            <button type="submit" class="btn btn-primary btn-rounded">Save changes</button>
                            <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2023 Your Company. All rights reserved.</p>
            <div class="help-footer">
                <a href="#">Regulament</a>
                <a href="#">Contact Support</a>
            </div>
        </footer>
    </div>
</form>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        // Optionally, submit the form here
    }

    function cancelEditing() {
        document.querySelectorAll('#profile-form input').forEach(input => {
            input.disabled = true;
        });
        document.getElementById('profile-color').disabled = true;
        document.getElementById('edit-btn').style.display = 'block';
        document.getElementById('save-btn').style.display = 'none';
        document.getElementById('cancel-btn').style.display = 'none';
        // Optionally, reset the color picker value
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Pickr
        const pickr = Pickr.create({
            el: '#color-picker',
            theme: 'classic', // or 'monolith', or 'nano'
            swatches: [
                '#000000', '#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF', '#FFFFFF'
            ],
            components: {
                preview: true,
                opacity: false,
                hue: false,
                interaction: {
                    hex: true, // Show HEX code in color picker
                    input: false,
                    clear: false,
                    save: false
                }
            }
        });

        // Show/hide color picker
        document.getElementById('color-picker-btn').addEventListener('click', () => {
            document.getElementById('color-picker').classList.toggle('d-none');
        });

        pickr.on('change', (color) => {
            const colorValue = color.toHEXA().toString();
            document.getElementById('profile-color').value = colorValue;
            document.getElementById('color-swatch').style.backgroundColor = colorValue;
            document.getElementById('color-hex-code').value = colorValue; // Update hidden HEX code
            document.getElementById('hex-code-label').classList.remove('d-none');
            document.getElementById('hex-code-value').textContent = colorValue;
        });

        // Hide color picker when clicking outside
        document.addEventListener('click', (event) => {
            if (!document.getElementById('color-picker').contains(event.target) && !document.getElementById('color-picker-btn').contains(event.target)) {
                document.getElementById('color-picker').classList.add('d-none');
                document.getElementById('hex-code-label').classList.add('d-none'); // Hide HEX code label
            }
        });
    });

    @error('current_password')
    $('#changePasswordModal').modal('show');
    @enderror
</script>

@endsection
