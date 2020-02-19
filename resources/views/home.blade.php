@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 pt-3">
                <h1 style="font-size: 5em;">Welcome to FB v2.0</h1>
            </div>
        </div>

        {{-- >>>>>>>>>>>>>>>> Profile info section<<<<<<<<<<<<<<<<<<< --}}
        <div class="row justify-content-center">
            <div class="col-md-8 text-black-50 pt-3" style="display: flex; ">
                <div style="display: flex; justify-content: center; width: 100%;  flex-wrap: wrap;">
                    @foreach((($users = \App\User::whereNotIn('id', [Auth::id()])->paginate(9))) as $user)
                        <div class="col-sm-4" style="border: 1px solid black; margin-bottom: 30px;">
{{--                            style="display: flex; flex-wrap: wrap; float: left; margin:0 25px 25px 0;"--}}
                            <label style="display: block"><strong>{{$user->name . ' ' . $user->surname }}</strong></label>
                            <a href="{{route('show.user.info', $user->slug())}}">
                                <img src="{{asset( "storage/uploads/avatars/". $user->avatar )}}"
                                     style="width: 150px; height: 150px;  ">
                            </a>
                        </div>
                    @endforeach
                    <div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: flex; justify-content: center;">
            {{ $users->links() }}
        </div>

        {{-- >>>>>>>>>>>>>>>> Post Wall section <<<<<<<<<<<<<<<<<<< --}}
        <div class="row justify-content-center" style="display: flex;">
            <div></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Post Wall</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
