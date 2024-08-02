@extends('components.layout')

@section('content')

    <br>
    <div class="fixed-button-container">
        <a id="fixedButton" class="btn btn-primary" href="/account-creation" ><img src="https://img.icons8.com/?size=100&id=3&format=png&color=1A1A1A" alt=""></a>
    </div>
    <style>
        #fixedButton img{
            width: 40px;
            height: 40px;
        }
        .fixed-button-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000; /* Asigură-te că butonul va fi deasupra altor elemente */
        }
        #fixedButton {
            padding: 10px 10px;
            font-size: 16px;
        }
    </style>
    <div class="card p-5 shadow w-100 mb-5">
        <table class="display" id="datatable">
            <thead>
            <tr>
                                    <th style="width: 15%">Name</th>
                                    <th style="width: 18%">Position</th>
                                    <th style="width: 15%">Email</th>
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
        </table>
    </div>
{{--        @push('scripts')--}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            {
                                data: 'color',
                                name: 'color',
                                render: function(data, type, row) {
                                    // Ensure that 'data' is a valid color code or name
                                    return '<div style="width: 50px; height: 20px; background-color: ' + data + ';"></div>';
                                }
                            },
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
                                        text: "User has been deleted.",
                                        icon: "success"
                                    }).then(() => {
                                        $('#datatable').DataTable().ajax.reload();
                                    });
                                },
                                error: function(response) {
                                    // alert(actionUrl);
                                    Swal.fire({
                                        title: "Error!",
                                        text: "There was an error deleting user.",
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
                            console.log("New Password Data: ", result.value.newPassword);
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
{{--        @endpush--}}
    @endsection
