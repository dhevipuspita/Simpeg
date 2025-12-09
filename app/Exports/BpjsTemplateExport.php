<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BpjsTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'staff_id',   // isi dengan staffId dari tabel staff (boleh dikosongi)
            'name',       // opsional, nama staff
            'no_bpjs',
            'kjp_2p',
            'kjp_3p',
            'keterangan',
        ];
    }

    public function array(): array
    {
        // contoh baris dummy, boleh dihapus / dibiarkan
        return [
            [
                'staff_id'   => 1,
                'name'       => 'Contoh Nama Staff',
                'no_bpjs'    => '1234567890',
                'kjp_2p'     => 'KJP2P-001',
                'kjp_3p'     => 'KJP3P-001',
                'keterangan' => 'Keterangan contoh',
            ],
        ];
    }
}
