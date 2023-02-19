<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{

    public function index()
    {
        $admin = User::where('role', 'admin')->get();
        return view('admin.masterdata.administrator', compact('admin'));
    }

    public function store(Request $request)
    {
        $admin = User::create([
            'kode' => '',
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'admin',
            'verif' => 'verified',
            'join_date' => Carbon::now(),
        ]);

        if ($admin) {
            return redirect()
                ->back()
                ->with("status", "success")
                ->with("message", "Berhasil menambah admin");
        }
        return redirect()
            ->back()
            ->with("status", "danger")
            ->with("message", "Gagal menambah admin");
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->where('id', $id);
        $admin->update([
            'fullname' => $request->fullname,
            'username' => $request->username,
        ]);
        return redirect()->back();
    }

    public function delete($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->back();
    }
}
