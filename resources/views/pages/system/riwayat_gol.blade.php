@extends('layouts.app')

@section('title', 'Riwayat Golongan Pegawai')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Riwayat Golongan Pegawai</h4>
            {{-- kembali ke daftar riwayat --}}
            <a href="{{ route('riwayat.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        {{-- CARD DATA RIWAYAT PEGAWAI --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Data Riwayat Pegawai</h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <p><strong>Nama Staff :</strong> {{ $riwayat->staff->name ?? '-' }}</p>
                        <p><strong>Pendidikan :</strong> {{ $riwayat->pendidikan ?? '-' }}</p>
                        <p><strong>Instansi :</strong> {{ $riwayat->instansi ?? '-' }}</p>
                        <p><strong>Golongan Saat Ini :</strong> {{ $riwayat->golongan ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <strong>TMT Awal :</strong>
                            {{ $riwayat->tmt_awal ? \Carbon\Carbon::parse($riwayat->tmt_awal)->translatedFormat('d F Y') : '-' }}
                        </p>
                        <p>
                            <strong>TMT Kini :</strong>
                            {{ $riwayat->tmt_kini ? \Carbon\Carbon::parse($riwayat->tmt_kini)->translatedFormat('d F Y') : '-' }}
                        </p>
                        <p><strong>Status :</strong> {{ $riwayat->status ?? '-' }}</p>
                        <p><strong>Keterangan :</strong> {{ $riwayat->keterangan ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="card">
            <div class="card-header flex-grow-1">
                <h5 lass="fw-bold py-3 mb-4">Riwayat Golongan Staff</h5>
                <div class="d-block">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahRiwayatModal">
                    Tambah Riwayat Golongan
                </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                     <table class="table" id="table">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center" style="width: 60px;">No</th>
                                <th class="text-center">Jenis Golongan</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center" style="width: 160px;">Action</th>
                            </tr>
                        </thead>
                            <tbody>
                                @foreach ($riwayat->riwayatGolongan as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            @php
                                                $jenis = $jenis_golongan->firstWhere('jenisId', $item->jenis_golongan);
                                            @endphp
                                            {{ $jenis->jenis ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editRiwayatModal{{ $item->riwayat_gol_id }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-delete-riwayat-gol btn-sm"
                                                data-id="{{ $item->riwayat_gol_id }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Edit --}}
        @foreach ($riwayat->riwayatGolongan as $item)
            <div class="modal fade" id="editRiwayatModal{{ $item->riwayat_gol_id }}" tabindex="-1"
                 aria-labelledby="editRiwayatModalLabel{{ $item->riwayat_gol_id }}"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('riwayat_gol.update', $item->riwayat_gol_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title"
                                    id="editRiwayatModalLabel{{ $item->riwayat_gol_id }}">
                                    Edit Riwayat Golongan
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- riwayatId tetap sama, tapi dikirim hidden --}}
                                <input type="hidden" name="riwayatId" value="{{ $riwayat->riwayatId }}">

                                <div class="mb-3">
                                    <label class="form-label">Jenis Golongan</label>
                                    <select name="jenis_golongan" class="form-control" required>
                                        <option value="">-- Pilih Jenis Golongan --</option>
                                        @foreach ($jenis_golongan as $jg)
                                            <option value="{{ $jg->jenisId }}"
                                                {{ $jg->jenisId == old('jenis_golongan', $item->jenis_golongan) ? 'selected' : '' }}>
                                                {{ $jg->jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control"
                                           value="{{ old('tanggal', $item->tanggal) }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Modal Tambah --}}
        <div class="modal fade" id="tambahRiwayatModal" tabindex="-1"
             aria-labelledby="tambahRiwayatModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('riwayat_gol.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahRiwayatModalLabel">Tambah Riwayat Golongan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- kirim riwayatId hidden --}}
                            <input type="hidden" name="riwayatId" value="{{ $riwayat->riwayatId }}">

                            <div class="mb-3">
                                <label class="form-label">Jenis Golongan</label>
                                <select name="jenis_golongan" class="form-control" required>
                                    <option value="">-- Pilih Jenis Golongan --</option>
                                    @foreach ($jenis_golongan as $jg)
                                        <option value="{{ $jg->jenisId }}"
                                            {{ $jg->jenisId == old('jenis_golongan') ? 'selected' : '' }}>
                                            {{ $jg->jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"
                                       value="{{ old('tanggal') }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script>
    $(document).on('click', '.btn-delete-riwayat-gol', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "/riwayat_gol/" + id,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE"
                    },
                    success: function(response) {
                        Swal.fire('Terhapus!', response.message, 'success');
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Terjadi kesalahan', 'error');
                    }
                });

            }
        });
    });
</script>
@endpush
