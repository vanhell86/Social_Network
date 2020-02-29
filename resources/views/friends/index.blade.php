@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 pt-3 d-flex justify-content-center ">
                    <span style="font-size: 3em; display: block">{{$user->name}} friends!</span>
                </div>
            </div>
        </div>
    </div>

    {{-- >>>>>>>>>>>>>>>> All friends section<<<<<<<<<<<<<<<<<<< --}}
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8 text-black-50 pt-3" style="display: flex; ">

                <div style="display: flex; justify-content: center; width: 100%;  flex-wrap: wrap;">

                    @if (session('Status'))
                        <div class="col-sm-12 alert alert-success">
                            <div>{{ session('Status') }}</div>
                        </div>
                    @endif

                    @foreach($user->friends as $user)

                        <div class="col-sm-12 d-flex" style=" margin-bottom: 30px;">
                            <div class="col-sm-5">
                                <label
                                    style="display: block"><strong>{{$user->name . ' ' . $user->surname }}</strong></label>

                                <a href="{{route('show.user.info', $user->slug())}}">
                                    <img src="{{$user->getProfilePic() }}"
                                         style="width: 150px; height: 150px;  ">
                                </a>
                            </div>
                            <div class="col-sm-5 align-items-center" style="display: flex;
  flex-direction: row;
  justify-content: center;">
                                @if(Auth()->user()->areFriends($user))
                                    <form action="{{route('end.friendship', $user)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="pull-right btn btn-sm btn-primary">
                                            {{ __('Unfriend') }}
                                        </button>
                                    </form>
                                @endif
                                <form action="{{route('follow', $user)}}" method="post">
                                    @csrf
                                    <button type="submit" class="pull-right btn btn-sm btn-primary ml-3">
                                        @if( ! Auth()->user()->isFollowing($user))
                                            {{ __('Follow') }}
                                        @else
                                            {{ __('Unfollow') }}
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
