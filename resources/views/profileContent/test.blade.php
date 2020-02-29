@extends('layouts.app')

@section('content')
    {{--    @include('profileContent.index');--}}
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">--}}
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="text-center card-box">
                    <div class="member-card">
                        <div class="thumb-xl member-thumb m-b-10 align-items-center">
                            <div class="d-flex justify-content-center">
                                <img src="{{$user->getProfilePic()}}" alt="profile-image" style="width: 150px;
                            height: 150px; float: left; border-radius: 50%; margin-right: 25px;">
                            </div>

                        </div>

                        <div class="">
                            <h4 class="m-b-5"> {{$user->name . " "  . $user->surname}}</h4>
                            {{--                        <p class="text-muted">@johndoe</p>--}}
                        </div>

                        @if(Auth()->user()->areFriends($user))
                            <form action="{{route('end.friendship', $user)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="pull-right btn btn-sm btn-primary">
                                    {{ __('Unfriend') }}
                                </button>
                            </form>
                        @elseif(Auth()->user()->hasReceivedFriendRequest($user))
                            <form action="{{route('accept.friendship', $user)}}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="pull-right btn btn-sm btn-primary">
                                    {{ __('Accept friendship') }}
                                </button>
                            </form>
                        @else
                            <form action="{{route('send.friend.request', $user)}}" method="post">
                                @csrf
                                <button type="submit" class="pull-right btn btn-sm btn-primary">
                                    @if( ! Auth()->user()->hasSentFriendRequest($user))
                                        {{ __('Send friend request') }}
                                    @else
                                        {{ __('Cancel friend request') }}
                                    @endif
                                </button>
                            </form>
                        @endif
                        <button type="button" class="btn btn-danger btn-sm w-sm waves-effect m-t-10 waves-light">
                            Message
                        </button>

                        <div class="text-left m-t-40">
                            @if($user->phonenumber)
                                <p class="text-muted font-13"><strong>Mobile :</strong><span
                                        class="m-l-15">  {{$user->phonenumber}}</span></p>
                            @endif
                            @if($user->email)
                                <p class="text-muted font-13"><strong>Email :</strong> <span
                                        class="m-l-15">{{$user->email}}</span></p>
                            @endif
                            @if($user->address)
                                <p class="text-muted font-13"><strong>Address :</strong> <span
                                        class="m-l-15">{{$user->address}}</span></p>
                            @endif
                            @if($user->bio)
                                <p class="text-muted font-13"><strong>Bio :</strong> <span
                                        class="m-l-15">{!!$user->bio!!}</span></p>
                            @endif
                        </div>

                    </div>
                </div> <!-- end card-box -->

                <div class="card-box">
                    <h4 class="m-t-0 m-b-20 header-title">Gallery</h4>
                    @if(count($user->albums) <= 0)
                        <span>User have no albums yet</span><br>
                        <a href="{{route('albums.create')}}">Create new album</a>
                    @else
                        <div class="card mb-4 shadow-sm">
                            <img src="{{$user->albums->first()->getAlbumCover()}}" alt="Album cover"
                                 style="height: 200px">

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="{{route('albums.index')}}" class="btn btn-sm btn-outline-secondary">Open
                                            gallery</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div> <!-- end col -->

            <div class="col-md-8 col-lg-9">

                {{-- >>>>>>>>>>>>>>>> Friends section <<<<<<<<<<<<<<<<<<< --}}
                <div class="row justify-content-center">
                    <div class="col-md-10 text-black-50 pt-3">
                        <div class="card mb-3">
                            <div class="card-header">Friends</div>
                            <div class="card-body col-md-10 d-flex">
                                @if(count($user->friends) <= 0)
                                    <span>Get some friends!</span>
                                @else
                                    @foreach( ($friends = $user->friends->paginate(3,[],'friendsPage')) as $friend)
                                        <div class="col-md-3 mx-auto">
                                            <a href="{{route('show.user.info', $friend->slug())}}">
                                                <label
                                                    style="overflow: hidden; height: 24px"> {{$friend->name . " " . $friend->surname}}</label>
                                                <img src="{{$friend->getProfilePic()}}" alt=""
                                                     style="width: 150px; height: 150px;">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{$friends->fragment('friends')->render()}}
                        </div>

                    </div>
                </div>
                <hr>

            </div>  <!-- end col -->
            <div class="container">
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
                                                <div class="d-flex align-items-center">
                                                    @if($post->liked())
                                                        <div>
                                                            <form action="{{route('post.unlike', $post)}}"
                                                                  method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="btn btn-link fa fa-thumbs-down">
                                                                    UnLike
                                                                </button>
                                                            </form>

                                                        </div>
                                                    @else
                                                        <div>
                                                            <form action="{{route('post.like', $post)}}" method="post">
                                                                @csrf
                                                                <button type="submit"
                                                                        class="btn btn-link fa fa-thumbs-up">
                                                                    Like
                                                                </button>
                                                            </form>

                                                        </div>
                                                    @endif
                                                    @if($post->countLikes() > 0)
                                                        <span class="">
                                            {{ $post->countLikes() }}
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($post->user->id == Auth()->user()->id)

                                                <div class="d-flex">

                                                    <div>
                                                        <a href="{{route('posts.show', $post)}}"
                                                           class=" btn btn-sm btn-primary ml-3">Show</a>
                                                    </div>
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
                                            @else
                                                <div>
                                                    <a href="{{route('posts.show', $post)}}"
                                                       class=" btn btn-sm btn-primary">Show</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                <div style="display: flex; justify-content: center;">
                                    {{$user->getFeed()->fragment('posts')->render()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
@endsection
