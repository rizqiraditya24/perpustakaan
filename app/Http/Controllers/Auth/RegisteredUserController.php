<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap'  => ['required', 'string', 'max:255'],
            'username'      => ['required', 'string', 'max:50', 'unique:users,username'],
            'email'         => ['required', 'email', 'max:255', 'unique:users,email'],
            'telepon'       => ['nullable', 'string', 'max:20'],
            'alamat'        => ['nullable', 'string', 'max:255'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'nis'           => ['required', 'string', 'unique:siswa,nis'],
            'kelas'         => ['required', 'string', 'max:20'],
            'jurusan'       => ['nullable', 'string', 'max:50'],
            'tanggal_lahir' => ['nullable', 'date'],
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'email'        => $request->email,
            'telepon'      => $request->telepon,
            'alamat'       => $request->alamat,
            'password'     => Hash::make($request->password),
            'role'         => 'siswa',
        ]);

        Siswa::create([
            'user_id'       => $user->id,
            'nis'           => $request->nis,
            'kelas'         => $request->kelas,
            'jurusan'       => $request->jurusan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status'        => 'aktif',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('siswa.dashboard');
    }
}
