<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserRegister extends Controller
{
    public function UserRegister (Request $request)
    {
        $kode = User::where('role', 'user')->count();

        $anggota = User::create([
            'kode' => 'A0' . $kode + 1,
            'nis' => $request->nis,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'kelas' => $request->kelas,
            'verif' => 'unverified',
            'alamat' => $request->alamat,
            'role' => 'user',
            'join_date' => Carbon::now()
        ]);

        if ($anggota) {
            return redirect()->route('login')
                ->with('status', 'success')
                ->with('message', 'Berhasil registerasi, tunggu verifikasi admin');
        }

        return redirect()->back()
            ->with('status', 'danger')
            ->with('message', 'Gagal menambahkan data user');
    }
}

