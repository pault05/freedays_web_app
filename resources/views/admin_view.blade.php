@extends('components.layout')

@section('content')

    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow-sm mb-5 w-50 mt-3 bg-primary">
            <h1 class="text-center w-auto" style="text-shadow: 2px 2px 4px black;color: white">Admin View Requests</h1>
        </div>
        <!-- /.card -->

        <div class="card p-3 shadow w-100">
            <table class="display" id="datatable">
                <thead>
{{--                <div class="d-flex w-100 justify-content-center mb-3">--}}
{{--                    <form action="{{ route('admin-view.search') }}" method="GET">--}}
{{--                        @csrf--}}
{{--                        <input type="text" name="search" class="form-control w-50 me-1">--}}
{{--                        <button type="submit" class="btn btn-secondary">Search</button>--}}
{{--                    </form>--}}
{{--                    <div class="dropdown ms-1">--}}
{{--                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                            Order By--}}
{{--                        </button>--}}
{{--                        <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">--}}
{{--                            <li>--}}
{{--                                <a href="{{ route('admin-view.index', ['sort_field' => 'id', 'sort_order' => request('sort_order', 'asc') == 'asc' ? 'desc' : 'asc']) }}" class="dropdown-item">--}}
{{--                                    ID--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li><div class="dropdown-divider"></div></li>--}}
{{--                            <li>--}}
{{--                                <a href="{{ route('admin-view.index', ['sort_field' => 'category_id', 'sort_order' => request('sort_order', 'asc') == 'asc' ? 'desc' : 'asc']) }}" class="dropdown-item">--}}
{{--                                    Category--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li><div class="dropdown-divider"></div></li>--}}
{{--                            <li>--}}
{{--                                <a href="{{ route('admin-view.index', ['sort_field' => 'status', 'sort_order' => request('sort_order', 'asc') == 'asc' ? 'desc' : 'asc']) }}" class="dropdown-item">--}}
{{--                                    Status--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                    <div class="dropdown ms-1">--}}
{{--                        <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                            Filter--}}
{{--                        </button>--}}
{{--                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">--}}
{{--                            <li class="dropdown-submenu">--}}
{{--                                <a class="dropdown-item dropdown-toggle" data-bs-auto-close="inside" href="#">Filter by Status</a>--}}
{{--                                <ul class="dropdown-menu">--}}
{{--                                    <li><a class="dropdown-item" href="{{ route('admin-view.index', ['filter_by_status' => 'Pending']) }}">Pending</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="{{ route('admin-view.index', ['filter_by_status' => 'Approved']) }}">Approved</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="{{ route('admin-view.index', ['filter_by_status' => 'Denied']) }}">Denied</a></li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                            <li class="dropdown-submenu">--}}
{{--                                <a class="dropdown-item dropdown-toggle" href="#">Filter by User</a>--}}
{{--                                <ul class="dropdown-menu" style="height: 120px; overflow: hidden">--}}
{{--                                    <li>--}}
{{--                                        <input type="text" id="userSearch" class="form-control" placeholder="Search Users">--}}
{{--                                    </li>--}}
{{--                                    @foreach($users as $user)--}}
{{--                                        <li class="user-item ms-1 mb-1" data-user-id="{{ $user->id }}">--}}
{{--                                            <a class="dropdown-item" href="{{ route('admin-view.index', ['filter_by_user' => $user->id]) }}">--}}
{{--                                                {{ $user->first_name }} {{ $user->last_name }}--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
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
{{--                @foreach ($adminView as $view)--}}
{{--                    <tr style="vertical-align: middle">--}}
{{--                        <td>{{ $view->id }}</td>--}}
{{--                        <td>{{ $view->user->first_name }} {{ $view->user->last_name }}</td>--}}
{{--                        <td>{{ \Carbon\Carbon::parse($view->starting_date)->format('d/m/y') }}</td>--}}
{{--                        <td>{{ \Carbon\Carbon::parse($view->ending_date)->format('d/m/y') }}</td>--}}
{{--                        <td>{{ ($view->category->name) ?? 'Fara Categorie' }}</td>--}}
{{--                        @php--}}
{{--                            $statusColor = '';--}}
{{--                            if ($view->status == 'Approved') {--}}
{{--                                $statusColor = '#28a745';--}}
{{--                            } elseif ($view->status == 'Denied') {--}}
{{--                                $statusColor = '#bd2130';--}}
{{--                            } else {--}}
{{--                                $statusColor = '#d39e00';--}}
{{--                            }--}}
{{--                        @endphp--}}
{{--                        <td><span class="badge status-label" style="background-color: {{ $statusColor }};">{{ $view->status }}</span></td>--}}
{{--                        <td style="width: 9%">--}}
{{--                            <div class="dropdown d-flex justify-content-center">--}}
{{--                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                    Select an Action--}}
{{--                                </button>--}}
{{--                                <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">--}}
{{--                                    <li>--}}
{{--                                        <form action="{{ route('admin-view.approve', $view->id) }}" method="POST">--}}
{{--                                            @csrf--}}
{{--                                            <button type="submit" class="btn btn-approve btn-sm" id="btnApprove" style="border: none; background-color: transparent">--}}
{{--                                                <img src="https://img.icons8.com/?size=100&id=g7mUWNettfwZ&format=png&color=40C057" alt="" style="width: 35px" class="action-icons"></button>--}}
{{--                                        </form>--}}
{{--                                    </li>--}}

{{--                                    <li><div class="dropdown-divider"></div></li>--}}

{{--                                    <li>--}}
{{--                                        <form action="{{ route('admin-view.deny', $view->id) }}" method="POST">--}}
{{--                                            @csrf--}}
{{--                                            <button type="submit" class="btn btn-deny btn-sm" id="btnDeny" style="border: none; background-color: transparent">--}}
{{--                                                <img src="https://img.icons8.com/?size=100&id=63688&format=png&color=000000" alt="" style="width: 30px; border: none; background-color: transparent" class="action-icons"></button>--}}
{{--                                        </form>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                                <style>--}}
{{--                                    .action-icons:hover {--}}
{{--                                        transform: scale(1.1);--}}
{{--                                    }--}}
{{--                                </style>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
                </tbody>
            </table>
{{--            <div class="paginator d-flex w-100 justify-content-end">--}}
{{--                {{$adminView->links()}}--}}
{{--            </div>--}}
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin-view.data') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user_name', name: 'user_name' },
                    { data: 'starting_date', name: 'starting_date' },
                    { data: 'ending_date', name: 'ending_date' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions' }
                ]
            });
        });
    </script>

@endsection
