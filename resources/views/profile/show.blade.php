@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- >>>>>>>>>>>>>>>> Profile info section<<<<<<<<<<<<<<<<<<< --}}
        <div class="row justify-content-center bg-info  mb-3" style="border-radius: 20%;">
            <div class="col-md-8 text-black-50 pt-3">
                <div style="display: flex;  align-items: center;">
                    <div>
                        <img src="{{asset( "storage/uploads/avatars/". $user->avatar )}}"
                             style="width: 150px; height: 150px; float: left; border-radius: 50%; margin-right: 25px;">
                    </div>
                    <div>
                        @if($user->address)
                            <div class="mb-3">
                                <label>Address: </label>
                                {{$user->address}}
                            </div>
                        @endif
                        @if($user->phonenumber)
                            <div class="mb-3">
                                <label>Phone Number: </label>
                                {{$user->phonenumber}}
                            </div>
                        @endif
                        @if($user->bio)
                            <div class="mb-3">
                                <label>Bio: </label>
                                {{$user->bio}}
                            </div>
                        @endif
                        @if($user->dateofbirth)
                            <div class="mb-3">
                                <label>Date of Birth: </label>
                                {{$user->dateofbirth}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- >>>>>>>>>>>>>>>> Post Wall section <<<<<<<<<<<<<<<<<<< --}}
        <div class="row justify-content-center" style="display: flex;">
            <div></div>
            <div class="col-md-8">
                @foreach(($user->posts)->SortByDesc('created_at') as $post)
                    <div class="card mb-3">
                        <div class="card-header">{{$post->title}}</div>
                        <div class="card-body">
                            {!!  $post->content !!}
                        </div>
                        <div class="card-footer">Created at: {{$post->created_at}}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
