@extends('layouts.app')

@section('title', 'Data Riwayat Pegawai')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4">Data Riwayat Pegawai</h4>

    <div class="d-block mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
            Tambah Riwayat
        </button>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="tambahModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('riwayat.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Riwayat Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Pilih Pegawai <span class="text-danger">*</span></label>
                                <select name="data_induk_id" class="form-select" required>
                                    <option value="" hidden>Pilih Pegawai</option>
                                    @foreach($dataInduk as $d)
                                        <option value="{{ $d->id }}">
                                            {{ $d->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Pendidikan</label>
                                <select name="pendidikan" class="form-select">
                                    <option hidden>Pilih Pendidikan</option>
                                    @foreach(['SD','SMP','SMA','D1','D3','D4','S1','S2','S3'] as $p)
                                        <option value="{{ $p }}">{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Instansi</label>
                                <input type="text" name="instansi" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>TMT Awal</label>
                                <input type="date" name="tmt_awal" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Golongan</label>
                                <select name="golongan" class="form-select">
                                    <option hidden>Pilih Golongan</option>
                                    @foreach($jenis_golongan as $jg)
                                        <option value="{{ $jg->jenisId }}">{{ $jg->jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>TMT Terkini</label>
                                <input type="date" name="tmt_kini" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Riwayat Jabatan</label>
                                <select name="riwayat_jabatan" class="form-select">
                                    <option value="0">Tetap pada amanahnya</option>
                                    <option value="1">Pernah pindah tugas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Pendidikan</th>
                    <th>Instansi</th>
                    <th>TMT Awal</th>
                    <th>Golongan</th>
                    <th>TMT Golongan</th>
                    <th>Riwayat Golongan</th>
                    <th>Riwayat Jabatan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($riwayat as $key => $r)
                <tr class="text-center">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $r->dataInduk->nama ?? '-' }}</td>
                    <td>{{ $r->pendidikan ?? '-' }}</td>
                    <td>{{ $r->instansi ?? '-' }}</td>
                    <td>{{ $r->tmt_awal ?? '-' }}</td>
                    @php $latestGol = $r->latestRiwayatGolongan; @endphp
                    <td>
                        {{ $latestGol?->jenisGolongan?->jenis 
                            ?? $r->jenisGolongan?->jenis 
                            ?? '-' }}
                    </td>
                    <td>
                        @if ($latestGol?->tanggal)
                            {{ \Carbon\Carbon::parse($latestGol->tanggal)->translatedFormat('d F Y') }}
                        @elseif ($r->tmt_kini)
                            {{ \Carbon\Carbon::parse($r->tmt_kini)->translatedFormat('d F Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('riwayat.golongan', $r->riwayatId) }}" class="btn btn-warning btn-sm">Selengkapnya</a>
                    </td>
                    <td>
                        @if ($r->riwayat_jabatan == 1)
                            <a href="{{ route('riwayat.jabatan', $r->riwayatId) }}" class="btn btn-info btn-sm">Selengkapnya</a>
                        @else
                            Tetap pada amanahnya
                        @endif
                    </td>
                    <td>
                            @if ($d->status_pegawai == 'resign')
                                <span class="badge bg-danger">Resign</span>
                            @elseif ($d->status_pegawai == 'cuti')
                                <span class="badge bg-warning text-dark">Cuti</span>
                            @else
                                <span class="badge bg-success">Aktif</span>
                            @endif
                        </td>
                    <td>{{ $r->keterangan ?? '-' }}</td>

                    <td>
                        <div class="dropdown">
                            <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $r->riwayatId }}">
                                    <i class="ti ti-pencil me-2"></i> Edit
                                </button>
                                <button class="dropdown-item delete-riwayat" data-id="{{ $r->riwayatId }}">
                                    <i class="ti ti-trash me-2"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>

                </tr>

                {{-- Modal Edit --}}
                <div class="modal fade" id="editModal{{ $r->riwayatId }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('riwayat.update', $r->riwayatId) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Riwayat Pegawai</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        {{-- Pegawai --}}
                                        <div class="col-md-12 mb-3">
                                            <label>Pilih Pegawai</label>
                                            <select name="data_induk_id" class="form-select">
                                                @foreach($dataInduk as $d)
                                                    <option value="{{ $d->id }}"
                                                        {{ $d->id == $r->data_induk_id ? 'selected' : '' }}>
                                                        {{ $d->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Pendidikan --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Pendidikan</label>
                                            <select name="pendidikan" class="form-select">
                                                @foreach(['SD','SMP','SMA','D1','D3','D4','S1','S2','S3'] as $p)
                                                    <option value="{{ $p }}" 
                                                        {{ $r->pendidikan == $p ? 'selected' : '' }}>
                                                        {{ $p }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Instansi --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Instansi</label>
                                            <input type="text" name="instansi" class="form-control" value="{{ $r->instansi }}">
                                        </div>

                                        {{-- TMT Awal --}}
                                        <div class="col-md-6 mb-3">
                                            <label>TMT Awal</label>
                                            <input type="date" name="tmt_awal" class="form-control" value="{{ $r->tmt_awal }}">
                                        </div>

                                        {{-- Golongan --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Golongan</label>
                                            <select name="golongan" class="form-select">
                                                @foreach($jenis_golongan as $jg)
                                                    <option value="{{ $jg->jenisId }}"
                                                        {{ $jg->jenisId == $r->golongan ? 'selected' : '' }}>
                                                        {{ $jg->jenis }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- TMT Kini --}}
                                        <div class="col-md-6 mb-3">
                                            <label>TMT Terkini</label>
                                            <input type="date" name="tmt_kini" class="form-control" value="{{ $r->tmt_kini }}">
                                        </div>

                                        {{-- Riwayat Jabatan --}}
                                        <div class="col-md-12 mb-3">
                                            <label>Riwayat Jabatan</label>
                                            <select name="riwayat_jabatan" class="form-select">
                                                <option value="0" {{ $r->riwayat_jabatan == 0 ? 'selected' : '' }}>Tetap</option>
                                                <option value="1" {{ $r->riwayat_jabatan == 1 ? 'selected' : '' }}>Pernah pindah tugas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-primary">Simpan</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.delete-riwayat', function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Hapus Riwayat?',
        text: "Data ini tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (result.isConfirmed) {

            $.post("/riwayat/" + id, {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            })
            .done(res => {
                Swal.fire('Berhasil!', res.message, 'success');
                location.reload();
            })
            .fail(() => {
                Swal.fire('Gagal!', 'Terjadi kesalahan', 'error');
            });
        }
    });
});
</script>
@endpush
