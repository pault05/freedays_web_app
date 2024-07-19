@extends('components.layout')

@section('content')
    <div class="holidays-main-container d-flex flex-column align-items-center justify-content-center p-3 h-auto card shadow-lg rounded">
        <div class="card bg-primary shadow rounded p-3 mb-3 text-light w-50 text-center">
            <h1 style="text-shadow: 2px 2px 4px black">Official Holidays</h1>
        </div>

        <form action="{{ route('official-holiday.store') }}" method="POST" class="card shadow-sm rounded mt-3 p-5 mb-5 col-12 col-md-6">
            @csrf
            <div class="mb-3">
                <label for="holiday-name" class="form-label">Holiday Name</label>
                <input id="holiday-name" name="name" type="text" class="form-control form-control-lg" placeholder="Enter Holiday Name">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start-date" class="form-label">Starting Date</label>
                    <input id="start-date" name="start-date" type="date" class="form-control form-control-lg">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="end-date" class="form-label">Ending Date</label>
                    <input id="end-date" name="end-date" type="date" class="form-control form-control-lg">
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" rows="3" class="form-control rounded"></textarea>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-primary btn-lg" type="submit">Submit</button>
            </div>
        </form>

        <div class="card p-3 shadow mt-5 col-12 col-md-6">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Holiday Name</th>
                    <th>Starting On</th>
                    <th>Ending On</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                @foreach($officialHolidays as $day)
                    <tr>
                        <td>{{$day->id}}</td>
                        <td>{{$day->name}}</td>
                        <td>{{$day->date}}</td>
                        <td>{{$day->date}}</td>
                        <td>{{$day->text}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
