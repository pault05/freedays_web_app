@extends('components.layout')

@section('content')

    <br>

    <div class="container-fluid">
        <div class="card p-3">
            <table class="display" id="datatable">
                <thead>
                    <th>Starting Date</th>
                    <th>Ending Date</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
{{--                actions sa-si vizualizeze cererea--}}
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Category</th>
                    <th>Status</th>
                    <th></th>
                </tfoot>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>

    <script>
        $(document).ready(function(){
            let table = $('#datatable').DataTable({
               processing: true,
               serverSide: true,
               ajax:{url: "{{route('user-view.data')}}",
                   type: 'POST',
                   headers:{
                       'X-CSRF-TOKEN': '{{csrf_token()}}'
                   }
               },
                columns:[
                    {data: 'starting_date', name: 'starting_date'},
                    {data: 'ending_date', name: 'ending_date'},
                    {data: 'description', name: 'description'},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'status', name: 'status',
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
                        }
                    },
                    {data: 'actions', name: 'actions', orderable:false}
                ],
                "order":[[0, 'asc']],
                initComplete: function(){
                   let filteredColumns = [3, 4];
                   let categories = @json($categories);
                   let statuses = @json($statuses);

                   this.api().columns().every(function (index){
                       if(filteredColumns.includes(index)){
                           let column = this;
                           let select = document.createElement('select');
                           select.classList.add('dt-input');
                           select.add(new Option(''));

                           if(index === 3){
                               categories.sort((a, b)=>{
                                   let catOne = `${a.name}`.toLowerCase();
                                   let catTwo = `${b.name}`.toLowerCase();

                                   if(catOne < catTwo){
                                       return -1;
                                   }else if(catOne > catTwo){
                                       return 1;
                                   }
                                   return 0;
                               });
                               categories.forEach(category=>{
                                   let option = new Option(category.name, category.id);
                                   select.add(option);
                               });
                           } else if(index === 4){
                               statuses.sort();
                               statuses.forEach(status =>{
                                   let option = new Option(status, status);
                                   select.add(option);
                               });
                           }

                           select.addEventListener('change', function(){
                               let val = this.value;
                               if(val === ''){
                                   column.search('').draw();
                               }else{
                                   column.search(val).draw();
                               }
                           });

                           column.footer().innerHTML = '';
                           column.footer().appendChild(select);
                       }
                   });
                }
            });
        });
    </script>



@endsection
