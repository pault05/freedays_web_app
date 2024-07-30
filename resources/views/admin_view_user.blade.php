@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('content')

    <div class="card p-3 shadow-sm mb-5 w-50 mt-3 bg-primary"
         style="margin: 0 auto; display: flex; justify-content: center; align-items: center; flex-direction: column; text-align: center;">
        <h1 class="text-center w-auto" style="text-shadow: 2px 2px 4px black; color: white;">Admin View Users</h1>
    </div>

    <div>
        <form action="/account-creation">
             <button class="btn btn-primary ms-0 mb-2 d-flex justify-content-start">Add User</button>
        </form>
    </div>

    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow w-100">
            <table class = "table table-progressive table-bordered">
                <thead>
                <div class="d-flex w-100 justify-content-center mb-3">
                </div>
                <tr>
                    <th style="width: 15%">
                        <a href="{{ route('admin-view-user.index', ['sort_by' => 'first_name', 'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
                            Name
                            @if($sortBy === 'first_name')
                                @if($sortOrder === 'asc')
                                    <i class="fa fa-sort-asc"></i>
                                @else
                                    <i class="fa fa-sort-desc"></i>
                                @endif
                            @endif
                        </a>
                    </th>

                    <th style="width: 17%">Position</th>
                    <th style="width: 13%">Email</th>
                    <th style="width: 10%">Phone</th>
                    <th style="width: 5%">Role</th>
                    <th style="width: 8%">Nr. Free Days</th>
                    <th style="width: 7%">Hired Date</th>
                    <th style="width: 5%">Color</th>
                    <th style="width: 15%">Actions</th>
                </tr>
                </thead>

                @foreach($adminViewUser as $view)
                    <tr>
                        <td>
                            {{$view->first_name}} {{$view->last_name}}
                        </td>
                        <td>
                            {{$view->position}}
                        </td>
                        <td>
                            {{$view->email}}
                        </td>
                        <td>
                            {{$view->phone}}
                        </td>
                        <td>
                            @if($view->is_admin)
                                Admin
                            @else
                                User
                            @endif
                        </td>
                        <td>
                            {{$view->free_days}}
                        </td>
                        <td>
                            {{Carbon::parse($view['hired_at'])->format('d/m/y') }}
                        </td>
                        <td>
                            <div style="background-color:{{$view->color}}; width: 50px;height: 25px ">
                            </div>
                        </td>
                        <td>
                            <div class="buttons d-flex" >
                                <form action="{{ route('user-profile', $view->id) }}" method="GET">
                                    @csrf
                                    <button class="btn-sm" type="submit" id="btnApprove" style="width: 35%; border: none; background-color: transparent;"><img style="width: 100%" src="https://img.icons8.com/?size=100&id=6697&format=png&color=228BE6" alt="Edit"></button>
                                </form>

                                <form action="{{ route('admin-view-user.delete', $view->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-sm" type="submit" id="btnDeny" style="width: 35%; border: none; background-color: transparent;"><img style="width: 100%" src="https://img.icons8.com/?size=100&id=nerFBdXcYDve&format=png&color=FA5252" alt=""></button>
                       </form>

{{--                                <form action="{{ route('user-profile.change-password', $view->id) }}" method="POST">--}}
{{--                                    @csrf--}}
                                    <button class="btn-sm" type="button" id="btnChangePassword" data-user-id="{{$view->id}}" style="width: 35%; border: none; background-color: transparent;"><img style="width: 100%" src="https://img.icons8.com/?size=100&id=4fglYvlz5T4Q&format=png&color=000000" alt="" data-toggle="modal" data-target="#changePasswordModal"></button>
{{--                                </form>--}}
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        var changePasswordModal = document.getElementById('changePasswordModal');
                                        changePasswordModal.addEventListener('show.bs.modal', function (event) {
                                            var button = event.relatedTarget; // Button that triggered the modal
                                            var userId = button.getAttribute('data-user-id'); // Extract info from data-* attributes

                                            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                                            // Update the modal's content.
                                            var modalUserIdInput = changePasswordModal.querySelector('#user_id');
                                            modalUserIdInput.value = userId;
                                        });
                                    });
                                </script>
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
                                                <form id="change-password-form" method="POST" action="{{ route('user-profile.change-password',$view->id) }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="current_password">Current Password</label>
                                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                                        @error('current_password')
                                                        <div class="text-danger">{{ $message }}</div>
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
                                                        const new_password = document.getElementById("new_password");
                                                        const confirm_password = document.getElementById("confirm_password");

                                                        function validatePassword() {
                                                            if (new_password.value !== confirm_password.value) {
                                                                confirm_password.setCustomValidity("Passwords Don't Match");
                                                            } else {
                                                                confirm_password.setCustomValidity('');
                                                            }
                                                        }

                                                        new_password.onchange = validatePassword;
                                                        confirm_password.onkeyup = validatePassword;
                                                    </script>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary btn-rounded">Save changes</button>
                                                    <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <script>

                                    const modal = document.getElementById("changePasswordModal");
                                    const btn = document.getElementById("change-password-btn");

                                    btn.onclick = function () {
                                        modal.style.display = "block";
                                    }
                                </script>
                                             <script>
                                    $(document).ready(function() {
                                        @if ($errors->any())
                                        $('#changePasswordModal').modal('show');
                                        @endif
                                    });
                                </script>

                            </div>
                        </td>

                    </tr>


                @endforeach
            </table>


            <div class="paginator d-flex w-100 justify-content-end" >
                {{$adminViewUser->links()}}
            </div>
            <!-- /.paginator -->


        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Pickr JS -->
        <script src="https://unpkg.com/@simonwep/pickr/dist/pickr.min.js"></script>
        <!-- Custom JS -->

    </div>
@endsection
