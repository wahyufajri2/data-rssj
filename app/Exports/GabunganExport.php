<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GabunganExport implements WithMultipleSheets
{
    use Exportable;

    protected $ranting_id;
    protected $periode_id;

    public function __construct($ranting_id = null, $periode_id = null)
    {
        $this->ranting_id = $ranting_id;
        $this->periode_id = $periode_id;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new PendataanExport($this->ranting_id, $this->periode_id);
        $sheets[] = new KuesionerExport($this->ranting_id, $this->periode_id);

        return $sheets;
    }
}
