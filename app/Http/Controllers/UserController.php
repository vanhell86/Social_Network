<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\UserInfoRequest;
use App\Http\Requests\UserPasswordChangeRequest;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = (new User())->whereNotIn('id', [Auth::id()])->paginate(4);
        return view('profile/index', ['users' => $users]);
    }

    public function show(User $user)
    {
        return view('profile/show', ['user' => $user]);
    }

    public function showProfileUpdateForm(User $user): View
    {
        return view('profile/update', ['user' => $user]);
    }

    public function edit(UserInfoRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->update($request->all());
        return back()->with('userInfoUpdateStatus', 'Your profile info updated successfully!');
    }

    public function updateAvatar(ImageRequest $request): RedirectResponse
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = time() . '.' . $avatar->getClientOriginalExtension();
            $user = Auth::user();

            if (!File::exists(storage_path("app/public/uploads/$user->id/avatars/" )))
            {
                File::makeDirectory(storage_path("app/public/uploads/$user->id/avatars/"),0755,true,true);
            }


            $image = Image::make($avatar)->resize(300, 300)
                ->save(storage_path("app/public/uploads/$user->id/avatars/" . $fileName));

            $user->avatar = $fileName;
            $user->save();
        }
        return back()->with('imgUploadStatus', 'Your profile image upload successful!');
    }

    public function changePassword(UserPasswordChangeRequest $request, User $user)
    {
        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            return back()->with('passwordChange', 'Your password changed successfully!');
        }
        return back()->with('passwordChangeError', 'Password does not match');
    }
}
