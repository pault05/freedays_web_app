<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>

<div class="main-container d-flex">
    <div class="left-container d-flex flex-column flex-shrink-0 p-3 text-white bg-dark align-items-center navbar-nav-scroll" style="height: 100vh; color: #1a202c; width: 12%; background-color: #1a202c; position: sticky;">
        <ul class="nav nav-pills flex-column align-items-center justify-content-center mt-5 w-100">
            <li class="nav-item mb-3 w-100">
                <a href="/home" class="nav-link text-white text-center">Home</a>
            </li>
            <li class="nav-item mb-3 w-100">
                <a href="/user-profile" class="nav-link text-white text-center">User Profile</a>
            </li>
            <li class="nav-item mb-3 w-100">
                <a href="/free-day-request" class="nav-link text-white text-center">Free Day Request</a>
            </li>
            <li class="nav-item mb-3 w-100">
                <a href="/account-creation" class="nav-link text-white text-center">Create A New Account</a>
            </li>
            <li class="nav-item mb-3 w-100">
                <a href="/admin-view" class="nav-link text-white text-center">Admin Dashboard</a>
            </li>
            <li class="nav-item mb-3 w-100">
                <a href="/official-holiday" class="nav-link text-white text-center">Official Holiday</a>
            </li>
            <li class="nav-item mb-3 w-100">
                <a href="/login" class="nav-link text-white text-center">Login</a>
            </li>
        </ul>
    </div>
    <div class="container">
        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

