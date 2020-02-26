@extends('layouts.app')

@section('content')

    <div class="container">
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
                                        <a href="{{route('albums.show', $album)}}" class="btn btn-sm btn-outline-secondary">View</a>
{{--                                        <a href="" class="btn btn-sm btn-outline-secondary">Edit</a>--}}
                                    </div>
                                    <small class="text-muted">{{$album->name}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h3>No albums yet!</h3>
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
