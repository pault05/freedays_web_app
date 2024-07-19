@extends('components.layout')

@section('content')

    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow-sm mb-5 w-50 mt-3">
            <h1 class="text-center w-auto">Admin View Requests</h1>
        </div>
        <!-- /.card -->

        <div class="card p-5 shadow w-100">
            <table class = "table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Approval</th>
                    <th>Denial</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($adminView as $view)
                    <tr>
                        <td>{{ $view->id }}</td>
                        <td>{{ $view->user_id }}</td>
                        <td>{{ $view->category }}</td>
                        <td>{{ $view->status }}</td>
                        <td>{{ $view->created_at }}</td>
                        <td>{{ $view->updated_at }}</td>
                        <td>
                            <form action="{{ route('admin-view.approve', $view->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin-view.deny', $view->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Deny</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.container-main -->
@endsection
