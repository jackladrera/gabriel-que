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
        <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            {{csrf_field()}}
            <div class="form-group ">
                <label for="name">Project Name</label>
                <input type="text" id="project_name" name="project_name" class="form-control" value="{{ $project->project_name }}" required>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="shows">Shows</label>
                <select id="shows" class="form-control" name="shows">
                    @foreach( $shows as $show )
                    <option value="{{$show->id}}" {{ ($project->show_id == $show->id) ? 'selected' : '' }}>{{$show->show_name}}</option>
                    @endforeach
                </select>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="songs">Songs</label>
                <select class="js-example-basic-multiple" name="songs[]" multiple="multiple">
                    @foreach( $songs as $song )
                    <option value="{{$song->id}}" {{ ($songIDs->contains('song_id',$song->id)) ? 'selected' : '' }}>{{$song->song_name}}</option>
                    @endforeach
                </select>
                <p class="helper-block"></p>
            </div>
            <div class="form-group ">
                <label for="name">Air Date</label>
                <input type="text" id="air_date" name="air_date" class="form-control datepicker" value="{{ $project->air_date }}" required readonly>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css">
@stop

@section('plugins.Select2', true)
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        console.log('Hi!');
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        $(".datepicker").datepicker();
    </script>
@stop