@extends('components.layout')

@section('content')
    <style>
        @media (max-width: 767.98px) {
            .holidays-main-container .row .col-md-6 {
                margin-bottom: 2rem;
            }
        }
    </style>

    <br>
    <div
            class=" card holidays-main-container d-flex flex-column align-items-center justify-content-center p-5 h-auto rounded w-100">
        <div class="row w-100">
            <div class="col-lg-9 col-md-6 col-sm-12 mt-ms-2">
                <div class="card p-3 shadow h-100">
                    <table class="display" id="datatable">
                        <thead>
                        <tr>
                            <th>Holiday Name</th>
                            <th>Date</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-ms-2">
                <form action="{{ route('official-holiday.store') }}" method="POST"
                      class="card shadow-sm rounded p-5 h-100">
                    @csrf
                    <div class="mb-3">
                        <label for="holiday-name" class="form-label">Holiday Name</label>
                        <input id="holiday-name" name="name" type="text" class="form-control form-control-lg"
                               placeholder="Enter Holiday Name" required>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="date" class="form-label">Holiday Date</label>
                            <input id="date" name="date" type="date" class="form-control form-control-lg" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('official-holiday.data')}}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'date', name: 'date'},
                    {data: 'actions', name: 'actions'}
                ]
            });
        });

        $(document).on('click', '.btn-delete', function (event) {
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
                        success: function (response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            }).then(() => {
                                $('#datatable').DataTable().ajax.reload();
                            });
                        },
                        error: function (response) {
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
    </script>
@endsection
