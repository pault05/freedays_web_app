@extends('components.layout')

@section('content')
    <br>
        <div class="card p-5 shadow w-100 mb-5">
            <div class="row mb-3">
                <div class="col col-md-9 col-sm-3"><b>Requests Data</b></div>
                <div class="col col-md-3 col-sm-9">
                    <div id="daterange" class="float-end">
                        <i class="bi bi-calendar"></i>
                        <span></span>
                        <i class="bi bi-caret-down"></i>
                    </div>
                </div>
            </div>
            <table class="display" id="datatable">
                <thead>
                    <tr>
                        <th style="width: 9%">Request ID</th>
                        <th>User Name</th>
                        <th>Starting Date</th>
                        <th>Ending Date</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th style="width: 100px;">Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <th style="width: 9%"></th>
                    <th>User Name</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Category</th>
                    <th style="width: 100px;">Status</th>
                    <th></th>
                </tfoot>
                <tbody>
                </tbody>
            </table>
        </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <script>
        jQuery(document).ready(function() {
            let start_date = moment().startOf('year');
            let end_date = moment().endOf('year');

            $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

            $('#daterange').daterangepicker({
               startDate: start_date,
               endDate: end_date
            }, function(start_date, end_date){
                $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
                table.draw();
            });
            var table = jQuery('#datatable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: "{{ route('admin-view.data') }}",
                    data:function(data){
                        data.from_date = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                        data.end_date = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    },
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
                    { data: 'description', name:'description'},
                    { data: 'category_name', name: 'category_name' },
                    { data: 'status', name: 'status',
                        render: function(data, type, row){
                        let color = '';
                        switch(data){
                            case 'Approved':
                                color = '#28a745';
                                break;
                            case 'Denied':
                                color = '#bd2130';
                                break;
                            case 'Pending':
                                color = '#d39e00';
                                break;
                        }
                        return `<span class="badge status-label" style="background-color: ${color};">${data}</span>`
                        }},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                "order": [[2, 'asc']],
                initComplete: function() {
                    let filteredColumns = [1, 4, 5];

                    let users = @json($users);
                    let categories = @json($categories);
                    let statuses = @json($statuses);

                    this.api().columns().every(function(index) {
                        if (filteredColumns.includes(index)) {
                            let column = this;
                            let select = document.createElement('select');
                            select.classList.add('dt-input');
                            select.add(new Option(''));

                            if (index === 1) {
                                users.sort((a, b) => {
                                    let nameOne = `${a.first_name} ${a.last_name}`.toLowerCase();
                                    let nameTwo = `${b.first_name} ${b.last_name}`.toLowerCase();
                                    if (nameOne < nameTwo) {
                                        return -1;
                                    }
                                    if (nameOne > nameTwo) {
                                        return 1;
                                    }
                                    return 0;
                                });
                                users.forEach(user => {
                                    let option = new Option(user.first_name + ' ' + user.last_name, user.id);
                                    select.add(option);
                                });
                            } else if (index === 4) {
                                categories.sort((a, b)=>{
                                    let catOne = `${a.name}`.toLowerCase();
                                    let catTwo = `${b.name}`.toLowerCase();
                                    if(catOne < catTwo){
                                        return -1;
                                    }
                                    if(catOne > catTwo){
                                        return -1;
                                    }
                                    return 0;
                                });
                                categories.forEach(category => {
                                    let option = new Option(category.name, category.id);
                                    select.add(option);
                                });
                            } else if (index === 5){
                                statuses.sort();
                                statuses.forEach(status =>{
                                    let option  = new Option(status, status);
                                    select.add(option);
                                })
                            }

                            select.addEventListener('change', function() {
                                let val = this.value;
                                if (val === '') {
                                    column.search('').draw();
                                } else {
                                    column.search(val).draw();
                                }
                            });

                            column.footer().innerHTML = '';
                            column.footer().appendChild(select);
                        }
                    });
                }
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
        });
    </script>

@endsection
