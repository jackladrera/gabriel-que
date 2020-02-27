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
        <form action="{{ route('songs.update', $song->id) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            {{csrf_field()}}
            <div class="form-group ">
                <label for="name">Song Name</label>
                <input type="text" id="song_name" name="song_name" class="form-control" value="{{ $song->song_name }}" required>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="artists">Artists</label>
                <select class="js-example-basic-multiple" name="artists[]" multiple="multiple">
                    @foreach( $artists as $artist )
                    <option value="{{$artist->id}}" {{ ($artistIDs->contains('artist_id',$artist->id)) ? 'selected' : '' }}>{{$artist->first_name}} {{$artist->last_name}}</option>
                    @endforeach
                </select>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="publishers">Publishers</label>
                <select class="js-example-basic-multiple" name="publishers[]" multiple="multiple">
                    @foreach( $publishers as $publisher )
                    <option value="{{$publisher->id}}" {{ ($publisherIDs->contains('publisher_id',$publisher->id)) ? 'selected' : '' }}>{{$publisher->publisher_name}}</option>
                    @endforeach
                </select>
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

@section('plugins.Select2', true)
@section('js')
    <script>
        console.log('Hi!');
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@stop