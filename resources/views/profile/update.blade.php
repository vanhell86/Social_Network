@extends('layouts.app')

@section('content')


    {{-- >>>>>>>>>>>>>>>> Profile image adding section <<<<<<<<<<<<<<<<<<< --}}
    <div class="jumbotron">
        <div class="container">
            <div class="row ">
                <div class="col-md-10 col-md-offset-1">
                    @if (session('imgUploadStatus'))
                        <div class="alert alert-success">
                            {{ session('imgUploadStatus') }}
                        </div>
                    @endif
                    @error('avatar')
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @enderror
                    <img src="{{$user->getProfilePic()}}"
                         style="width: 150px; height: 150px; float: left; border-radius: 50%; margin-right: 25px;">
                    <h2>
                        {{ $user->name }}'s profile
                    </h2>
                    <form action="{{ route('update.avatar',$user->name) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label style="display: block; font-size: 1.2em;"><strong>Update Profile Image</strong></label>
                        <input type="file" name="avatar">
                        <input type="submit" class="pull-right btn btn-sm btn-primary" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        {{-- >>>>>>>>>>>>>>>> Profile info updating section <<<<<<<<<<<<<<<<<<< --}}
        <div class="row justify-content-center mt-5">
            <div class="col-md-10 col-md-offset-1">
                @if (session('userInfoUpdateStatus'))
                    <div class="alert alert-success">
                        {{ session('userInfoUpdateStatus') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{ __('Update Profile') }}</div>
                    {{--                <label style="display: block; font-size: 1.2em;"><strong>Update Profile Info</strong></label>--}}
                    <div class="card-body">
                        <form action="{{ route('user.info.update', $user->name) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">

                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           name='name'
                                           value="{{$user->name ?? ''}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Surname</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('surname') is-invalid @enderror"
                                           name='surname'
                                           value="{{$user->surname ?? ''}}">
                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Address</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                           name='address'
                                           value="{{$user->address ?? ''}}">
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Phone Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('phonenumber') is-invalid @enderror"
                                           name='phonenumber'
                                           value="{{$user->phonenumber ?? ''}}"
                                    >
                                    @error('phonenumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Bio</label>
                                <div class="col-md-6">
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      name="bio"> {{$user->bio ?? ''}}</textarea>
                                    @error('bio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Date of birth</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control @error('dateofbirth') is-invalid @enderror"
                                           name='dateofbirth'
                                           value="{{ $user->dateofbirth ?? '' }}" class="mb-3"
                                    >
                                    @error('dateofbirth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{-- >>>>>>>>>>>>>>>> Change Password <<<<<<<<<<<<<<<<<<< --}}

        <div class="row justify-content-center mt-5">
            <div class="col-md-10 col-md-offset-1">
                @if (session('passwordChange'))
                    <div class="alert alert-success">
                        {{ session('passwordChange') }}
                    </div>
                @elseif(session('passwordChangeError'))
                    <div class="alert alert-danger">
                        {{ session('passwordChangeError') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.password.change', $user) }}">
                            @csrf
                            @method('PUT')
                            <input type="password" style="display:none">
                            <div class="form-group row">
                                <label for="old_password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Old Password') }}</label>

                                <div class="col-md-6">
                                    <input id="old_password" type="password"
                                           class="form-control @error('old_password') is-invalid @enderror"
                                           name="old_password"
                                    >

                                    @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
