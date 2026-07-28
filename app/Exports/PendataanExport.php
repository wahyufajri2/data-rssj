<?php

namespace App\Exports;

use App\Models\PendataanKeluarga;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PendataanExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
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
        $query = PendataanKeluarga::query()->with(['user', 'ranting', 'periode']);

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
            'Petugas (User)',
            'Nama KK',
            'Umur',
            'Status Kawin',
            'Pendidikan',
            'Pekerjaan',
            'Alamat Dusun',
            'No Rumah',
            'Status Kesehatan',
            'Tanggal Dibuat',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->periode->tahun ?? '-',
            $row->ranting->nama_ranting ?? '-',
            $row->user->name ?? '-',
            $row->nama_kk,
            $row->umur,
            $row->status_kawin,
            $row->pendidikan,
            $row->pekerjaan,
            $row->alamat_dusun,
            $row->no_rumah,
            strtoupper($row->status_kesehatan),
            $row->created_at ? $row->created_at->format('Y-m-d H:i') : '-',
        ];
    }

    public function title(): string
    {
        return 'Pendataan RSSJ';
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
