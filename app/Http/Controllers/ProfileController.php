<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePassword;
use App\Http\Requests\UpdateProfile;
use App\Models\User;
use App\Models\UserProfile;
use Validator;
use Auth;
use Session;

class ProfileController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index($username)
    {
        $user = User::where('username', $username)->first();
        return view('pasarbatik.user.profile.index', compact('user'));
    }

    public function edit($username)
    {
        $user = User::where('username', $username)->first();

        return view('pasarbatik.user.profile.edit-bio', [
            'user' => $user,
        ]);
    }

    public function updateProfile(UpdateProfile $request, UserProfile $profile)
    {
        $profile->update($request->all());

        Session::flash('success', 'Sukses');
        return redirect()->back();
    }

    public function editPassword($username)
    {
        $user = User::where('username', $username)->first();

        return view('pasarbatik.user.profile.edit-password', [
            'user' => $user,
        ]);
    }

    public function updatePassword(UpdatePassword $request, User $user)
    {
        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        Session::flash('success', 'Sukses');
        return redirect()->back();
    }
}
