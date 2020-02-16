@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
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
                    <label>Update profile image</label>
                    <input type="file" name="avatar">
                    <input type="submit" class="pull-right btn btn-sm btn-primary" value="Submit">
                </form>

            </div>
        </div>
    </div>
@endsection
