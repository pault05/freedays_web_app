@extends('components.layout')

@section('content')
    <br>
        <div class="card p-5 shadow w-100 mb-5">
            <table class="display" id="datatable">
                <thead>
                    <tr>
                        <th style="width: 9%">Request ID</th>
                        <th>User Name</th>
                        <th>Starting Date</th>
                        <th>Ending Date</th>
                        <th>Category</th>
                        <th style="width: 100px;">Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin-view.data') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user_name', name: 'user_name' },
                    { data: 'starting_date', name: 'starting_date' },
                    { data: 'ending_date', name: 'ending_date' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions'}
                ],
                "order": []
            });
        });

        $(document).on('click', '.btn-approve, .btn-deny', function(event) {
            event.preventDefault();
            var $button = $(this);
            var $form = $button.closest('form');
            var actionUrl = $form.attr('action');
            var method = $form.attr('method');
            $.ajax({
                url: actionUrl,
                type: method,
                data: $form.serialize(),
                success: function(response) {
                    $('#datatable').DataTable().ajax.reload();
                }
            });
        });
    </script>

@endsection
