<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\UserInfoRequest;
use App\Http\Requests\UserPasswordChangeRequest;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        $users =  (new User())->whereNotIn('id', [Auth::id()])->paginate(5);
        return view('profile/index', ['users' => $users]);
    }

    public function show(User $user)
    {
        return view('profile/show', ['user' => $user]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfileUpdateForm(User $user): View
    {
        return view('profile/update', ['user' => $user]);
    }

    /**
     * @param UserInfoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(UserInfoRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->update($request->all());
        return back()->with('userInfoUpdateStatus', 'Your profile info updated successfully!');
    }

    /**
     *
     * @param ImageRequest $request
     * @return RedirectResponse
     */
    public function update_avatar(ImageRequest $request): RedirectResponse
    {

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = time() . '.' . $avatar->getClientOriginalExtension();


            $image = Image::make($avatar)->resize(300, 300)->save(storage_path("app/public/uploads/avatars/" . $fileName));

            $user = Auth::user();
            $user->avatar = $fileName;
            $user->save();
        }
        return back()->with('imgUploadStatus', 'Your profile image upload successful!');
    }

    public function change_password(UserPasswordChangeRequest $request, User $user)
    {
        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            //$request->session()->flash('success', 'Password changed');
            return back()->with('passwordChange', 'Your password changed successfully!');

        } else {
//            $request->session()->flash('error', 'Password does not match');
            return back()->with('passwordChangeError', 'Password does not match');
        }
    }
}
