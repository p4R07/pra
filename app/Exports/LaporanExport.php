<?php

namespace App\Exports;

use App\Models\Identitas;
use App\Models\Peminjaman;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class LaporanExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $peminjamans = Peminjaman::where('tanggal_peminjaman', $this->request)->get();
        $identitas = Identitas::first();
        return view('admin.excel.peminjaman', compact('peminjamans', 'identitas'));
    }

    public function registerEvents(): array{
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                //Kop Surat
                $event->sheet->getDelegate()->mergeCells('A1:F1');
                $event->sheet->getDelegate()->mergeCells('A2:F2');
                $event->sheet->getDelegate()->mergeCells('A3:F3');
                $event->sheet->getDelegate()->mergeCells('A4:F4');
                // tengah
                $event->sheet->getDelegate()
                    ->getStyle('A1:A4')
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },

            AfterSheet::class => function(AfterSheet $event) {
                //jarak
                $event->sheet->getDelegate()->getRowDimension('5')->setRowHeight(25);
                //warna belakang
                $event->sheet->getDelegate()->getStyle('A5:F5')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('435EBE');
                //font
                $event->sheet->getDelegate()->getStyle('A5:F5')
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                //jarak
                $event->sheet->getDelegate()
                    ->getStyle('A5:F5')
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }
        ];
    }
}
