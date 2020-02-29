@extends('layouts.app')

@section('content')

    <div class="container">
        <h3>{{$photo->title}}</h3>
        <p>{{$photo->description}}</p>
        <form action="{{route('photos.delete', $photo)}}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger fa fa-trash float-right"> Delete</button>
        </form>
        <a href="{{route('albums.show', $photo->album->id)}}" class="btn btn-info">Go Back</a>
        <hr>

        <img src="{{$photo->getPhoto()}}" alt="" width="900px">
        <hr>
    </div>

@endsection
