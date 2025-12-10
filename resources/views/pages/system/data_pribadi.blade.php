@extends('layouts.app')

@section('title', 'Data Pribadi Staff')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Data Pribadi Staff</h4>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>TTL</th>
                    <th>No HP</th>
                    <th>Email</th>
                    <th>Status Perkawinan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($dataInduk as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->nik ?? '-' }}</td>
                    <td>{{ $d->ttl ?? '-' }}</td>
                    <td>{{ $d->no_hp ?? '-' }}</td>
                    <td>{{ $d->email ?? '-' }}</td>
                    <td>{{ $d->status_perkawinan ?? '-' }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $d->id }}">
                            <i class="ti ti-pencil me-1"></i>Edit Data Pribadi
                        </button>
                    </td>
                </tr>

                {{-- Modal Edit Data Pribadi --}}
                <div class="modal fade" id="editModal{{ $d->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('data-pribadi.update', $d->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data Pribadi - {{ $d->nama }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>TTL (Tempat, Tanggal Lahir)</label>
                                            <input type="text" name="ttl" class="form-control" value="{{ $d->ttl }}" placeholder="Jakarta, 01-01-1990">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>No HP</label>
                                            <input type="text" name="no_hp" class="form-control" value="{{ $d->no_hp }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Status Perkawinan</label>
                                            <select name="status_perkawinan" class="form-select">
                                                <option value="" hidden>Pilih Status</option>
                                                <option value="Belum Kawin" {{ $d->status_perkawinan == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                                <option value="Kawin" {{ $d->status_perkawinan == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                                <option value="Cerai Hidup" {{ $d->status_perkawinan == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                                <option value="Cerai Mati" {{ $d->status_perkawinan == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Nama Suami/Istri</label>
                                            <input type="text" name="suami_istri" class="form-control" value="{{ $d->suami_istri }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label>Alamat</label>
                                            <textarea name="alamat" class="form-control" rows="3">{{ $d->alamat }}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $d->email }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label>Keterangan</label>
                                            <textarea name="keterangan" class="form-control" rows="3">{{ $d->keterangan }}</textarea>
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

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
@endpush