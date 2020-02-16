<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('profile/profile', ['user' => Auth::user()]);
    }

    public function update_avatar(ImageRequest $request)
    {

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $fileName = time() . '.' . $avatar->getClientOriginalExtension();

            $image = Image::make($avatar)->resize(300,300)->save(storage_path( "app/public/uploads/avatars/" . $fileName));

            $user = Auth::user();
            $user->avatar = $fileName;
            $user->save();
        }
        return view('profile/profile', ['user' => Auth::user()]);
    }
}
