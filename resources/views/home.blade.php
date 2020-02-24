@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- >>>>>>>>>>>>>>>> Profile info section<<<<<<<<<<<<<<<<<<< --}}
        <div class="row justify-content-center bg-white  mb-3" style="border-radius: 20%;">
            <div class="col-md-8 text-black-50 pt-3">
                <div style="display: flex;  align-items: center;">
                    <div>
                        <img src="{{$user->getProfilePic()}}"
                             style="width: 150px; height: 150px; float: left; border-radius: 50%; margin-right: 25px;">
                    </div>
                    <div>
                        {{--                        {{dd($users = DB::table('users')->select('name', 'email as user_email')->get())}}--}}
                        <div class="mb-3">
                            <label><strong>Name</strong>: </label>
                            {{$user->name}}
                        </div>

                        <div class="mb-3">
                            <label><strong>Surname</strong>: </label>
                            {{$user->surname}}
                        </div>
                        <div class="mb-3">
                            <label><strong>Email</strong>: </label>
                            {{$user->email}}
                        </div>
                        @if($user->address)
                            <div class="mb-3">
                                <label><strong>Address</strong>: </label>
                                {{$user->address}}
                            </div>
                        @endif
                        @if($user->phonenumber)
                            <div class="mb-3">
                                <label><strong>Phone Number</strong>: </label>
                                {{$user->phonenumber}}
                            </div>
                        @endif
                        @if($user->bio)
                            <div class="mb-3">
                                <label><strong>Bio</strong>: </label>
                                {!!$user->bio!!}
                            </div>
                        @endif
                        @if($user->dateofbirth)
                            <div class="mb-3">
                                <label><strong>Date of Birth</strong>: </label>
                                {{$user->dateofbirth}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- >>>>>>>>>>>>>>>> Post Wall section <<<<<<<<<<<<<<<<<<< --}}
        <div class="row justify-content-center" style="display: flex;">
            <div class="col-md-10 col-md-offset-1 ">
                <div class="card  mb-3">
                    <div class="card-header">Post Wall</div>
                    <div class="card-body col-md-10 mx-auto">

                        @foreach($user->getFeed() as $post)
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
                                    @if($post->user == Auth()->user())
                                        <div class="d-flex">
                                            <div>
                                                <a href="{{route('posts.edit', $post)}}"
                                                   class=" btn btn-sm btn-primary">Edit</a>
                                            </div>
                                            <form action="{{route('posts.destroy', $post)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-sm btn-danger ml-3 fa fa-trash-o "
                                                       value="Delete">
                                            </form>

                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div style="display: flex; justify-content: center;">
                            {{$user->getFeed()->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
