@extends('components.layout')

@section('content')

    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow-sm mb-5 w-50 mt-3 bg-primary">
            <h1 class="text-center w-auto" style="text-shadow: 2px 2px 4px black;color: white">Admin View Requests</h1>
        </div>
        <!-- /.card -->

        <div class="card p-5 shadow w-100">
            <table class = "table table-progressive table-bordered">
                <thead>
                <form action="search_data" method="GET">
                    <div class="d-flex w-100 justify-content-center mb-3">
                        <input type="text" name="search" class="form-control w-75 me-1">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
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
                @foreach ($adminView as $view)
                    <tr>
                        <td>{{ $view->id }}</td>
                        <td>{{ $view->user->first_name }} {{ $view->user->last_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($view->starting_date)->format('d/m/y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($view->ending_date)->format('d/m/y') }}</td>
                        <td>{{($view->category->name) ?? 'Fara Categorie'}}</td>
                        @php
                            $statusColor = '';
                            if($view->status == 'Approved'){
                                $statusColor = '#28a745';
                            } elseif($view->status == 'Denied'){
                                $statusColor = '#bd2130';
                            }else{
                                $statusColor = '#d39e00';
                            }
                        @endphp
                        <td><span class="badge status-label" style="background-color: {{ $statusColor }};">{{ $view->status }} </span></td>
                        <td style="width: 15%">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Select an Action
                                </button>
                                <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <form action="{{ route('admin-view.approve', $view->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-approve" id="btnApprove" style="width: 80%;">Approve</button>
                                        </form>
                                    </li>

                                    <li><div class="dropdown-divider"></div></li>

                                    <li>
                                        <form action="{{ route('admin-view.deny', $view->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-deny" id="btnDeny" style="width: 80%">Deny</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="paginator d-flex w-100 justify-content-end">
                {{$adminView->links()}}
            </div>
            <!-- /.paginator -->
        </div>
    </div>
    <!-- /.container-main -->

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', () => {--}}
{{--            let approveBtns = document.querySelectorAll('.btn-approve');--}}
{{--            let denyBtns = document.querySelectorAll('.btn-deny');--}}

{{--            approveBtns.forEach(button => {--}}
{{--                button.addEventListener('click', () => {--}}
{{--                    let status = document.querySelector('.status-label');--}}
{{--                    status.style.color = 'green';--}}
{{--                    status.classList.remove('bg-warning');--}}
{{--                    status.classList.add('bg-success');--}}
{{--                });--}}
{{--            });--}}

{{--            denyBtns.forEach(button => {--}}
{{--                button.addEventListener('click', () => {--}}
{{--                    let status = document.querySelector('.status-label');--}}
{{--                    status.style.color = 'red';--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endsection
