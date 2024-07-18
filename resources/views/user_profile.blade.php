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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
<!-- Container for the profile card -->
<div class="container">
    <!-- Profile card container with Bootstrap padding and margin utilities -->
    <div class="profile-container mx-auto p-4">
        <!-- Centered title -->
        <h1 class="title text-center mb-4">User Profile</h1>
        <!-- Form for user profile details -->
        <form id="profile-form">
            <!-- First Name Field -->
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" class="form-control rounded-input" id="first-name" value="{{ $user['first_name'] }}" disabled>
            </div>
            <!-- Last Name Field -->
            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" class="form-control rounded-input" id="last-name" value="{{ $user['last_name'] }}" disabled>
            </div>
            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control rounded-input" id="email" value="{{ $user['email'] }}" disabled>
            </div>
            <!-- Phone Number Field -->
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" class="form-control rounded-input" id="phone" value="{{ $user['phone'] }}" disabled>
            </div>

            <!-- Password Change Card -->
            <div class="card mt-4">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <!-- Password Field -->
                    <div class="form-group position-relative">
                        <label for="password">Current Password</label>
                        <input type="password" class="form-control rounded-input" id="password" value="********" disabled>
                        <!-- Password visibility toggle icon -->
                        <i class="far fa-eye password-icon" onclick="togglePasswordVisibility('password')"></i>
                    </div>
                    <!-- New Password Field -->
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" class="form-control rounded-input" id="new-password">
                    </div>
                    <!-- Confirm New Password Field -->
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password</label>
                        <input type="password" class="form-control rounded-input" id="confirm-password">
                    </div>
                </div>
            </div>

            <!-- Days Off Left Field (Non-Editable) -->
            <div class="form-group mt-4">
                <label for="days-off">Days Off Left</label>
                <input type="text" class="form-control non-editable rounded-input" id="days-off" value="{{ $user['days_off_left'] }}" disabled>
            </div>
            <!-- Employed At Field (Non-Editable) -->
            <div class="form-group">
                <label for="employed-at">Hired At</label>
                <input type="text" class="form-control non-editable rounded-input" id="employed-at" value="{{ $user['hired_at'] }}" disabled>
            </div>
            <!-- Edit, Save, and Cancel buttons with Bootstrap styling -->
            <div class="text-center mt-4">
                <button type="button" class="btn btn-primary btn-rounded" id="edit-btn" onclick="enableEditing()">Edit</button>
                <button type="button" class="btn btn-success btn-rounded" id="save-btn" onclick="saveChanges()" style="display: none;">Save</button>
                <button type="button" class="btn btn-danger btn-rounded" id="cancel-btn" onclick="cancelEditing()" style="display: none;">Cancel</button>
            </div>
            <!-- Confirm Password Button -->
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary btn-rounded" id="confirm-password-btn" onclick="confirmPassword()">Confirm Password Change</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Font Awesome icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<!-- Custom JS -->
<script>
    // Function to enable editing of input fields
    function enableEditing() {
        document.getElementById('first-name').disabled = false;
        document.getElementById('last-name').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('phone').disabled = false;
        document.getElementById('password').disabled = false;
        document.getElementById('new-password').disabled = false;
        document.getElementById('confirm-password').disabled = false;

        document.getElementById('edit-btn').style.display = 'none';
        document.getElementById('save-btn').style.display = 'inline-block';
        document.getElementById('cancel-btn').style.display = 'inline-block';
    }

    // Function to save changes and disable input fields
    function saveChanges() {
        const firstName = document.getElementById('first-name').value;
        const lastName = document.getElementById('last-name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const newPassword = document.getElementById('new-password').value;

        // Simulating password change success with alert
        alert('Password changed successfully!');

        // You can implement saving logic here if needed

        document.getElementById('first-name').disabled = true;
        document.getElementById('last-name').disabled = true;
        document.getElementById('email').disabled = true;
        document.getElementById('phone').disabled = true;
        document.getElementById('password').disabled = true;
        document.getElementById('new-password').disabled = true;
        document.getElementById('confirm-password').disabled = true;

        document.getElementById('edit-btn').style.display = 'inline-block';
        document.getElementById('save-btn').style.display = 'none';
        document.getElementById('cancel-btn').style.display = 'none';
    }

    // Function to cancel editing and revert changes
    function cancelEditing() {
        // Reload the page or revert to original values if needed

        document.getElementById('first-name').disabled = true;
        document.getElementById('last-name').disabled = true;
        document.getElementById('email').disabled = true;
        document.getElementById('phone').disabled = true;
        document.getElementById('password').disabled = true;
        document.getElementById('new-password').disabled = true;
        document.getElementById('confirm-password').disabled = true;

        document.getElementById('edit-btn').style.display = 'inline-block';
        document.getElementById('save-btn').style.display = 'none';
        document.getElementById('cancel-btn').style.display = 'none';
    }

    // Function to toggle password visibility
    function togglePasswordVisibility(id) {
        const passwordInput = document.getElementById(id);
        const icon = document.querySelector('.password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Function to confirm password match
    function confirmPassword() {
        const currentPassword = document.getElementById('password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (newPassword !== confirmPassword) {
            alert('Passwords do not match! Please re-enter.');
            document.getElementById('new-password').value = '';
            document.getElementById('confirm-password').value = '';
            return;
        }

        // Validate if current password matches for actual implementation
        // For demo purpose, directly call saveChanges()
        saveChanges();
    }
</script>
</body>
</html>
@endsection
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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
<!-- Container for the profile card -->
<div class="container">
    <!-- Profile card container with Bootstrap padding and margin utilities -->
    <div class="profile-container mx-auto p-4">
        <!-- Centered title -->
        <h1 class="title text-center mb-4">User Profile</h1>
        <!-- Form for user profile details -->
        <form id="profile-form">
            <!-- First Name Field -->
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" class="form-control rounded-input" id="first-name" value="{{ $user['first_name'] }}" disabled>
            </div>
            <!-- Last Name Field -->
            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" class="form-control rounded-input" id="last-name" value="{{ $user['last_name'] }}" disabled>
            </div>
            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control rounded-input" id="email" value="{{ $user['email'] }}" disabled>
            </div>
            <!-- Phone Number Field -->
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" class="form-control rounded-input" id="phone" value="{{ $user['phone'] }}" disabled>
            </div>

            <!-- Password Change Card -->
            <div class="card mt-4">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <!-- Password Field -->
                    <div class="form-group position-relative">
                        <label for="password">Current Password</label>
                        <input type="password" class="form-control rounded-input" id="password" value="********" disabled>
                        <!-- Password visibility toggle icon -->
                        <i class="far fa-eye password-icon" onclick="togglePasswordVisibility('password')"></i>
                    </div>
                    <!-- New Password Field -->
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" class="form-control rounded-input" id="new-password">
                    </div>
                    <!-- Confirm New Password Field -->
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password</label>
                        <input type="password" class="form-control rounded-input" id="confirm-password">
                    </div>
                </div>
            </div>

            <!-- Days Off Left Field (Non-Editable) -->
            <div class="form-group mt-4">
                <label for="days-off">Days Off Left</label>
                <input type="text" class="form-control non-editable rounded-input" id="days-off" value="{{ $user['days_off_left'] }}" disabled>
            </div>
            <!-- Employed At Field (Non-Editable) -->
            <div class="form-group">
                <label for="employed-at">Hired At</label>
                <input type="text" class="form-control non-editable rounded-input" id="employed-at" value="{{ $user['hired_at'] }}" disabled>
            </div>
            <!-- Edit, Save, and Cancel buttons with Bootstrap styling -->
            <div class="text-center mt-4">
                <button type="button" class="btn btn-primary btn-rounded" id="edit-btn" onclick="enableEditing()">Edit</button>
                <button type="button" class="btn btn-success btn-rounded" id="save-btn" onclick="saveChanges()" style="display: none;">Save</button>
                <button type="button" class="btn btn-danger btn-rounded" id="cancel-btn" onclick="cancelEditing()" style="display: none;">Cancel</button>
            </div>
            <!-- Confirm Password Button -->
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary btn-rounded" id="confirm-password-btn" onclick="confirmPassword()">Confirm Password Change</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Font Awesome icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<!-- Custom JS -->
<script>
    // Function to enable editing of input fields
    function enableEditing() {
        document.getElementById('first-name').disabled = false;
        document.getElementById('last-name').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('phone').disabled = false;
        document.getElementById('password').disabled = false;
        document.getElementById('new-password').disabled = false;
        document.getElementById('confirm-password').disabled = false;

        document.getElementById('edit-btn').style.display = 'none';
        document.getElementById('save-btn').style.display = 'inline-block';
        document.getElementById('cancel-btn').style.display = 'inline-block';
    }

    // Function to save changes and disable input fields
    function saveChanges() {
        const firstName = document.getElementById('first-name').value;
        const lastName = document.getElementById('last-name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const newPassword = document.getElementById('new-password').value;

        // Simulating password change success with alert
        alert('Password changed successfully!');

        // You can implement saving logic here if needed

        document.getElementById('first-name').disabled = true;
        document.getElementById('last-name').disabled = true;
        document.getElementById('email').disabled = true;
        document.getElementById('phone').disabled = true;
        document.getElementById('password').disabled = true;
        document.getElementById('new-password').disabled = true;
        document.getElementById('confirm-password').disabled = true;

        document.getElementById('edit-btn').style.display = 'inline-block';
        document.getElementById('save-btn').style.display = 'none';
        document.getElementById('cancel-btn').style.display = 'none';
    }

    // Function to cancel editing and revert changes
    function cancelEditing() {
        // Reload the page or revert to original values if needed

        document.getElementById('first-name').disabled = true;
        document.getElementById('last-name').disabled = true;
        document.getElementById('email').disabled = true;
        document.getElementById('phone').disabled = true;
        document.getElementById('password').disabled = true;
        document.getElementById('new-password').disabled = true;
        document.getElementById('confirm-password').disabled = true;

        document.getElementById('edit-btn').style.display = 'inline-block';
        document.getElementById('save-btn').style.display = 'none';
        document.getElementById('cancel-btn').style.display = 'none';
    }

    // Function to toggle password visibility
    function togglePasswordVisibility(id) {
        const passwordInput = document.getElementById(id);
        const icon = document.querySelector('.password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Function to confirm password match
    function confirmPassword() {
        const currentPassword = document.getElementById('password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (newPassword !== confirmPassword) {
            alert('Passwords do not match! Please re-enter.');
            document.getElementById('new-password').value = '';
            document.getElementById('confirm-password').value = '';
            return;
        }

        // Validate if current password matches for actual implementation
        // For demo purpose, directly call saveChanges()
        saveChanges();
    }
</script>
</body>
</html>
@endsection
