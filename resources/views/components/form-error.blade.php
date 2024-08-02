@props(['name'])
@error($name)
    <p class="small text-danger font-weight-bold mt-1">{{$message}}</p>
@enderror
