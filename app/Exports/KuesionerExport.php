<?php

namespace App\Exports;

use App\Models\KuesionerMandiri;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KuesionerExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    use Exportable;

    protected $ranting_id;
    protected $periode_id;

    public function __construct($ranting_id = null, $periode_id = null)
    {
        $this->ranting_id = $ranting_id;
        $this->periode_id = $periode_id;
    }

    public function query()
    {
        $query = KuesionerMandiri::query()->with(['user', 'ranting', 'periode']);

        if ($this->ranting_id) {
            $query->where('ranting_id', $this->ranting_id);
        }

        if ($this->periode_id) {
            $query->where('periode_id', $this->periode_id);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tahun Periode',
            'Nama Wilayah Ranting',
            'Nama',
            'NIK',
            'Tanggal Mengisi',
            'Jenis Kelamin',
            'Status Kawin',
            'Umur',
            'Agama',
            'Skor SRQ',
            'Interpretasi SRQ',
            'Skor Kebiasaan',
            'Interpretasi Kebiasaan',
        ];
    }

    public function map($row): array
    {
        $interpretasi_srq = '';
        if ($row->skor_srq >= 6) {
            $interpretasi_srq = "1. Mengobrol dari Hati ke Hati dengan Pendamping Terlatih (Konseling)\n2. Meredam Pemicu Stres agar Tidak Semakin Berat (Pencegahan)\n3. Meneruskan Penanganan ke Ahlinya (Rujukan)";
        } else {
            $interpretasi_srq = "1. Pertahankan Pola Hidup Sehat\n2. Mengistirahatkan Jiwa dan Raga (Relaksasi)\n3. Mengurai Beban Pikiran (Manajemen Stres)\n4. Menghadapi Masalah dengan Cara yang Sehat (Mekanisme Koping)";
        }

        $interpretasi_kebiasaan = '';
        if ($row->skor_kebiasaan >= 25 && $row->skor_kebiasaan <= 32) {
            $interpretasi_kebiasaan = 'Baik';
        } elseif ($row->skor_kebiasaan >= 16 && $row->skor_kebiasaan <= 24) {
            $interpretasi_kebiasaan = 'Cukup';
        } else {
            $interpretasi_kebiasaan = 'Kurang';
        }

        return [
            $row->id,
            $row->periode->tahun ?? '-',
            $row->ranting->nama_ranting ?? '-',
            $row->nama,
            $row->nik,
            $row->tanggal_mengisi ? $row->tanggal_mengisi->format('Y-m-d') : '-',
            $row->jenis_kelamin,
            $row->status_kawin,
            $row->umur,
            $row->agama,
            $row->skor_srq,
            $interpretasi_srq,
            $row->skor_kebiasaan,
            $interpretasi_kebiasaan,
        ];
    }

    public function title(): string
    {
        return 'Kuesioner Mandiri';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2A7B3E']
                ]
            ],
        ];
    }
}
