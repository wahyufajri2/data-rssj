<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class HistoriSkriningExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = DB::table('screenings')
            ->join('users', 'screenings.user_id', '=', 'users.id')
            ->select([
                'users.name as nama_pasien',
                'screenings.vas_score',
                'screenings.vas_category',
                'screenings.gad_score',
                'screenings.gad_category',
                'screenings.completed_at'
            ]);

        if (!empty($this->filters['search'])) {
            $query->where(function ($q) {
                $q->where('users.name', 'like', '%' . $this->filters['search'] . '%')
                    ->orWhere('users.no_hp', 'like', '%' . $this->filters['search'] . '%');
            });
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('screenings.completed_at', [
                $this->filters['start_date'] . ' 00:00:00',
                $this->filters['end_date'] . ' 23:59:59'
            ]);
        }

        return $query->orderBy('screenings.completed_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Nama Pasien',
            'Skor VAS',
            'Status Mood Awal',
            'Skor GAD-7',
            'Kategori Kecemasan',
            'Waktu Selesai'
        ];
    }

    public function map($row): array
    {
        return [
            $row->nama_pasien,
            $row->vas_score . ' / 10',
            ucfirst($row->vas_category),
            $row->gad_score ?? 'Tidak Skrining GAD',
            $row->gad_category ? ucfirst($row->gad_category) : 'Tidak Skrining GAD',
            $row->completed_at ? \Carbon\Carbon::parse($row->completed_at)->translatedFormat('d F Y, H:i') : '-'
        ];
    }

    /**
     * Mengatur Styling Lembar Kerja Excel (Font, Warna Header, Alignment, Border)
     */
    public function styles(Worksheet $sheet)
    {
        // Ambil total baris data yang ada untuk menentukan batas border bawah
        $highestRow = $sheet->getHighestRow();

        // 1. Styling Baris Header (Baris ke-1)
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Teks Putih
                'size' => 11,
                'name' => 'Segoe UI'
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'] // Warna Brand Premium (Indigo/Ungu EMBRACE)
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ]
        ]);

        // Mengatur tinggi baris khusus untuk header agar ada space/ruang napas teks
        $sheet->getRowDimension('1')->setRowHeight(28);

        // 2. Styling Seluruh Baris Konten Data (Baris ke-2 sampai baris terakhir)
        if ($highestRow > 1) {
            // Berikan font seragam dan tipis untuk seluruh cell data
            $sheet->getStyle('A2:F' . $highestRow)->applyFromArray([
                'font' => [
                    'name' => 'Segoe UI',
                    'size' => 10,
                    'color' => ['rgb' => '1F2937'] // Abu-abu gelap (Slate) agar nyaman dibaca
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ]);

            // Set kolom skor & tanggal agar rata tengah (Center Alignment) supaya presisi
            $sheet->getStyle('B2:B' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C2:D' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E2:E' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F2:F' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Memberikan garis pembatas tipis (Border) tipis warna abu-abu elegan di setiap baris data
            $sheet->getStyle('A1:F' . $highestRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E5E7EB'], // Warna border abu-abu halus (Tailwind gray-200)
                    ],
                ],
            ]);

            // Mengatur tinggi baris data agar tidak terlalu berdempetan
            for ($row = 2; $row <= $highestRow; $row++) {
                $sheet->getRowDimension($row)->setRowHeight(22);
            }
        }

        return [];
    }
}
