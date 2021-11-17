<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginSocialiteController extends Controller
{
    public function redirect($provider)
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Throwable $th) {
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function callback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $authUser = $this->findOrCreateUser($user, $provider);
            Auth::login($authUser, true);
            return redirect()->route('home', ['role' => 'users']);
        } catch (\Throwable $th) {
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function findOrCreateUser($user, $provider)
    {
        try {
            $authUser = User::where('provider_id', $user->id)->first();
            if ($authUser) {
                return $authUser;
            }
            return User::create([
                'username'     => $user->name,
                'slug' => Str::slug($user->name),
                'email'    => $user->email,
                'provider' => $provider,
                'provider_id' => $user->id,
                'password' => Hash::make('SIPOS-1992'),
                'remember_token' => Str::random(100),
            ]);
        } catch (\Throwable $th) {
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }
}
