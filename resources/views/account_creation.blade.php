@extends('components.layout')

@section('content')
<br>
    <!-- /.card -->

    <div class="card p-5 shadow w-100">

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




                                <div class="col-md-5">
                                    <label for="free_days" class="form-label text-start w-100">Free days*</label>
                                    <input type="number" class="form-control " id="free_days" name="free_days" required min="0" step="1">
                                    <div class="invalid-feedback">
                                        Please enter the number of free days.
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <label for="hired_at" class="form-label text-start w-100">Hired date</label>
                                    <input type="date" class="form-control " id="hired_at" name="hired_at">
                                    <div class="invalid-feedback">
                                        Please enter the date of hired.
                                    </div>
                                </div>

                                <div class="col-2">
                                    <input type="hidden" id="role_text" name="role_text" value="{{ auth()->user()->is_admin ? 'Admin' : 'User' }}">
                                    <label for="role" class="form-label text-start">Role</label>
                                    <div class="dropdown ms-1">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="role" name="role" data-bs-toggle="dropdown" aria-expanded="false">Admin
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                            <li><a class="dropdown-item" href="#" onclick="setRole('Admin')">Admin</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="setRole('User')">User</a></li>
                                        </ul>
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


                            <button class="w-100 btn btn-primary btn-lg" id="createButton" type="submit">Create User Profile</button>
                        </form>
                    </div>
                </div>
        </div>

        <script>
            function setRole(role) {
                document.getElementById('role').textContent = role;
                document.getElementById('role_text').value = role;
            }

            document.getElementById('createButton').onclick = function (){
                var roleText = document.getElementById('role').textContent.trim();
                document.getElementById('role_text').value = roleText;
            }
        </script>
        <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="checkout.js"></script></dic>
    </div>
@endsection

