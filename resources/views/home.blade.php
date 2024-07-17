@extends('Components.layout')

<title>Home Page</title>


@section('content')
    <div>
        <form action="/user-profile" method="GET">
            <input type="submit" value="User Profile" />
        </form>

        <form action="/free-day-request" method="GET">
            <input type="submit" value="Free Day Request" />
        </form>

        <form action="/account-creation" method="GET">
            <input type="submit" value="Create a New Account" />
        </form>

        <form action="/admin-view" method="get">
            <input type="submit" value="Admin Dashboard" />
        </form>

        <form action="/login" method="POST">
            <input type="submit" value="Login" />
        </form>

    </div>

@endsection
