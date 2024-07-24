@extends('components.layout')

@section('content')

    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow-sm mb-5 w-50 mt-3 bg-primary">
            <h1 class="text-center w-auto" style="text-shadow: 2px 2px 4px black;color: white">Admin View Requests</h1>
        </div>
        <!-- /.card -->

        <div class="card p-3 shadow w-100">
            <table class = "table table-progressive table-bordered">
                <thead>
                    <div class="d-flex w-100 justify-content-center mb-3">
                        <form action="{{route('admin-view.search')}}" method="GET">
                            @csrf
                            <input type="text" name="search" class="form-control w-50 me-1">
                            <button type="submit" class="btn btn-secondary">Search</button>
                        </form>
                        <div class="dropdown ms-1">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Order By
                            </button>
                            <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a href="{{ route('admin-view.index', ['sort_field' => 'id', 'sort_order' => request('sort_order', 'asc')]) }}" class="btn btn-dark w-75">
                                        ID
                                    </a>
                                </li>

                                <li><div class="dropdown-divider"></div></li>
                                {{-- divider--}}
                                <li>
                                    <a href="{{ route('admin-view.index', ['sort_field' => 'users.first_name', 'sort_order' => request('sort_order', 'asc')]) }}" class="btn btn-dark w-75">
                                        Name
                                    </a>
                                </li>
                                <li><div class="dropdown-divider"></div></li>
                                <li>
                                    <a href="{{ route('admin-view.index', ['sort_field' => 'status', 'sort_order' => request('sort_order', 'asc')]) }}" class="btn btn-dark w-75">
                                        Status
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown ms-1">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Filter By
                            </button>
                            <div class="dropdown-menu" aria-labelledby="filterDropdown">
                                <div class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">Filter by Status</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{route('admin-view.filter', ['filter_by_status' => 'Pending'])}}">Pending</a></li>
                                        <li><a class="dropdown-item" href="{{route('admin-view.filter', ['filter_by_status' => 'Approved'])}}">Approved</a></li>
                                        <li><a class="dropdown-item" href="{{route('admin-view.filter', ['filter_by_status' => 'Denied'])}}">Denied</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">Filter by User</a>
                                    <ul class="dropdown-menu" style="height: 120px; overflow: hidden">
                                        <li>
                                            <input type="text" id="userSearch" class="form-control" placeholder="Search Users">
                                        </li>
                                        @foreach($users as $user)
                                            <li class="user-item ms-1 mb-1" data-user-id="{{ $user->id }}">
                                                <a class="dropdown-item" href="{{ route('admin-view.filter', ['filter_by_user' => $user->id]) }}">
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script>
        $(document).ready(function(){
            $('.dropdown-submenu a.dropdown-toggle').on("click", function(e){
                var $el = $(this).next('ul');
                var $parent = $(this).offsetParent(".dropdown-menu");
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                $el.toggleClass('show');

                $(this).parent("li").toggleClass('show');

                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });

                if (!$parent.parent().hasClass('navbar-nav')) {
                    $el.css({"top": $(this)[0].offsetTop, "left": $parent.outerWidth() - 4});
                }

                return false;
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const userSearchInput = document.getElementById('userSearch');
            const userItems = document.querySelectorAll('.user-item');

            userSearchInput.addEventListener('input', function () {
                const searchValue = userSearchInput.value.toLowerCase();

                userItems.forEach(item => {
                    const userName = item.textContent.toLowerCase();
                    if (userName.includes(searchValue)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
