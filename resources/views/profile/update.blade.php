@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- >>>>>>>>>>>>>>>> Profile image adding section <<<<<<<<<<<<<<<<<<< --}}
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
                <img src="{{asset( "storage/uploads/avatars/". $user->avatar )}}"
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

        {{-- >>>>>>>>>>>>>>>> Profile info updating section <<<<<<<<<<<<<<<<<<< --}}
        <div class="row mt-3">
            <div class="col-md-10 col-md-offset-1">
                @if (session('userInfoUpdateStatus'))
                    <div class="alert alert-success">
                        {{ session('userInfoUpdateStatus') }}
                    </div>
                @endif
                <label style="display: block; font-size: 1.2em;"><strong>Update Profile Info</strong></label>
                <form action="{{ route('user.info.update', $user->name) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group d-flex flex-column">
                        <label style="display: block">Address</label>
                        <input type="text" class="@error('address') is-invalid @enderror" name='address'
                               placeholder="{{$user->address ?? ''}}">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group d-flex flex-column">
                        <label style="display: block">Phone Number</label>
                        <input type="text" class="@error('phonenumber') is-invalid @enderror" name='phonenumber'
                               placeholder="{{$user->phonenumber ?? ''}}"
                        >
                        @error('phonenumber')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group d-flex flex-column">
                        <label style="display: block">BIO</label>
                        <textarea class="@error('bio') is-invalid @enderror" name="bio"> {{$user->bio ?? ''}}</textarea>
                        @error('bio')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group d-flex flex-column">
                        <label style="display: block">Date of Birth</label>
                        <input type="date" class="@error('dateofbirth') is-invalid @enderror" name='dateofbirth'
                               value="{{ $user->dateofbirth ?? '' }}" class="mb-3"
                        >
                        @error('dateofbirth')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <input type="submit" class="btn btn-sm btn-primary" value="Update">
                </form>
            </div>
        </div>
    </div>
@endsection
