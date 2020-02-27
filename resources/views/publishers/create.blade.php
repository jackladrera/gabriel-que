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
        </div><br />
        @endif
        <form action="{{ route('publishers.store') }}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group ">
                <label for="name">Publisher Name</label>
                <input type="text" id="publisher_name" name="publisher_name" class="form-control" value="" required>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="name">Address</label>
                <input type="text" id="address" name="address" class="form-control" value="" required>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="name">City</label>
                <input type="text" id="city" name="city" class="form-control" value="" required>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="name">State</label>
                <input type="text" id="state" name="state" class="form-control" value="" required>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="name">Zip</label>
                <input type="text" id="zip" name="zip" class="form-control" value="" required>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="name">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" value="" required>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="name">w9</label>
                <input type="file" id="w9" name="w9" class="form-control" value="">
                <p class="helper-block"></p>
            </div>
            <div>
                <input class="btn btn-primary" type="submit" value="Save">
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