@extends('components.layout')

@section('content')
    <div class="holidays-main-container d-flex flex-column align-items-center justify-content-center p-3 h-auto rounded w-100" style="min-height: 100vh;">
        <div class="card bg-primary shadow rounded p-3 mb-3 text-light w-50 text-center">
            <h1 style="text-shadow: 2px 2px 4px black">Official Holidays</h1>
        </div>

        <form action="{{ route('official-holiday.store') }}" method="POST" class="card shadow-sm rounded mt-3 p-5 mb-5 col-12 col-md-6">
            @csrf
            <div class="mb-3">
                <label for="holiday-name" class="form-label">Holiday Name</label>
                <input id="holiday-name" name="name" type="text" class="form-control form-control-lg" placeholder="Enter Holiday Name" required>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="date" class="form-label">Holiday Date</label>
                    <input id="date" name="date" type="date" class="form-control form-control-lg" required>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-primary btn-lg" type="submit">Submit</button>
            </div>
        </form>

        <div class="card p-3 shadow mt-5 col-12 col-md-6" style="min-height: 300px">
            <table class="table table-responsive table-bordered">
                <thead>
                <div class="icons d-flex justify-content-end mb-3">
                    <form action="{{route('official-holiday.deleteAll')}}" method="POST" id="deleteAllBtn">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="border: none; background-color: white;"><img src="https://img.icons8.com/?size=100&id=63317&format=png&color=000000" style="width: 20px; filter: hue-rotate(280deg); "></button>
                    </form>
                </div>
                <tr>
                    <th>Holiday Name</th>
                    <th>Date</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($officialHolidays as $day)
                    <tr>
                        <td>{{$day->name}}</td>
                        <td>{{$day->date}}</td>
                        <td class="d-flex justify-content-center align-items-center text-center">
{{--                            <a href="#" id="editBtn"><img class="w-50" title="Edit" src="https://img.icons8.com/?size=100&id=21076&format=png&color=000000" alt=""></a>--}}
                            <form action="{{route('official-holiday.destroy', $day->id)}}" method="POST" id="destroyBtn">
                                @csrf
                                @method('DELETE')
                            <button type="submit" style="border: none; background-color: white"><img class="w-50" title="Delete" src="https://img.icons8.com/?size=100&id=nerFBdXcYDve&format=png&color=FA5252" alt=""></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('deleteAllBtn').addEventListener('submit', (e)=>{
            let confirmDelete = confirm('This action will delete all table data. Do you want to proceed?');
            if(!confirmDelete){
                e.preventDefault();
            }
        });

        //partea de edit la official holiday
        let editButton = document.querySelector('#editBtn');
        editButton.addEventListener('click', ()=>{
            alert("merge");
        });
    </script>
@endsection
