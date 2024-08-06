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
                <tfoot>
                    <th style="width: 9%">Request ID</th>
                    <th>User Name</th>
                    <th>Starting Date</th>
                    <th>Ending Date</th>
                    <th>Category</th>
                    <th style="width: 100px;">Status</th>
                    <th>Actions</th>
                </tfoot>
                <tbody>
                </tbody>
            </table>
        </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        jQuery(document).ready(function() { //initializare tabel datatable
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
                "order": [],
                // initComplete: function(){  //filtrare datatable
                //     let filteredColumns = [1, 4, 5];
                //     this.api().columns().every(function(index){
                //         if(filteredColumns.includes(index)) {
                //             let column = this;
                //
                //             let select = document.createElement('select');
                //             select.add(new Option(''));
                //             column.footer().replaceChildren(select);
                //
                //             select.addEventListener('change', function () {
                //                 column.search(select.value, {exact: true}).draw();
                //             });
                //
                //             column.data().unique().sort()
                //                 .each(function (d, j) {
                //                     select.add(new Option(d));
                //                 });
                //         }
                //     });
                // }
            });
        });

        $(document).on('click', '.btn-approve, .btn-deny', function(event) { //prevenire resubmit
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
