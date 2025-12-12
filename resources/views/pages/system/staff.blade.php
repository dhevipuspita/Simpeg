@extends('layouts.app')

@section('title', 'Data Diri Pegawai')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Data Diri Pegawai</h4>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>NIK</th>
                    <th>No HP</th>
                    <th>Status Perkawinan</th>
                    <th>Nama Suami/Istri</th>
                    <th>Alamat</th>
                    <th>Email</th>
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
                        <td>{{ $d->birthPlace ?? '-' }}</td>
                        <td>{{ $d->birthDate ?? '-' }}</td>
                        <td>{{ $d->nik ?? '-' }}</td>
                        <td>{{ $d->noHp ?? '-' }}</td>
                        <td>{{ $d->statusPerkawinan ?? '-' }}</td>
                        <td>{{ $d->suami_istri ?? '-' }}</td>
                        <td>{{ $d->alamat ?? '-' }}</td>
                        <td>{{ $d->email ?? '-' }}</td>
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
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    {{-- Edit --}}
                                    <button class="dropdown-item"
                                            data-bs-toggle="modal"
                                            data-bs-target="#updateModal{{ $d->id }}">
                                        <i class="ti ti-pencil me-1"></i>Edit
                                    </button>
                                    {{-- Hapus --}}
                                    <button class="dropdown-item delete-data-induk"
                                            data-id="{{ $d->id }}">
                                        <i class="ti ti-trash me-1"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    {{-- Modal Update --}}
                    <div class="modal fade" id="updateModal{{ $d->id }}" tabindex="-1" aria-hidden="true">
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

                                            {{-- Nama (tidak bisa diubah) --}}
                                            <div class="col-12 mb-3">
                                                <label>Nama</label>
                                                <input type="text" class="form-control" value="{{ $d->nama }}" disabled>
                                                <input type="hidden" name="nama" value="{{ $d->nama }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Tempat Lahir</label>
                                                <input type="text" name="birthPlace" class="form-control"
                                                       value="{{ $d->birthPlace }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Tanggal Lahir</label>
                                                <input type="date" name="birthDate" class="form-control"
                                                       value="{{ $d->birthDate }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>NIK</label>
                                                <input type="text" name="nik" class="form-control"
                                                       value="{{ $d->nik }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>No HP</label>
                                                <input type="text" name="noHp" class="form-control"
                                                       value="{{ $d->noHp }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Status Perkawinan</label>
                                                <input type="text" name="statusPerkawinan" class="form-control"
                                                       value="{{ $d->statusPerkawinan }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Nama Suami/Istri</label>
                                                <input type="text" name="suami_istri" class="form-control"
                                                       value="{{ $d->suami_istri }}">
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label>Alamat</label>
                                                <textarea name="alamat" class="form-control" rows="2">{{ $d->alamat }}</textarea>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control"
                                                       value="{{ $d->email }}">
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label>Keterangan</label>
                                                <textarea name="keterangan" class="form-control" rows="2">{{ $d->keterangan }}</textarea>
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
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).on('click', '.delete-data-induk', function () {
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
                }, function (response) {
                    Swal.fire('Terhapus!', response.message, 'success');
                    location.reload();
                }).fail(function (xhr) {
                    Swal.fire('Gagal!', xhr.responseJSON.message, 'error');
                });
            }
        });
    });
</script>
@endpush
