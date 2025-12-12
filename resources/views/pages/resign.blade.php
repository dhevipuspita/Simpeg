@extends('layouts.app')

@section('title', 'Data Resign')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Data Resign</h4>

    <div class="d-block mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
            Tambah Manual
        </button>
    </div>

    {{-- Modal Tambah Manual --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('resign.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Data Resign</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Resign <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal_resign" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
                                <select name="data_induk_id" class="form-select select2" required>
                                    <option value="" hidden>=== Pilih Pegawai ===</option>
                                    @foreach ($dataInduk as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama }} @if ($d->nik) - {{ $d->nik }} @endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No SK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_sk" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alasan Resign <span class="text-danger">*</span></label>
                                <textarea name="alasan_resign" rows="4" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabel Resign --}}
    <div class="table-responsive mt-3">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai Bertugas</th>
                    <th>Tanggal Resign</th>
                    <th>No SK</th>
                    <th>Alasan Resign</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($resign as $key => $r)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $r->dataInduk->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->dataInduk->mulai_bertugas)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tanggal_resign)->format('d-m-Y') }}</td>
                    <td>{{ $r->no_sk ?? '-' }}</td>
                    <td style="max-width: 250px; word-wrap: break-word;">{{ $r->alasan_resign ?? '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#infoModal{{ $r->resignId }}">
                                    <i class="ti ti-info-circle me-1"></i> Info
                                </button>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateModal{{ $r->resignId }}">
                                    <i class="ti ti-pencil me-1"></i> Edit
                                </button>
                                @if (!$r->isComback)
                                <button class="dropdown-item update-status" data-id="{{ $r->resignId }}">
                                    <i class="ti ti-transfer-in me-1"></i> Aktifkan Kembali
                                </button>
                                @endif
                                <button class="dropdown-item delete-resign" data-id="{{ $r->resignId }}">
                                    <i class="ti ti-trash me-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Modal Info --}}
                <div class="modal fade" id="infoModal{{ $r->resignId }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Data Resign</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><b>No:</b> {{ $r->resignId }}</p>
                                        <p><b>Nama:</b> {{ $r->dataInduk->nama ?? '-' }}</p>
                                        <p><b>NPA:</b> {{ $r->dataInduk->npa ?? '-' }}</p>
                                        <p><b>NIK:</b> {{ $r->dataInduk->nik ?? '-' }}</p>
                                        <p><b>Jenjang:</b> {{ $r->dataInduk->jenjang ?? '-' }}</p>
                                        <p><b>Golongan:</b> {{ $r->dataInduk->gol ?? '-' }}</p>
                                        <p><b>Jabatan:</b> {{ $r->dataInduk->jabatan ?? '-' }}</p>
                                        <p><b>Tempat, Tanggal Lahir:</b> {{ ($r->dataInduk->birthPlace ?? '-') . ', ' . ($r->dataInduk->birthDate ? \Carbon\Carbon::parse($r->dataInduk->birthDate)->translatedFormat('d F Y') : '-') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><b>Alamat:</b> {{ $r->dataInduk->alamat ?? '-' }}</p>
                                        <p><b>Pendidikan:</b> {{ $r->riwayat->pendidikan ?? '-' }}</p>
                                        <p><b>Tanggal Bertugas:</b>
                                            {{ $r->dataInduk && $r->dataInduk->mulai_bertugas
                                                ? \Carbon\Carbon::parse($r->dataInduk->mulai_bertugas)->format('d-m-Y')
                                                : '-' }}
                                        </p>
                                        <p><b>Tanggal Resign:</b>
                                            {{ $r->tanggal_resign
                                                ? \Carbon\Carbon::parse($r->tanggal_resign)->format('d-m-Y')
                                                : '-' }}
                                        </p>
                                        <p><b>No SK:</b> {{ $r->no_sk ?? '-' }}</p>
                                        <p><b>Alasan Resign:</b> {{ $r->alasan_resign ?? '-' }}</p>
                                        <p><b>Status:</b> {!! $r->isComback ? '<span class="text-success">Sudah Kembali</span>' : '<span class="text-danger">Resign</span>' !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Update --}}
                <div class="modal fade" id="updateModal{{ $r->resignId }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('resign.update', $r->resignId) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data Resign</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Resign <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_resign" class="form-control" value="{{ $r->tanggal_resign }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No SK <span class="text-danger">*</span></label>
                                        <input type="text" name="no_sk" class="form-control" value="{{ $r->no_sk }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alasan Resign <span class="text-danger">*</span></label>
                                        <textarea name="alasan_resign" class="form-control" rows="4" required>{{ $r->alasan_resign }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
    // Hapus
    $(document).on("click", ".delete-resign", function() {
        let resignId = $(this).data("id");
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/resign/" + resignId,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Swal.fire(
                            'Berhasil!',
                            res.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(err) {
                        Swal.fire(
                            'Gagal!',
                            err.responseJSON?.message || 'Terjadi kesalahan',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // Update status isComback (Aktif Kembali)
    $(document).on("click", ".update-status", function() {
        let resignId = $(this).data("id");
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Status akan diubah menjadi Aktif Kembali & pegawai kembali AKTIF!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "PUT",
                    url: "/resign/update-status/" + resignId,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Swal.fire(
                            'Berhasil!',
                            res.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(err) {
                        Swal.fire(
                            'Gagal!',
                            err.responseJSON?.message || 'Terjadi kesalahan',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // Select2
    $(document).ready(function () {
        if ($.fn.select2) {
            $('#data_induk_id').select2({
                dropdownParent: $('#tambahModal'),
                width: '100%'
            });
        }
    });
</script>
@endpush
