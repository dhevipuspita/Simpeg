@extends('layouts.app')

@section('title', 'Data Induk')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Data Induk</h4>

    <div class="d-block mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah</button>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">Import</button>
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
                                <input type="text" name="jenjang" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gol</label>
                                <input type="text" name="gol" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="" hidden>Pilih Status</option>
                                    <option value="Aktif">Tetap</option>
                                    <option value="Tidak Aktif">KTK</option>
                                    <option value="Aktif">KHS</option>
                                    <option value="Aktif">PKDWT</option>
                                    <option value="Aktif">MGG</option>
                                    <option value="Aktif">HR</option>
                                    <option value="Aktif">TAKHFIZ</option>
                                </select>
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

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mulai Bertugas</th>
                    <th>NPA</th>
                    <th>Nama</th>
                    <th>Jenjang</th>
                    <th>Jabatan</th>
                    <th>Gol</th>
                    <th>Status</th>
                    <th>Status Pegawai</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($dataInduk as $d)

                {{-- ROW merah jika resign --}}
                <tr class="{{ $d->status_pegawai == 'resign' ? 'table-danger' : '' }}">

                    <td>{{ $loop->iteration }}</td> {{-- NOMOR OTOMATIS --}}
                    <td>{{ $d->mulai_bertugas }}</td>
                    <td>{{ $d->npa }}</td>
                    <td>{{ $d->nama }}</td>
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
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                {{-- Edit --}}
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateModal{{ $d->id }}">
                                    <i class="ti ti-pencil me-1"></i>Edit
                                </button>

                                {{-- cuti: hanya jika tidak resign --}}
                                @if($d->status_pegawai !== 'resign')
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cutiModal{{ $d->id }}">
                                        <i class="ti ti-calendar-time me-1"></i> Cuti
                                    </button>
                                @endif
                                
                                {{-- Resign --}}
                                <a class="dropdown-item" href="{{ route('resign.create', ['data_induk_id' => $d->id]) }}">
                                    <i class="ti ti-user-x me-1"></i>Resign
                                </a>

                                {{-- Hapus --}}
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
                                            <label>Jenjang</label>
                                            <input type="text" name="jenjang" class="form-control" value="{{ $d->jenjang }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Jabatan</label>
                                            <input type="text" name="jabatan" class="form-control" value="{{ $d->jabatan }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Gol</label>
                                            <input type="text" name="gol" class="form-control" value="{{ $d->gol }}">
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

                                {{-- kirim id data_induk & staff ke controller --}}
                                <input type="hidden" name="data_induk_id" value="{{ $d->id }}">
                                <input type="hidden" name="staffId" value="{{ optional($d->staff)->staffId }}">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="cutiModalLabel{{ $d->id }}">
                                        Form Cuti - {{ $d->nama }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tanggal Surat Permohonan Cuti
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="tglSurat" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tanggal Mulai Cuti
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="tglMulai" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tanggal Berakhir Cuti
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="tglAkhir" class="form-control" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Alasan Cuti
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="alasan" rows="3" class="form-control" required></textarea>
                                        </div>

                                        <hr>
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

                @endforeach
            </tbody>
        </table>
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
