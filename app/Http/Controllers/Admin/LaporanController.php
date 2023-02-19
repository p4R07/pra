<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Identitas;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;
use App\Exports\PengembalianExport;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;


class LaporanController extends Controller
{
    public function index()
    {
        $anggota = User::where('role', 'user')->get();
        return view('admin.laporan.laporan', compact('anggota'));
    }

    public function laporan_pdf(Request $request)
    {
        $identitas = Identitas::first();
        if ($request->tanggal_peminjaman) {
            $peminjaman = Peminjaman::where('tanggal_peminjaman', $request->tanggal_peminjaman)->get();
            $count = Peminjaman::where('tanggal_peminjaman', $request->tanggal_peminjaman)->count();
            $tanggal = $request->tanggal_peminjaman;
            $pdf = PDF::loadview('admin.laporan.laporan_peminjaman_pdf', ['count' => $count, 'identitas' => $identitas, 'peminjaman' => $peminjaman, 'tanggal' => $tanggal]);
            return $pdf->stream('laporan-peminjaman-pdf.pdf');
        }
        if ($request->tanggal_pengembalian) {
            $pengembalian = Peminjaman::where('tanggal_pengembalian', $request->tanggal_pengembalian)->get();
            $count = Peminjaman::where('tanggal_pengembalian', $request->tanggal_pengembalian)->count();
            $tanggal = $request->tanggal_pengembalian;
            $pdf = PDF::loadview('admin.laporan.laporan_pengembalian_pdf', ['count' => $count, 'identitas' => $identitas, 'pengembalian' => $pengembalian, 'tanggal' => $tanggal]);
            return $pdf->stream('laporan-pengembalian-pdf.pdf');
        }
        if ($request->user_id) {
            $anggota = Peminjaman::where('user_id', $request->user_id)->get();
            $count = Peminjaman::where('user_id', $request->user_id)->count();
            $nama = User::where('id', $request->user_id)->first();
            $pdf = PDF::loadview('admin.laporan.laporan_siswa_pdf', ['count' => $count, 'identitas' => $identitas, 'identitas' => $identitas, 'anggota' => $anggota, 'nama' => $nama]);
            return $pdf->stream('laporan-user-pdf.pdf');
        }
    }

    public function laporan_excel(Request $request){
        return Excel::download(new LaporanExport($request->tanggal_peminjaman), 'laporan-peminjaman.xlsx');
    }

    public function excelPengembalian(Request $request){
        return Excel::download(new PengembalianExport($request->tanggal_pengembalian), 'laporan-pengembalian.xlsx');
    }

    public function excelUser(Request $request){
        return Excel::download(new UserExport($request->user_id), 'laporan-anggota.xlsx');
    }
}
