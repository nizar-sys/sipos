<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestStoreCreateUser;
use App\Http\Traits\ReturnTrait;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    use ReturnTrait;

    public function show()
    {
        //
        dd(Auth::user()->role);
    }

    public function store(RequestStoreCreateUser $request)
    {
        try {

            $validated = $request->validated();

            User::create([
                'username' => $validated['username'],
                'slug' => Str::slug($validated['username']),
                'email' => $validated['email'],
                'role' => $validated['role'],
                'password' => Hash::make($validated['password']),
            ]);

            activity()->log('Menambah pengguna baru');
            if ($request->ajax()) {
                return $this->success(null, 'Berhasil tambah data');
            }

            return redirect()->back()->with('success', 'Berhasil tambah data');
        } catch (\Throwable $th) {

            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function createUserExcel(Request $request)
    {
        try {


            $fileName = explode('.', $request->file('file')->getClientOriginalName())[0] . '-' . time() . '.' . $request->file('file')->extension();

            //code...
            Excel::import(new UsersImport, $request->file('file'));

            if ($request->ajax()) {
                return $this->success(null, 'Berhasil import data pengguna');
            }

            return redirect()->back()->with('success', 'Berhasil import data pengguna');
        } catch (\Throwable $th) {

            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {

            $arrUserId = $request->selectedData;
            $arrUserId = explode(',', $arrUserId);

            $users = User::whereIn('id', $arrUserId);

            $users->delete();

            activity()->log('Menghapus beberapa data pengguna');

            if ($request->ajax()) {
                return $this->success(null, 'Berhasil hapus beberapa data');
            }

            return redirect()->back()->with('success', 'Berhasil hapus beberapa data');
        } catch (\Throwable $th) {

            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }
}
