<?php

namespace App\Imports;

use App\Models\DataInduk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataIndukImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataInduk([
            'no'               => $row['no'] ?? null,
            'mulai_bertugas'   => $row['mulai_bertugas'],
            'npa'              => $row['npa'],
            'nama'             => $row['nama'],
            'jenjang'          => $row['jenjang'],
            'jabatan'          => $row['jabatan'],
            'gol'              => $row['gol'],
            'status'           => $row['status'] ?? 'Aktif',
        ]);
    }
}
