<div class="jumbotron">
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
    </div>
</div>
<hr>


<div class="container">
    {{-- >>>>>>>>>>>>>>>> Friends section <<<<<<<<<<<<<<<<<<< --}}
    <div class="row justify-content-center">
        <div class="col-md-6 text-black-50 pt-3">
            <div class="card-box">
                <h4 class="m-t-0 m-b-20 header-title">Friends</h4>
                <div class="card-body col-md-10 d-flex">
                    @if(count($user->friends) <= 0)
                        <span>Get some friends!</span>
                    @else
                        @foreach( ($friends = $user->friends->paginate(2)) as $friend)
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
                <div>
                    <span>
                        <a href="{{route('friends.index',$user)}}">See all friends</a>
                    </span>
                    <span class="float-right">
                        <a href="{{route('friends.request',$user)}}">All friend requests</a>
                    </span>
                </div>
            </div>


        </div>
        {{-- >>>>>>>>>>>>>>>> Gallery section <<<<<<<<<<<<<<<<<<< --}}
        <div class="col-md-6 text-black-50 pt-3">
            <div class="card-box">
                <h4 class="m-t-0 m-b-20 header-title">Gallery</h4>
                @if(count($user->albums) <= 0)
                    <span>User have no albums yet</span><br>
                    <a href="{{route('albums.create')}}">Create new album</a>
                @else
                    <div class="card mb-4 shadow-sm">
                        <img src="{{$user->albums->first()->getAlbumCover()}}" alt="Album cover"
                             width="400px" >

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

        </div>

    </div>
</div>
<hr>
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
                                                <form action="{{route('post.unlike', $post)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link fa fa-thumbs-down">
                                                        UnLike
                                                    </button>
                                                </form>

                                            </div>
                                        @else
                                            <div>
                                                <form action="{{route('post.like', $post)}}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link fa fa-thumbs-up">
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
</div>
