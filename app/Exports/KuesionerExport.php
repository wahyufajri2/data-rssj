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

    public function __construct($ranting_id = null)
    {
        $this->ranting_id = $ranting_id;
    }

    public function query()
    {
        $query = KuesionerMandiri::query()->with(['user', 'ranting', 'periode']);

        if ($this->ranting_id) {
            $query->where('ranting_id', $this->ranting_id);
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
            $row->interpretasi_srq,
            $row->skor_kebiasaan,
            $row->interpretasi_kebiasaan,
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
