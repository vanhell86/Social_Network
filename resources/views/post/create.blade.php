@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <form method="post" action="{{route('posts.store')}}">
                    @csrf
                    <div class="form-group">
                        <label for="title" class="text-dark">Title</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                               name="title" value="{{ old('title') }}"  autofocus>
                    </div>
                    <div class="form-group">
                        <label for="content" class="text-dark">Your post text</label>
                        <textarea class="form-control" id="content" name="content"> </textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
