@extends('Components.layout')

@section('content')

    <div class="card p-3 shadow-sm mb-5">
        <h1>Home Page</h1>
    </div>

    <div class="mb-3">
        <form action="/user-profile" method="GET">
            <input type="submit" value="User Profile"  />
        </form>
    </div>

    <div class="mb-3">
        <form action="/free-day-request" method="GET">
            <input type="submit" value="Free Day Request" />
        </form>
    </div>

    <div class="mb-3">
        <form action="/account-creation" method="GET">
            <input type="submit" value="Create a New Account" />
        </form>
    </div>

    <div class="mb-3">
        <form action="/admin-view" method="get">
            <input type="submit" value="Admin Dashboard" />
        </form>
    </div>

    <div class="mb-3">
        <form action="/login" method="POST">
            <input type="submit" value="Login" />
        </form>
    </div>


@endsection
