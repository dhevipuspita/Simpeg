@extends('layouts.app')

@section('title', 'Data Induk')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Data Induk Pegawai</h4>

    <div class="d-block mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah</button>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">Import</button>
    </div>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Mulai Bertugas</th>
                    <th>NPA</th>
                    <th>Jenjang</th>
                    <th>Jabatan</th>
                    <th>Gol</th>
                    <th>Status</th>
                    <th>Status Pegawai</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($dataInduk as $d)

                {{-- ROW merah jika resign, kuning jika cuti --}}
                <tr class="{{ $d->status_pegawai == 'resign' ? 'table-danger' : ($d->status_pegawai == 'cuti' ? 'table-warning' : '') }}">

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->mulai_bertugas)->format('d-m-Y') }}</td>
                    <td>{{ $d->npa }}</td>
                    <td>{{ $d->jenjang ?? '-' }}</td>
                    <td>{{ $d->jabatan ?? '-' }}</td>
                    <td>{{ $d->gol ?? '-' }}</td>
                    <td>{{ $d->status ?? '-' }}</td>
                    <td>
                        @if ($d->status_pegawai == 'resign')
                            <span class="badge bg-danger">Resign</span>
                        @elseif ($d->status_pegawai == 'cuti')
                            <span class="badge bg-warning text-dark">Cuti</span>
                        @else
                            <span class="badge bg-success">Aktif</span>
                        @endif
                    </td>
                    <td>
                        @if ($d->status_pegawai == 'resign')
                            {{ $d->resign->alasan_resign ?? '-' }}
                        @elseif ($d->status_pegawai == 'cuti')
                            {{ optional($d->perizinan->last())->alasan ?? '-' }}
                        @else
                            {{-- Aktif --}}
                            -
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateModal{{ $d->id }}">
                                    <i class="ti ti-pencil me-1"></i>Edit
                                </button>
                                @if ($d->status_pegawai === 'aktif')
                                    {{-- Cuti --}}
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cutiModal{{ $d->id }}">
                                        <i class="ti ti-calendar-time me-1"></i> Cuti
                                    </button>

                                    {{-- Resign --}}
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#resignModal{{ $d->id }}">
                                        <i class="ti ti-user-x me-1"></i> Resign
                                    </button>
                                @endif
                                <button class="dropdown-item delete-data-induk" data-id="{{ $d->id }}">
                                    <i class="ti ti-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Modal Update --}}
                <div class="modal fade" id="updateModal{{ $d->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form method="POST" action="{{ route('data-induk.update', $d->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Update Data Induk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label>Mulai Bertugas</label>
                                            <input type="date" name="mulai_bertugas" class="form-control" value="{{ $d->mulai_bertugas }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>NPA</label>
                                            <input type="text" name="npa" class="form-control" value="{{ $d->npa }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Nama</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $d->nama }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jenjang</label>
                                            <select name="jenjang" class="form-select">
                                                <option value="">-- Pilih Jenjang --</option>
                                                @foreach ($jenjang as $j)
                                                    <option value="{{ $j->nama_jenjang }}"
                                                        {{ $d->jenjang == $j->nama_jenjang ? 'selected' : '' }}>
                                                        {{ $j->nama_jenjang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Jabatan</label>
                                            <input type="text" name="jabatan" class="form-control" value="{{ $d->jabatan }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Golongan</label>
                                            <select name="gol" class="form-select">
                                                <option value="">-- Pilih Golongan --</option>
                                                @foreach ($jenis_golongan as $jg)
                                                    <option value="{{ $jg->jenis }}"
                                                        {{ $d->gol == $jg->jenis ? 'selected' : '' }}>
                                                        {{ $jg->jenis }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Status Kepegawaian</label>
                                            <select name="status" class="form-select">
                                                <option value="Aktif" {{ $d->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Tidak Aktif" {{ $d->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Modal Cuti --}}
                <div class="modal fade" id="cutiModal{{ $d->id }}" tabindex="-1" aria-labelledby="cutiModalLabel{{ $d->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('perizinan.store') }}" method="POST">
                                @csrf

                                {{-- kirim id data_induk --}}
                                <input type="hidden" name="data_induk_id" value="{{ $d->id }}">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="cutiModalLabel{{ $d->id }}">
                                        Form Cuti - {{ $d->nama }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        {{-- Tanggal Surat --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tanggal Surat Permohonan Cuti
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="tglSurat" class="form-control" required>
                                        </div>

                                        {{-- Tanggal Mulai Cuti --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tanggal Mulai Cuti
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="mulai_tanggal" class="form-control" required>
                                            {{--  ^^^^^^^^^^^^^  HARUS SAMA dengan validasi controller --}}
                                        </div>

                                        {{-- Tanggal Berakhir Cuti --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tanggal Berakhir Cuti
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="akhir_tanggal" class="form-control" required>
                                            {{--  ^^^^^^^^^^^^^  HARUS SAMA --}}
                                        </div>

                                        {{-- Alasan Cuti --}}
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Alasan Cuti
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="alasan" rows="3" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary">Simpan Cuti</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Modal Resign --}}
                <div class="modal fade" id="resignModal{{ $d->id }}" tabindex="-1" aria-labelledby="resignModalLabel{{ $d->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('resign.store') }}" method="POST">
                                @csrf
                                {{-- kirim id data_induk --}}
                                <input type="hidden" name="data_induk_id" value="{{ $d->id }}">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="resignModalLabel{{ $d->id }}">
                                        Form Resign - {{ $d->nama }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tanggal Surat Resign
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="tanggal_resign" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">No SK
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="string" name="no_sk" rows="3" class="form-control" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Alasan Resign
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="alasan_resign" rows="3" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary">Simpan Resign</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('data-induk.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Data Induk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mulai Bertugas</label>
                                <input type="date" name="mulai_bertugas" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">NPA</label>
                                <input type="text" name="npa" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenjang</label>
                                <select name="jenjang" class="form-select">
                                    <option value="">-- Pilih Jenjang --</option>
                                    @foreach ($jenjang as $j)
                                        <option value="{{ $j->nama_jenjang }}">
                                            {{ $j->nama_jenjang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Golongan</label>
                                <select name="gol" class="form-select">
                                    <option value="">-- Pilih Golongan --</option>
                                    @foreach ($jenis_golongan as $jg)
                                        <option value="{{ $jg->jenis }}">
                                            {{ $jg->jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="" hidden>Pilih Status</option>
                                    <option value="Tetap">Tetap</option>
                                    <option value="KTK">KTK</option>
                                    <option value="KHS">KHS</option>
                                    <option value="PKWT">PKDWT</option>
                                    <option value="MGG">MGG</option>
                                    <option value="HR">HR</option>
                                    <option value="TAKHFIZ">TAKHFIZ</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="birthPlace" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="birthDate" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" name="noHp" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Perkawinan</label>
                                <select class="form-select" name="statusPerkawinan">
                                    <option value="" hidden>Pilih Status</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Suami/Istri</label>
                                <input type="text" name="suami_istri" class="form-control">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
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

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('data-induk.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Induk Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label class="form-label">Pilih File (Excel)</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>

                        <small class="text-muted d-block mt-2">
                            Format file yang didukung: <b>.xlsx, .xls</b><br>
                            Pastikan kolom mengikuti template.
                        </small>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.delete-data-induk', function() {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data ini tidak dapat dipulihkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(`/data-induk/${id}`, {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            }, function(response) {
                Swal.fire('Terhapus!', response.message, 'success');
                location.reload();
            }).fail(function(xhr) {
                Swal.fire('Gagal!', xhr.responseJSON.message, 'error');
            });
        }
    });
});
</script>
@endpush
