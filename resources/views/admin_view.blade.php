@extends('components.layout')

@section('content')
<div class="card p-3 shadow-sm mb-5">
    <h1>Admin View Requests</h1>
</div>
<!-- /.card -->

<div class="card p-5 shadow mb-5 w-75">
    <table class = "table">
        <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Category</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Updated At</th>
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
                <td><button type="button" class="btn btn-success">Approve</button></td>
                <td><button type="button" class="btn btn-danger">Deny</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
