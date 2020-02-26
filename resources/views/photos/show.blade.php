@extends('layouts.app')

@section('content')

        <div class="container">
            <h3>{{$photo->title}}</h3>
            <p>{{$photo->description}}</p>
            <a href="{{route('albums.show', $photo->album->id)}}" class="btn btn-info">Go Back</a>
            <hr>

            <img src="{{$photo->getPhoto()}}" alt="">

        </div>

@endsection
