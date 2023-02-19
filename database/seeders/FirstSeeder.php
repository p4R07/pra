<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Identitas;
use App\Models\Kategori;
use App\Models\Pemberitahuan;
use App\Models\Peminjaman;
use App\Models\Penerbit;
use App\Models\Pesan;
use App\Models\User;
use Illuminate\Database\Seeder;

class FirstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'kode' => 'Admin1',
            'fullname' => 'Admin',
            'username' => 'Admin',
            'password' => bcrypt('password'),
            'verif' => 'verified',
            'role' => 'admin',
            'join_date' => '2023-01-06',
            'foto' => '',
        ]);
        User::create([
            'kode' => 'A01',
            'nis' => '12345',
            'fullname' => 'Nab',
            'username' => 'Nab',
            'password' => bcrypt('Nab'),
            'kelas' => 'XII RPL',
            'alamat' => 'Jakarta',
            'verif' => 'verified',
            'role' => 'user',
            'join_date' => date('Y-m-d H:i:s'),
            'foto' => '',
        ]);
        User::create([
            'kode' => 'A0',
            'nis' => '67890',
            'fullname' => 'Kat',
            'username' => 'Kat',
            'password' => bcrypt('Kat'),
            'kelas' => 'XI RPL',
            'alamat' => 'Timur',
            'role' => 'user',
            'join_date' => date('Y-m-d H:i:s'),
            'foto' => '',
        ]);

        Kategori::create([
            'kode' => 'umum',
            'nama' => 'Umum'
        ]);
        Kategori::create([
            'kode' => 'sains',
            'nama' => 'Sains'
        ]);
        Kategori::create([
            'kode' => 'sejarah',
            'nama' => 'Sejarah'
        ]);

        Penerbit::create([
            'kode' => 'erlangga',
            'nama' => 'Erlangga',
        ]);
        Penerbit::create([
            'kode' => 'bse',
            'nama' => 'BSE',
        ]);
        Penerbit::create([
            'kode' => 'gramedia',
            'nama' => 'Gramedia',
        ]);

        Buku::create([
            'judul' => 'Cara Memasak Nasi',
            'kategori_id' => 1,
            'penerbit_id' => 1,
            'pengarang' => 'A',
            'tahun_terbit' => '2022',
            'isbn' => '3432423',
            'j_buku_baik' => 20,
            'j_buku_rusak' => 0,
            'foto' => ''
        ]);
        Buku::create([
            'judul' => 'Ensiklopedia Luar Angkasa',
            'kategori_id' => 2,
            'penerbit_id' => 2,
            'pengarang' => 'B',
            'tahun_terbit' => '2021',
            'isbn' => '9473272',
            'j_buku_baik' => 10,
            'j_buku_rusak' => 5,
            'foto' => ''
        ]);
        Buku::create([
            'judul' => 'Api Sejarah',
            'kategori_id' => 3,
            'penerbit_id' => 3,
            'pengarang' => 'C',
            'tahun_terbit' => '2017',
            'isbn' => '4320423',
            'j_buku_baik' => 10,
            'j_buku_rusak' => 3,
            'foto' => ''
        ]);

        Peminjaman::create([
            'user_id' =>  2,
            'buku_id' =>  1,
            'tanggal_peminjaman' => '2022-09-01 23:09:02',
            'kondisi_buku_saat_dipinjam' =>  'baik',
        ]);
        Peminjaman::create([
            'user_id' =>  3,
            'buku_id' =>  2,
            'tanggal_peminjaman' => '2022-09-01 23:09:02',
            'kondisi_buku_saat_dipinjam' =>  'baik',
            // 'kondisi_buku_saat_dikembalikan' =>  'rusak',
            // 'denda' => 20000
        ]);
        Peminjaman::create([
            'user_id' =>  2,
            'buku_id' =>  3,
            'tanggal_peminjaman' => '2022-09-01 23:09:02',
            'tanggal_pengembalian' =>  '2022-09-01 23:09:02',
            'kondisi_buku_saat_dipinjam' =>  'baik',
            // 'denda' => 50000
        ]);

        Pemberitahuan::create([
            'isi' => 'Maaf, perpus sedang tutup. Hanya menerima pengembalian',
            'status' => 'aktif',
        ]);
        Pemberitahuan::create([
            'isi' => 'Maaf server sedang maintance',
            'status' => 'nonaktif',
        ]);
        Pemberitahuan::create([
            'isi' => 'Pengembalian buku paket sampai tanggal 30 Januari 2023',
            'status' => 'aktif',
        ]);

        Pesan::create([
            'penerima_id' => '2',
            'pengirim_id' => '1',
            'judul' => 'Buku dipinjam',
            'isi' => 'Buku sedang dipinjam, harap mengembalikan sebelum 30 hari ',
            'status' => 'terkirim',
            'tanggal_kirim' => '2022-09-01',
        ]);
        Pesan::create([
            'penerima_id' => '3',
            'pengirim_id' => '1',
            'judul' => 'Anda merusakan buku',
            'isi' => 'Anda kena denda 100000',
            'status' => 'terkirim',
            'tanggal_kirim' => '2022-09-01',
        ]);
        Pesan::create([
            'penerima_id' => '2',
            'pengirim_id' => '1',
            'judul' => 'Buku telah dikembalikan',
            'isi' => 'Terimakasih telah meminjam buku di perpus',
            'status' => 'dibaca',
            'tanggal_kirim' => '2022-09-01',
        ]);

        Identitas::create([
            'nama_app' => 'PERPUSTAKAAN SMKN 10 JAKARTA',
            'alamat_app' => 'Jl. SMEA 6, Cawang, Kramat Jati, Jakarta Timur',
            'email_app' => 'email@smkn10jakarta.sch.id',
            'nomor_hp' => '081234658',
            'foto' => '',
        ]);
    }
}
