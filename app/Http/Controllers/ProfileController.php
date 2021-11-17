<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestStoreUpdateProfile;
use App\Http\Traits\ReturnTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ReturnTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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

    public function changeFotoProfile(Request $request)
    {
        try {

            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20348',
            ]);

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(storage_path('app/public/avatarUsers'), $imageName);

            $user = User::all()->where('id', Auth::user()->id)->first();

            Storage::disk('public')->delete("/avatarUsers/$user->avatar");

            $user->update([
                'avatar' => $imageName,
                'updated_at' => date(now())
            ]);


            if ($request->ajax()) {
                return $this->success(null, 'success');
            }

            return redirect()->route('profile', ['slug' => $user->slug])->with('success', 'Berhasil ubah avatar profile');
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }
            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function changeProfile(RequestStoreUpdateProfile $request)
    {
        try {
            $validated = $request->validated();

            $user = User::all()->where('id', Auth::user()->id)->first();

            $user->update([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'updated_at' => date(now())
            ]);


            if ($request->ajax()) {
                return $this->success(null, 'Profile berhasil diubah');
            }

            return redirect()->back()->with('success', 'Profile berhasil diubah');
        } catch (\Throwable $th) {

            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }
}
