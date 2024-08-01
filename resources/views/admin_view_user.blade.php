@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('content')

    <div class="container-main flex-column justify-content-center ">

        <div class="d-flex justify-content-end card p-3 shadow w-100">
            <div>
                <form action="/account-creation">
                    <button class="btn btn-primary ms-0 mb-2 d-flex justify-content-start">Add User</button>
                </form>
            </div>
            <table class="display" id="datatable">
                <thead>
                {{--                <div class="d-flex w-100 justify-content-center mb-3">--}}
                {{--                    @if (session()->has('message'))--}}
                {{--                        <div class="alert alert-success">--}}
                {{--                            {{ session('message') }}--}}
                {{--                        </div>--}}
                {{--                    @endif--}}
                {{--                </div>--}}
                <tr>
                    {{--                    <th style="width: 15%">--}}
                    {{--                        <a href="{{ route('admin-view-user.index', ['sort_by' => 'first_name', 'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">--}}
                    {{--                            Name--}}
                    {{--                            @if($sortBy === 'first_name')--}}
                    {{--                                @if($sortOrder === 'asc')--}}
                    {{--                                    <i class="fa fa-sort-asc"></i>--}}
                    {{--                                @else--}}
                    {{--                                    <i class="fa fa-sort-desc"></i>--}}
                    {{--                                @endif--}}
                    {{--                            @endif--}}
                    {{--                        </a>--}}
                    {{--                    </th>--}}
                    <th style="width: 17%">Name</th>
                    <th style="width: 18%">Position</th>
                    <th style="width: 13%">Email</th>
                    <th style="width: 10%">Phone</th>
                    <th style="width: 6%">Role</th>
                    <th style="width: 8%">Nr. Free Days</th>
                    <th style="width: 10%">Hired Date</th>
                    <th style="width: 6%">Color</th>
                    <th style="width: 12%">Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>

                {{--                @foreach($adminViewUser as $view)--}}
                {{--                    <tr>--}}
                {{--                        <td>--}}
                {{--                            {{$view->first_name}} {{$view->last_name}}--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            {{$view->position}}--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            {{$view->email}}--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            {{$view->phone}}--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            @if($view->is_admin)--}}
                {{--                                Admin--}}
                {{--                            @else--}}
                {{--                                User--}}
                {{--                            @endif--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            {{$view->free_days}}--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            {{Carbon::parse($view['hired_at'])->format('d/m/y') }}--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            <div style="background-color:{{$view->color}}; width: 50px;height: 25px ">--}}
                {{--                            </div>--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            <div class="buttons d-flex">--}}
                {{--                                <form action="{{ route('user-profile', $view->id) }}" method="GET">--}}
                {{--                                    @csrf--}}
                {{--                                    <button class="btn-sm btnApprove" type="submit"--}}
                {{--                                            style="width: 35%; border: none; background-color: transparent;"><img--}}
                {{--                                            style="width: 100%"--}}
                {{--                                            src="https://img.icons8.com/?size=100&id=6697&format=png&color=228BE6"--}}
                {{--                                            alt="Edit"></button>--}}
                {{--                                </form>--}}

                {{--                                <button class="btn-sm btnDelete" type="button" data-user-id="{{$view->id}}"--}}
                {{--                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"--}}
                {{--                                        style="width: 35%; border: none; background-color: transparent;"><img--}}
                {{--                                        style="width: 100%"--}}
                {{--                                        src="https://img.icons8.com/?size=100&id=nerFBdXcYDve&format=png&color=FA5252"--}}
                {{--                                        alt=""></button>--}}
                {{--                                <button class="btn-sm btnChangePassword" type="button" data-user-id="{{$view->id}}"--}}
                {{--                                        data-bs-toggle="modal" data-bs-target="#changePasswordModal"--}}
                {{--                                        style="width: 35%; border: none; background-color: transparent;"><img--}}
                {{--                                        style="width: 100%"--}}
                {{--                                        src="https://img.icons8.com/?size=100&id=4fglYvlz5T4Q&format=png&color=000000"--}}
                {{--                                        alt=""></button>--}}
                {{--                            </div>--}}
                {{--                        </td>--}}

                {{--                    </tr>--}}

                {{--                @endforeach--}}
            </table>

            {{--            <div class="paginator d-flex w-100 justify-content-end">--}}
            {{--                {{$adminViewUser->links()}}--}}
            {{--            </div>--}}
            <!-- /.paginator -->
            {{--            <!-- Confirm Delete Modal -->--}}
            {{--            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"--}}
            {{--                 role="dialog"--}}
            {{--                 aria-hidden="true">--}}
            {{--                <div class="modal-dialog" role="document">--}}
            {{--                    <div class="modal-content">--}}
            {{--                        <div class="modal-header">--}}
            {{--                            <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>--}}
            {{--                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
            {{--                        </div>--}}
            {{--                        <div class="modal-body">--}}
            {{--                            <form id="DeleteUserForm"--}}
            {{--                                  method="POST">--}}
            {{--                                @csrf--}}
            {{--                                @method('DELETE')--}}
            {{--                                <input type="hidden" name="user_id_delete" id="delete_user_id" value="">--}}
            {{--                                Ești sigur că vrei să ștergi acest utilizator?--}}

            {{--                                <div class="modal-footer">--}}
            {{--                                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">--}}
            {{--                                        Cancel--}}
            {{--                                    </button>--}}
            {{--                                    <button type="submit" class="btn btn-danger btn-rounded" id="confirmDeleteButton">Delete--}}
            {{--                                    </button>--}}
            {{--                                </div>--}}
            {{--                            </form>--}}


            {{--                        </div>--}}

            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}


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

            //            function deleteFunction($id){
            //                const actionUrlDelete = '/admin-view-user/delete/' + $id;
            //                document.getElementById('DeleteUserForm').setAttribute('action', actionUrlDelete);
            //                // alert(actionUrlDelete);
            //                $('#delete_user_id').val($id);
            //                // alert($id);
            //            }

            // function changePasswordFunction($id){
            //     // alert($id);
            //     const actionUrl = '/user-profile/change-password/' + $id;
            //     document.getElementById('sendChangePasswordForm').setAttribute('action', actionUrl);
            //     $('#reset_user_id').val($id);
            // }
            //document.addEventListener('DOMContentLoaded', function () {
            //     $('.btnDelete').on('click',function(){
            //         alert(1);
            //         var userIdDelete = $(this).data('user-id');alert(userIdDelete);
            //         const actionUrlDelete = '/admin-view-user/delete/' + userIdDelete;
            //         document.getElementById('DeleteUserForm').setAttribute('action', actionUrlDelete);                    // $(this).attr('action', actionUrl);
            //         $('#delete_user_id').val(userIdDelete);
            //
            //     })
            //})

            // document.addEventListener('DOMContentLoaded', function () {
            //     $('.btnChangePassword').on('click', function () {
            //         var userId = $(this).data('user-id');
            //         const actionUrl = '/user-profile/change-password/' + userId;
            //         document.getElementById('sendChangePasswordForm').setAttribute('action', actionUrl);                    // $(this).attr('action', actionUrl);
            //         $('#reset_user_id').val(userId);
            //     });
            // });

            // const new_password = document.getElementById("new_password");
            // const confirm_password = document.getElementById("confirm_password");
            //
            // function validatePassword() {
            //     if (new_password.value !== confirm_password.value) {
            //         confirm_password.setCustomValidity("Passwords Don't Match");
            //     } else {
            //         confirm_password.setCustomValidity('');
            //     }
            // }
            //
            // new_password.onchange = validatePassword;
            // confirm_password.onkeyup = validatePassword;
            //
            // $('.change-password-btn').on('click', function () {
            //     // modal.show();
            // });
            //
            // $('#sendChangePasswordForm').on('click', function () {
            //     $('#change-password-form').submit();
            // });


        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>--}}

        <script>

            jQuery(document).ready(function() {
                jQuery('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin-view-user.data') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    },
                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'position', name: 'position' },
                        { data: 'email', name: 'email' },
                        { data: 'phone', name: 'phone' },
                        { data: 'role', name: 'role' },
                        { data: 'free_days', name: 'free_days' },
                        { data: 'hired_at', name: 'hired_at'},
                        { data: 'color', name: 'color'},
                        { data: 'actions', name: 'actions'}
                    ]
                });
            });
            $(document).on('click', '.btn-delete', function(event) {
                event.preventDefault();

                var $button = $(this);
                var actionUrl = $button.closest('form').attr('action');


                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: actionUrl,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                }).then(() => {
                                    $('#datatable').DataTable().ajax.reload();
                                });
                            },
                            error: function(response) {
                                // alert(actionUrl);
                                Swal.fire({
                                    title: "Error!",
                                    text: "There was an error deleting your file.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.btn-change-password', function(event) {
                event.preventDefault();

                var $button2 = $(this);
                console.log($button2);
                var actionUrlChangePassword = $button2.closest('form').attr('action');
                console.log("Change Password URL: ", actionUrlChangePassword);


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

                        if (!newPassword || !confirmPassword) {
                            Swal.showValidationMessage('Please enter all fields');
                            return false;
                        }

                        if (newPassword !== confirmPassword) {
                            Swal.showValidationMessage('New passwords do not match');
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
                            success: function(response) {
                                Swal.fire({
                                    title: "Succes!",
                                    text: "Password changed successfully",
                                    icon: "success"
                                }).then(() => {
                                    $('#datatable').DataTable().ajax.reload();
                                });
                            },
                            error: function(response) {
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
    @endpush
@endsection
