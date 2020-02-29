@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 pt-3 d-flex justify-content-center">
                    <div style="font-size: 3em; display: block">Gallery</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(count($albums) > 0)
            <div class="row">
                @foreach($albums as $album)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="{{$album->getAlbumCover()}}" alt="Album cover" style="height: 200px">

                            <div class="card-body">
                                <p class="card-text">{{$album->description}}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="{{route('albums.show', $album)}}"
                                           class="btn btn-sm btn-outline-secondary mr-2">View</a>
                                        <form action="{{route('albums.delete', $album)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger fa fa-trash float-right"> Delete
                                            </button>
                                        </form>
                                    </div>
                                    <small class="text-muted">{{$album->name}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h3>No albums yet! Create some!</h3>
            <a href="{{route('albums.create')}}">Create new album</a>
        @endif
    </div>



    {{--    <div class="container">--}}
    {{--        <div class="row justify-content-center">--}}
    {{--            <div class="col-md-8">--}}
    {{--                @if (session('success'))--}}
    {{--                    <div class="alert alert-success">--}}
    {{--                        {{ session('success') }}--}}
    {{--                    </div>--}}
    {{--                @endif--}}


    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection
