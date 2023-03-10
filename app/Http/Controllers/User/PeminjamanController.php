<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Pemberitahuan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{

    //RIWAYAT PEMINJAMAN
    public function riwayatPeminjaman()
    {
        $peminjamans = Peminjaman::where('user_id' , Auth::user()->id)->get();
        return view('user.peminjaman.riwayat' , compact('peminjamans'));
    }

    //FORM PEMINJAMAN
    public function peminjamanForm()
    {
        $bukus = Buku::all();
        return view('user.peminjaman.form' , compact('bukus'));
    }

    public function formDasboard(Request $request)
    {
        $buku_id = $request->buku_id;
        $bukus = Buku::all();

        return view('user.peminjaman.form' , compact('bukus' , 'buku_id'));
    }

    //SUBMIT FORM PEMINJAMAN
    public function submitForm(Request $request){
        $cek_total_peminjaman = Peminjaman::where('user_id', Auth::user()->id)
        ->where('tanggal_pengembalian', null)->count();

        //maks 5
        if ($cek_total_peminjaman >= 5) {
            return redirect()->back()
            ->with("status", "danger")
            ->with("message", "Tidak Bisa Meminjam Buku Lebih Dari 5");
        }

        //cannot be same
        $cek_buku = Peminjaman::where('buku_id', $request->buku_id)
        ->where('user_id', Auth::user()->id)
        ->first();
        if ($cek_buku) {
            return redirect()->route('user.form_peminjaman')
            ->with("status", "danger")
            ->with("message", "Tidak Bisa Meminjam Buku Dengan Judul Yang Sama");
        }

        //nambah peminjaman
        $peminjaman = Peminjaman::create($request->all());

        //mengurangi jumlah buku baik & rusak saat dipinjam
        $buku = Buku::where('id', $request->buku_id)->first();
        if ($request->kondisi_buku_saat_dipinjam == 'baik') {
            $buku->update([
                'j_buku_baik'=> $buku->j_buku_baik - 1
            ]);
        }
        if ($request->kondisi_buku_saat_dipinjam == 'rusak') {
            $buku->update([
                'j_buku_rusak'=> $buku->j_buku_rusak - 1
            ]);
        }

        // Update Pemberitahuan
        Pemberitahuan::create([
            "isi" => Auth::user()->username . " Meminjam Buku " . $buku->judul
        ]);

        if($peminjaman){
            return redirect()->route("user.riwayat_peminjaman")
                ->with("status", "success")
                ->with("message", "Berhasil Menambah Data");
        }
        return redirect()->back()
            ->with("status", "danger")
            ->with("message", "Gagal menambah data");

    }
}
