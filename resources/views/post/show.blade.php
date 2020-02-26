@extends('layouts.app')

@section('content')

    <div class="row justify-content-center" style="display: flex;">
        <div class="col-md-6 col-md-offset-1 ">
            <div class="card text-white bg-dark mb-3">
                <div class="card-header">{{$post->title}}</div>
                <div class="card-body">
                    {!!  $post->content !!}
                </div>
                <div class="card-footer justify-content-between" style="display: inline-flex; ">
                    <div>
                        <div>
                            Created by: {{$post->user->name}}
                        </div>
                        <div>
                            at: {{$post->created_at}}
                        </div>
                    </div>
                    @if($post->user->id == Auth()->user()->id)

                        <div class="d-flex">
                            <div class="ml-3 ">
                                <a href="{{route('posts.edit', $post)}}"
                                   class=" btn btn-sm btn-primary ">Edit</a>
                            </div>
                            <form action="{{route('posts.destroy', $post)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-sm btn-danger ml-3"
                                       value="Delete">
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
