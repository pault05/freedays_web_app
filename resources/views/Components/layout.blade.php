<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME')}}</title>
    <link href="{{asset("public/css/bootstrap.css")}}">

</head>
<body>

<header>
    <div class="col-12">
        <x-nav-bar>

        </x-nav-bar>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-4">
            <x-dashboard1>

            </x-dashboard1>
        </div>
        <div class="col-12 col-sm-12 col-md-12  col-lg-8">
            @yield('content')
        </div>
    </div>
</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://getbootstrap.com/docs/5.2/examples/sidebars/sidebars.js"></script>

</body>
</html>

