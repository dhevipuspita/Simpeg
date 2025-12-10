<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DataInduk;
use App\Models\Resign;

class ResignForm extends Component
{
    public $pegawaiList = [];
    public $selectedPegawai = null;

    public $source;
    public $data_induk_id;

    // Field
    public $nama, $nik, $npa, $jabatan, $gol, $jenjang, $ttl, $alamat;
    public $tanggal_resign, $alasan_resign;

    public function mount()
    {
        // Ambil DataInduk
        $dataInduk = DataInduk::all()->map(function ($d) {
            return [
                'id' => 'di-' . $d->id,
                'nama' => $d->nama,
                'nik' => $d->nik,
                'npa' => $d->npa,
                'jabatan' => $d->jabatan,
                'gol' => $d->gol,
                'jenjang' => $d->jenjang,
                'ttl' => $d->ttl,
                'alamat' => $d->alamat,
                'source' => 'data_induk'
            ];
        });


        $this->pegawaiList = $dataInduk->toArray();
    }

    public function updatedSelectedPegawai($id)
    {
        $pegawai = collect($this->pegawaiList)->firstWhere('id', $id);

        if (!$pegawai) return;

        $this->source = $pegawai["source"];

        if ($pegawai["source"] === "data_induk") {
            $this->data_induk_id = str_replace("di-", "", $pegawai["id"]);
        }

        // Autofill
        $this->nama = $pegawai["nama"];
        $this->nik = $pegawai["nik"];
        $this->npa = $pegawai["npa"];
        $this->jabatan = $pegawai["jabatan"];
        $this->gol = $pegawai["gol"];
        $this->jenjang = $pegawai["jenjang"];
        $this->ttl = $pegawai["ttl"];
        $this->alamat = $pegawai["alamat"];
    }

    public function submit()
    {
        $this->validate([
            'nama' => 'required',
            'tanggal_resign' => 'required',
        ]);

        $resign = Resign::create([
            'data_induk_id' => $this->data_induk_id,
            'source' => $this->source,
            'nama' => $this->nama,
            'nik' => $this->nik,
            'npa' => $this->npa,
            'jabatan' => $this->jabatan,
            'gol' => $this->gol,
            'jenjang' => $this->jenjang,
            'ttl' => $this->ttl,
            'alamat' => $this->alamat,
            'tanggal_resign' => $this->tanggal_resign,
            'alasan_resign' => $this->alasan_resign,
        ]);

        // Update Data Induk → status resign
        if ($this->source === "data_induk") {
            DataInduk::where("id", $this->data_induk_id)->update([
                "status_pegawai" => "resign"
            ]);
        }

        session()->flash('success', 'Data resign berhasil disimpan!');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.resign-form');
    }
}
