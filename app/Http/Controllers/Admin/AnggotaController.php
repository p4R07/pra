<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = User::where('role', 'user')->count();
        $kode = 'A0' . $total + 1;
        $anggota = User::where('role', 'user')->get();
        return view('admin.masterdata.anggota', compact('anggota', 'kode'));
    }

    public function store(Request $request)
    {
        $kode = User::where('role', 'user')->count();

        $anggota = User::create([
            'kode' => 'A0' . $kode + 1,
            'nis' => $request->nis,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'kelas' => $request->kelas,
            // 'verif' => 'verified',
            'alamat' => $request->alamat,
            'role' => 'user',
            'join_date' => Carbon::now()
        ]);

        if ($anggota) {
            return redirect()
                ->back()
                ->with("status", "success")
                ->with("message", "Berhasil menambahkan user baru");
        }
        return redirect()->back()
            ->with("status", "danger")
            ->with("message", "Gagal menambahkan user baru");
    }

    public function update(Request $request, $id)
    {
        $anggota = User::where('role', 'user')->where('id', $id);

        $anggota->update([
            'nis' => $request->nis,
            // 'username' => $request->username,
            'fullname' => $request->fullname,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
        ]);
        return redirect()->back();
    }

    public function update_status(Request $request, $id){
        $anggota = User::where('id', $id)->first();

        if ($anggota != null) {
            if ($request->verif == 'unverified') {
                $anggota->update([
                   'verif' =>'verified',
                ]);
            }

            if ($request->verif == 'verified') {
                $anggota->update([
                  'verif' =>'unverified',
                ]);
            }

            return redirect()
                ->back()
                ->with("status", "success")
                ->with("message", "Berhasil merubah status");
        }
            return redirect()->back()
                ->with("status", "danger")
                ->with("message", "Gagal merubah status");
    }

    public function delete($id)
    {
        $anggota = User::where('role', 'user')->where('id', $id);
        $anggota->delete();

        return redirect()->back();
    }
}
