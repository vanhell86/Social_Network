<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\UserInfoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(): View
    {
        return view('profile/profile', ['user' => Auth::user()]);
    }

    /**
     * @param UserInfoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(UserInfoRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->update($request->all());
        return back();
    }

    /**
     * @param ImageRequest $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function update_avatar(ImageRequest $request): View
    {

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = time() . '.' . $avatar->getClientOriginalExtension();

            $image = Image::make($avatar)->resize(300, 300)->save(storage_path("app/public/uploads/avatars/" . $fileName));

            $user = Auth::user();
            $user->avatar = $fileName;
            $user->save();
        }
        return view('profile/profile', ['user' => Auth::user()]);
    }
}
