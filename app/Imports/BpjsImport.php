<?php

namespace App\Imports;

use App\Models\Bpjs;
use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class BpjsImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    public function model(array $row)
    {
        // Skip baris kosong
        if (empty($row['name']) && empty($row['staff_id'])) {
            return null;
        }

        $staffId = $this->cleanValue($row['staff_id']);
        $name = trim($row['name'] ?? '');

        if (empty($name)) {
            return null;
        }

        // PENTING: Cek apakah staff ada, kalau tidak ada BUAT BARU
        if ($staffId && is_numeric($staffId)) {
            $staff = Staff::firstOrCreate(
                ['staffId' => $staffId],
                [
                    'name' => $name,
                    // Tambahkan field lain yang required di tabel staff
                    // 'email' => 'dummy@example.com',
                    // 'position' => 'Staff',
                    // dst...
                ]
            );
            
            $staffId = $staff->staffId;
            $name = $staff->name;
        } else {
            // Kalau staffId tidak valid, set null
            $staffId = null;
        }

        return new Bpjs([
            'staffId'    => $staffId,
            'name'       => $name,
            'noBpjs'     => $this->cleanValue($row['no_bpjs'] ?? 'Tidak ikut lembaga'),
            'kjp_2p'     => $this->cleanValue($row['kjp_2p'] ?? 'Tidak ikut lembaga'),
            'kjp_3p'     => $this->cleanValue($row['kjp_3p'] ?? 'Tidak ikut lembaga'),
            'keterangan' => $row['keterangan'] ?? null,
        ]);
    }

    private function cleanValue($value)
    {
        if (empty($value)) {
            return null;
        }

        $value = (string) $value;
        
        if (strpos($value, '=') === 0) {
            return null;
        }

        return trim($value);
    }
}