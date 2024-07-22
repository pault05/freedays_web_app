@extends('components.layout')

@section('content')

    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow-sm mb-5 w-50 mt-3">
            <h1 class="text-center w-auto">Admin View Requests</h1>
        </div>
        <!-- /.card -->

        <div class="card p-5 shadow w-100">
            <table class = "table table-progressive table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th style="width: 100px;">Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($adminView as $view)
                    <tr>
                        <td>{{ $view->id }}</td>
                        <td>{{ $view->user_id }}</td>
                        <td><span class="bg-warning badge status-label">{{ $view->status }} </span></td>
                        <td>{{ \Carbon\Carbon::parse($view->created_at)->format('d/m/y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($view->updated_at)->format('d/m/y') }}</td>
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

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.container-main -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let approveBtns = document.querySelectorAll('.btn-approve');
            let denyBtns = document.querySelectorAll('.btn-deny');

            approveBtns.forEach(button => {
                button.addEventListener('click', () => {
                    let status = document.querySelector('.status-label');
                    status.style.color = 'green';
                    status.classList.remove('bg-warning');
                    status.classList.add('bg-success');
                });
            });

            denyBtns.forEach(button => {
                button.addEventListener('click', () => {
                    let status = document.querySelector('.status-label');
                    status.style.color = 'red';
                });
            });
        });
    </script>
@endsection
