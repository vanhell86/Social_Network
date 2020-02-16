@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-10 col-md-offset-1">

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
                <form action="{{ route('update.avatar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label style="display: block; font-size: 1.2em;"><strong>Update Profile Image</strong></label>
                    <input type="file" name="avatar">
                    <input type="submit" class="pull-right btn btn-sm btn-primary" value="Submit">
                </form>

            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-10 col-md-offset-1">
                <label style="display: block; font-size: 1.2em;"><strong>Update Profile Info</strong></label>
                <form action="{{ route('user.info.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group d-flex flex-column">
                        <label style="display: block">Address</label>
                        <input type="text" name='address' placeholder="{{$user->address ?? ''}}">
                        <label style="display: block">Phone Number</label>
                        <input type="text" name='phonenumber' placeholder="{{$user->phonenumber ?? ''}}">
                        <label style="display: block">BIO</label>
                        <input type="text" name='bio' placeholder="{{$user->bio ?? ''}}">
                        <label style="display: block">Date of Birth</label>
                        <input type="date" name='dateofbirth' class="mb-3">
                        <input type="submit" class="btn btn-sm btn-primary" value="Submit">
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
