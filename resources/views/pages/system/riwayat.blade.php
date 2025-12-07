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
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
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
                            {{-- Staff --}}
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Staff <span style="color:red">*</span></label>
                                    <select name="staffId" class="form-select" required>
                                        <option value="" hidden>Pilih Staff</option>
                                        @foreach($staff as $st)
                                            <option value="{{ $st->staffId }}">{{ $st->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Pendidikan --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Pendidikan</label>
                                    <select name="pendidikan" class="form-select">
                                        <option value="" hidden>Pilih Pendidikan</option>
                                        <option value="SD"  {{ old('pendidikan') == 'SD'  ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="D1"  {{ old('pendidikan') == 'D1'  ? 'selected' : '' }}>D1</option>
                                        <option value="D3"  {{ old('pendidikan') == 'D3'  ? 'selected' : '' }}>D3</option>
                                        <option value="D4"  {{ old('pendidikan') == 'D4'  ? 'selected' : '' }}>D4</option>
                                        <option value="S1"  {{ old('pendidikan') == 'S1'  ? 'selected' : '' }}>S1</option>
                                        <option value="S2"  {{ old('pendidikan') == 'S2'  ? 'selected' : '' }}>S2</option>
                                        <option value="S3"  {{ old('pendidikan') == 'S3'  ? 'selected' : '' }}>S3</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Instansi --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Instansi</label>
                                    <input type="text" class="form-control" name="instansi">
                                </div>
                            </div>
                            
                            {{-- TMT Awal --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>TMT Awal</label>
                                    <input type="date" class="form-control" name="tmt_awal">
                                </div>
                            </div>

                            {{-- Golongan --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Golongan</label>
                                    <input type="text" class="form-control" name="golongan">
                                </div>
                            </div>

                            {{-- TMT Kini (tmt_kini) --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>TMT Terkini</label>
                                    <input type="date" class="form-control" name="tmt_kini">
                                </div>
                            </div>

                            {{-- Riwayat Jabatan (0/1) --}}
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Riwayat Jabatan</label>
                                    <select name="riwayat_jabatan" class="form-select" required>
                                        <option value="0" selected>Tetap pada amanahnya</option>
                                        <option value="1">Pernah pindah tugas</option>
                                    </select>
                                    <small class="text-muted">
                                        Pilih "Pernah pindah tugas" jika pegawai pernah mengalami perpindahan jabatan.
                                    </small>
                                </div>
                            </div>
                            
                            {{-- Status --}}
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Status</label>
                                    <input type="text" class="form-control" name="status">
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Staff</th>
                    <th class="text-center">Pendidikan</th>
                    <th class="text-center">Instansi</th>
                    <th class="text-center">TMT Awal</th>
                    <th class="text-center">Golongan</th>
                    <th class="text-center">TMT Golongan</th>
                    <th class="text-center">Riwayat Golongan</th>
                    <th class="text-center">Riwayat Jabatan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($riwayat as $key => $r)
                <tr class="text-center">
                    <td class="w-auto">{{ $key + 1 }}</td>
                    <td>{{ $r->staff->name ?? '-' }}</td>
                    <td>{{ $r->pendidikan ?? '-' }}</td>
                    <td>{{ $r->instansi ?? '-' }}</td>
                    <td>{{ $r->tmt_awal ?? '-' }}</td>
                    <td>{{ $r->golongan ?? '-' }}</td>
                    <td>{{ $r->tmt_kini ?? '-' }}</td>
                    <td>
                        <a href="{{ route('riwayat.golongan', $r->riwayatId) }}" class="btn btn-sm btn-warning">
                            Selengkapnya
                        </a>
                    </td>
                    <td>
                        @if ($r->riwayat_jabatan == 1)
                            <a href="{{ route('riwayat_gol.index', $r->staffId) }}" class="btn btn-sm btn-info">
                                Selengkapnya
                            </a>
                        @else
                            <span>Tetap pada amanahnya</span>
                        @endif
                    </td>
                    <td>{{ $r->status ?? '-' }}</td>
                    <td>{{ $r->keterangan ?? '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $r->riwayatId }}">
                                    <i class="ti ti-pencil me-2"></i>Edit
                                </button>
                                <button class="dropdown-item delete-riwayat"
                                    data-id="{{ $r->riwayatId }}">
                                    <i class="ti ti-trash me-2"></i>Delete
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Modal Info --}}
                {{-- <div class="modal fade" id="infoModal{{ $r->riwayatId }}">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Info Riwayat Pegawai</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <p><b>Nama Staff:</b> {{ $r->staff->name ?? '-' }}</p>
                                <p><b>Pendidikan:</b> {{ $r->pendidikan ?? '-' }}</p>
                                <p><b>Instansi:</b> {{ $r->instansi ?? '-' }}</p>
                                <p><b>Golongan:</b> {{ $r->golongan ?? '-' }}</p>
                                <p><b>TMT Golongan:</b> {{ $r->tmt_kini ?? '-' }}</p>
                                <p><b>TMT Awal:</b> {{ $r->tmt_awal ?? '-' }}</p>
                                <p><b>Status:</b> {{ $r->status ?? '-' }}</p>
                                <p><b>Riwayat Jabatan:</b>
                                    {{ $r->riwayat_jabatan == 1 ? 'Pernah pindah tugas' : 'Tetap pada amanahnya' }}
                                </p>
                                <p><b>Keterangan:</b> {{ $r->keterangan ?? '-' }}</p>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div> --}}

                {{-- Modal Edit --}}
                <div class="modal fade" id="editModal{{ $r->riwayatId }}">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form action="{{ route('riwayat.update', $r->riwayatId) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Riwayat Pegawai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label>Pilih Staff</label>
                                            <select name="staffId" class="form-select">
                                                @foreach($staff as $st)
                                                    <option value="{{ $st->staffId }}"
                                                        {{ $st->staffId == $r->staffId ? 'selected' : '' }}>
                                                        {{ $st->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Pendidikan --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Pendidikan</label>
                                            <select name="pendidikan" class="form-select">
                                                <option value="" hidden>Pilih Pendidikan</option>
                                                <option value="SD"  {{ old('pendidikan', $r->pendidikan) == 'SD'  ? 'selected' : '' }}>SD</option>
                                                <option value="SMP" {{ old('pendidikan', $r->pendidikan) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                                <option value="SMA" {{ old('pendidikan', $r->pendidikan) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                                <option value="D1"  {{ old('pendidikan', $r->pendidikan) == 'D1'  ? 'selected' : '' }}>D1</option>
                                                <option value="D3"  {{ old('pendidikan', $r->pendidikan) == 'D3'  ? 'selected' : '' }}>D3</option>
                                                <option value="D4"  {{ old('pendidikan', $r->pendidikan) == 'D4'  ? 'selected' : '' }}>D4</option>
                                                <option value="S1"  {{ old('pendidikan', $r->pendidikan) == 'S1'  ? 'selected' : '' }}>S1</option>
                                                <option value="S2"  {{ old('pendidikan', $r->pendidikan) == 'S2'  ? 'selected' : '' }}>S2</option>
                                                <option value="S3"  {{ old('pendidikan', $r->pendidikan) == 'S3'  ? 'selected' : '' }}>S3</option>
                                            </select>
                                        </div>

                                        {{-- Instansi --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Instansi</label>
                                            <input type="text" class="form-control" name="instansi"
                                                value="{{ $r->instansi }}">
                                        </div>

                                         {{-- TMT Awal --}}
                                        <div class="col-md-6 mb-3">
                                            <label>TMT Awal</label>
                                            <input type="date" class="form-control" name="tmt_awal"
                                                value="{{ $r->tmt_awal }}">
                                        </div>

                                        {{-- Golongan --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Golongan</label>
                                            <input type="text" class="form-control" name="golongan"
                                                value="{{ $r->golongan }}">
                                        </div>

                                        {{-- TMT Golongan (tmt_kini) --}}
                                        <div class="col-md-6 mb-3">
                                            <label>TMT Terkini</label>
                                            <input type="date" class="form-control" name="tmt_kini"
                                                value="{{ $r->tmt_kini }}">
                                        </div>

                                        {{-- Riwayat Jabatan 0/1 --}}
                                        <div class="col-md-12 mb-3">
                                            <label>Riwayat Jabatan</label>
                                            <select name="riwayat_jabatan" class="form-select" required>
                                                <option value="0" {{ $r->riwayat_jabatan == 0 ? 'selected' : '' }}>
                                                    Tetap pada amanahnya
                                                </option>
                                                <option value="1" {{ $r->riwayat_jabatan == 1 ? 'selected' : '' }}>
                                                    Pernah pindah tugas
                                                </option>
                                            </select>
                                        </div>

                                        {{-- Status --}}
                                        <div class="col-md-12 mb-3">
                                            <label>Status</label>
                                            <input type="text" class="form-control" name="status"
                                                value="{{ $r->status }}">
                                        </div>

                                        {{-- Keterangan --}}
                                        <div class="col-md-12 mb-3">
                                            <label>Keterangan</label>
                                            <textarea name="keterangan" class="form-control" rows="3">{{ $r->keterangan }}</textarea>
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
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (result.isConfirmed) {

            $.ajax({
                url: "/riwayat/" + id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: res => {
                    Swal.fire('Berhasil!', res.message, 'success');
                    location.reload();
                },
                error: err => {
                    Swal.fire('Gagal!', 'Terjadi kesalahan', 'error');
                }
            });

        }
    });
});
</script>
@endpush
