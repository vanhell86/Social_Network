@extends('layouts.app')

@section('content')
    <section class="jumbotron text-center">
        <div class="container">
            <h1>{{$album->title}}</h1>
            <p class="lead text-muted">{{$album->description}}</p>
            <p>
                <a href="{{route('photos.create', $album)}}" class="btn btn-primary my-2">Upload photo</a>
                <a href="{{route('albums.index')}}" class="btn btn-secondary my-2">Go back</a>
            </p>
        </div>
    </section>
    @if(count($album->photos) > 0)
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                @foreach($album->photos as $photo)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="{{$photo->getPhoto()}}" alt="Album cover" style="height: 200px">
                            <div class="card-body">
                                <p class="card-text">{{$photo->description}}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="{{route('photos.show', $photo)}}"
                                           class="btn btn-sm btn-outline-secondary">View</a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        @if($photo->liked())
                                            <div>
                                                <form action="{{route('photo.unlike', $photo)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link fa fa-thumbs-down">
                                                        UnLike
                                                    </button>
                                                </form>

                                            </div>
                                        @else
                                            <div>
                                                <form action="{{route('photo.like', $photo)}}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link fa fa-thumbs-up">
                                                        Like
                                                    </button>
                                                </form>

                                            </div>
                                        @endif
                                        @if($photo->countLikes() > 0)
                                            <span>
                                            {{ $photo->countLikes() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <h3>No photos yet!</h3>
    @endif

@endsection
