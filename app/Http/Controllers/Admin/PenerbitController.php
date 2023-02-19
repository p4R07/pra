<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penerbit = Penerbit::all();
        $total = count($penerbit);
        $kode = 'P0' . $total + 1;
        return view('admin.masterdata.penerbit', compact('penerbit', 'kode'));
    }

    public function store(Request $request)
    {
        $penerbit = Penerbit::all();
        $total = count($penerbit);
        $kode = 'P0'. $total + 1;

        $penerbit = Penerbit::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'verif' => $request->verif
        ]);

        if ($penerbit) {
            return redirect()
                ->back()
                ->with("status", "success")
                ->with("message", "Berhasil menambahkan penerbit baru");
        }
        return redirect()->back()
            ->with("status", "danger")
            ->with("message", "Gagal menambah penerbit baru");
    }

    public function update(Request $request, $id)
    {
        $penerbit = Penerbit::findOrFail($id);
        $penerbit->update([
            'nama' => $request->nama,
        ]);
        return redirect()->back();
    }

    public function updateStatus($id, Request $request){
        $penerbit = Penerbit::where('id', $id)->first();

        if ($penerbit != null) {
            if ($request->verif == 'unverified') {
                $penerbit->update([
                    'verif' => 'verified'
                ]);
        }

         if ($request->verif =='verified') {
            $penerbit->update([
               'verif' => 'unverified'
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
        $penerbit = Penerbit::findOrFail($id);
        $penerbit->delete();

        return redirect()->back();
    }
}
