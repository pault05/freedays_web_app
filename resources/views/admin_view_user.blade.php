@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('content')


    <div>
        <form action="/account-creation">
             <button class="btn btn-primary ms-0 mb-2 d-flex justify-content-start">Add User</button>
        </form>
    </div>

    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow w-100">
            <table class="table table-progressive table-bordered">
                <thead>
                <div class="d-flex w-100 justify-content-center mb-3">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
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
                            <div class="buttons d-flex">
                                <form action="{{ route('user-profile', $view->id) }}" method="GET">
                                    @csrf
                                    <button class="btn-sm btnApprove" type="submit"
                                            style="width: 35%; border: none; background-color: transparent;"><img
                                            style="width: 100%"
                                            src="https://img.icons8.com/?size=100&id=6697&format=png&color=228BE6"
                                            alt="Edit"></button>
                                </form>

                                <button class="btn-sm btnDelete" type="button" data-user-id="{{$view->id}}"
                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                        style="width: 35%; border: none; background-color: transparent;"><img
                                        style="width: 100%"
                                        src="https://img.icons8.com/?size=100&id=nerFBdXcYDve&format=png&color=FA5252"
                                        alt=""></button>
                                <button class="btn-sm btnChangePassword" type="button" data-user-id="{{$view->id}}"
                                        data-bs-toggle="modal" data-bs-target="#changePasswordModal"
                                        style="width: 35%; border: none; background-color: transparent;"><img
                                        style="width: 100%"
                                        src="https://img.icons8.com/?size=100&id=4fglYvlz5T4Q&format=png&color=000000"
                                        alt=""></button>
                            </div>
                        </td>

                    </tr>

                @endforeach
            </table>

            <div class="paginator d-flex w-100 justify-content-end">
                {{$adminViewUser->links()}}
            </div>
            <!-- /.paginator -->
            <!-- Confirm Delete Modal -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
                 role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="DeleteUserForm"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="user_id_delete" id="delete_user_id" value="31">
                                Ești sigur că vrei să ștergi acest utilizator?

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-danger btn-rounded" id="confirmDeleteButton">Delete
                                    </button>
                                </div>
                            </form>


                        </div>

                    </div>
                </div>
            </div>


            <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
                 aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="sendChangePasswordForm" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" id="reset_user_id" value="31">
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                           title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                           required>
                                    <div class="invalid-feedback">Please provide a strong password.</div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                           name="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                           title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                           required>
                                    <div class="invalid-feedback">The passwords do not match.</div>
                                </div>
                                <div id="password-feedback" class="alert" role="alert" style="display: none;"></div>

                                <br>
                                <button type="submit" class="btn btn-primary btn-rounded">
                                    Save changes
                                </button>
                                <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">
                                    Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $('.btnDelete').on('click',function(){
                    var userIdDelete = $(this).data('user-id');
                    const actionUrlDelete = '/admin-view-user/delete/' + userIdDelete;
                    document.getElementById('DeleteUserForm').setAttribute('action', actionUrlDelete);                    // $(this).attr('action', actionUrl);
                    $('#delete_user_id').val(userIdDelete);
                })
            })

            document.addEventListener('DOMContentLoaded', function () {
                $('.btnChangePassword').on('click', function () {
                    var userId = $(this).data('user-id');
                    const actionUrl = '/user-profile/change-password/' + userId;
                    document.getElementById('sendChangePasswordForm').setAttribute('action', actionUrl);                    // $(this).attr('action', actionUrl);
                    $('#reset_user_id').val(userId);
                });
            });

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

            $('.change-password-btn').on('click', function () {
                // modal.show();
            });

            $('#sendChangePasswordForm').on('click', function () {
                $('#change-password-form').submit();
            });


        </script>
    @endpush
@endsection
