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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>

<div class="profile-text">
    <h1 class="title">User Profile</h1>
</div>
<div class="container">
    <div class="profile-container mx-auto">
        <div class="profile-header">
            <div>
                <img src="{{ asset('images/default-profile.jpg') }}" id="profile-img" class="profile-img" alt="Profile Image">
                <label for="file-input" class="custom-file-upload">
                    <i class="fas fa-upload"></i> Upload Photo
                </label>
                <input type="file" id="file-input" style="display: none;" onchange="previewImage(event)">
            </div>
        </div>

        <form id="profile-form">
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" class="form-control rounded-input" id="first-name" value="{{ $user['first_name'] }}" disabled>
            </div>
            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" class="form-control rounded-input" id="last-name" value="{{ $user['last_name'] }}" disabled>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control rounded-input" id="email" value="{{ $user['email'] }}" disabled>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" class="form-control rounded-input" id="phone" value="{{ $user['phone'] }}" disabled>
            </div>
            <div class="form-group mt-4">
                <label for="days-off">Days Off Left</label>
                <input type="text" class="form-control rounded-input" id="days-off" value="{{ $user['days_off_left'] }}" disabled>
            </div>
            <div class="form-group">
                <label for="employed-at">Hired At</label>
                <input type="text" class="form-control rounded-input" id="employed-at" value="{{ $user['hired_at'] }}" disabled>
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
                        <button type="button" class="btn btn-save btn-rounded w-100" id="save-btn" onclick="saveChanges()" style="display: none;">Save</button>
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
                    <form id="change-password-form">
                        <div class="form-group">
                            <label for="new-password">New Password</label>
                            <input type="password" class="form-control" id="new-password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm-password" required>
                        </div>
                        <div id="password-feedback" class="alert" role="alert" style="display: none;"></div>
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

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profile-img');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function enableEditing() {
        document.querySelectorAll('#profile-form input:not(#days-off, #employed-at)').forEach(input => {
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
        // Optionally, submit the form here
    }

    function cancelEditing() {
        document.querySelectorAll('#profile-form input').forEach(input => {
            input.disabled = true;
        });
        document.getElementById('edit-btn').style.display = 'block';
        document.getElementById('save-btn').style.display = 'none';
        document.getElementById('cancel-btn').style.display = 'none';
    }

    document.getElementById('change-password-form').addEventListener('submit', function(event) {
        event.preventDefault();

        // Get the password values
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        const feedbackElement = document.getElementById('password-feedback');

        if (newPassword === confirmPassword) {
            // Simulate successful password change
            feedbackElement.className = 'alert alert-success';
            feedbackElement.textContent = 'Password changed successfully.';
            feedbackElement.style.display = 'block';

            // Perform the password change (e.g., via AJAX or form submission)
            // document.getElementById('change-password-form').submit(); // Uncomment if submitting form

            // Hide the modal after a delay for demonstration purposes
            setTimeout(() => {
                $('#changePasswordModal').modal('hide');
            }, 2000);
        } else {
            // Display error message
            feedbackElement.className = 'alert alert-danger';
            feedbackElement.textContent = 'Passwords do not match. Please try again.';
            feedbackElement.style.display = 'block';
        }
    });
</script>
</body>
</html>
@endsection
