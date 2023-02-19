<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{

    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.katalog.kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        $kategori = Kategori::create([
            'kode' => lcfirst($request->nama),
            'nama' => ucfirst($request->nama)
        ]);

        if ($kategori) {
            return redirect()
                ->back()
                ->with("status", "success")
                ->with("message", "Berhasil menambahkan kategori baru");
        }
        return redirect()
            ->back()
            ->with("status", "danger")
            ->with("message", "Gagal menambahkan kategori baru");
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'kode' => $request->kode,
            'nama' => $request->nama
        ]);
        return redirect()->back();
    }

    public function delete($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back();
    }
}
