<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestStoreForgotPass;
use App\Http\Requests\RequestStoreLogin;
use App\Http\Requests\RequestStoreResetPass;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStoreLogin $request)
    {
        try {

            $validated = $request->validated();
            $remember = $request->has('remember') ? true : false;

            $data = [
                'username' => $validated['username'],
                'password' => $validated['password'],
            ];

            $user = Auth::attempt($data, $remember);

            if (!$user) {
                return redirect()->back()->with('error', 'Username / Password salah');
            } else {
                $role = Auth::user()->role == '1' ? 'admin' : 'user';
                return redirect()->route('home', ['role' => $role])->with('info', "Hallo " . Auth::user()->username);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function postForgotPass(RequestStoreForgotPass $request)
    {
        try {

            $request->validated();

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? back()->with(['info' => __($status)])
                : back()->withErrors(['email' => __($status)]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function postResetPassword(RequestStoreResetPass $request)
    {
        try {
            $request->validated();
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(100));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }
}
