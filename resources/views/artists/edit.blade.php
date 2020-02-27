@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <!-- <h1>Songs</h1> -->
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br /> 
        @endif
        <form action="{{ route('artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            {{csrf_field()}}
            <div class="form-group ">
                <label for="name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $artist->first_name }}" required>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $artist->last_name }}" required>
                <p class="helper-block"></p>
            </div>
            <div>
                <input class="btn btn-primary" type="submit" value="Update">
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop