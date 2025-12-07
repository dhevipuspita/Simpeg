@extends('layouts.app')

@section('title', 'Data Resign')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Resign Pegawai</h4>

        <div class="d-block mb-3">
            <a href="{{ route('resign.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>Tambah Manual
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NPA</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Tanggal Resign</th>
                        <th>Status</th>
                        <th>Alasan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($resign as $key => $r)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $r->npa ?? '-' }}</td>
                            <td>{{ $r->nama }}</td>
                            <td>{{ $r->jabatan ?? '-' }}</td>
                            <td>{{ $r->tanggal_resign ? \Carbon\Carbon::parse($r->tanggal_resign)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($r->status_kepegawaian)
                                    <span class="badge bg-success">{{ $r->status_kepegawaian }}</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($r->alasan_resign, 30) ?? '-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#infoModal{{ $r->id }}">
                                            <i class="ti ti-info-circle me-1"></i>Info
                                        </button>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateModal{{ $r->id }}">
                                            <i class="ti ti-pencil me-1"></i>Edit
                                        </button>
                                        <button class="dropdown-item delete-resign" data-id="{{ $r->id }}">
                                            <i class="ti ti-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Info --}}
                        <div class="modal fade" id="infoModal{{ $r->id }}" tabindex="-1" aria-labelledby="infoModal{{ $r->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="infoModal{{ $r->id }}Label">Info Data Resign</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><b>No :</b> {{ $r->no ?? '-' }}</p>
                                                <p><b>NPA :</b> {{ $r->npa ?? '-' }}</p>
                                                <p><b>Nama :</b> {{ $r->nama }}</p>
                                                <p><b>NIK :</b> {{ $r->nik ?? '-' }}</p>
                                                <p><b>Jabatan :</b> {{ $r->jabatan ?? '-' }}</p>
                                                <p><b>Golongan :</b> {{ $r->gol ?? '-' }}</p>
                                                <p><b>Jenjang :</b> {{ $r->jenjang ?? '-' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><b>TTL :</b> {{ $r->ttl ?? '-' }}</p>
                                                <p><b>Pendidikan :</b> {{ $r->pendidikan ?? '-' }}</p>
                                                <p><b>Status Kepegawaian :</b> {{ $r->status_kepegawaian ?? '-' }}</p>
                                                <p><b>Mulai Bertugas :</b> {{ $r->mulai_bertugas ? \Carbon\Carbon::parse($r->mulai_bertugas)->format('d/m/Y') : '-' }}</p>
                                                <p><b>Tanggal Resign :</b> {{ $r->tanggal_resign ? \Carbon\Carbon::parse($r->tanggal_resign)->format('d/m/Y') : '-' }}</p>
                                                <p><b>No SK :</b> {{ $r->no_sk ?? '-' }}</p>
                                                <p><b>Tanggal SK :</b> {{ $r->tgl ?? '-' }}/{{ $r->bln ?? '-' }}/{{ $r->thn ?? '-' }}</p>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <p><b>Alamat :</b> {{ $r->alamat ?? '-' }}</p>
                                                <p><b>Alasan Resign :</b><br>{{ $r->alasan_resign ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="updateModal{{ $r->id }}" tabindex="-1" aria-labelledby="updateModal{{ $r->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('resign.update', $r->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModal{{ $r->id }}Label">Update Data Resign</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">No</label>
                                                        <input type="number" class="form-control" name="no" value="{{ $r->no }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Mulai Bertugas</label>
                                                        <input type="date" class="form-control" name="mulai_bertugas" value="{{ $r->mulai_bertugas }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">NPA</label>
                                                        <input type="text" class="form-control" name="npa" value="{{ $r->npa }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" name="nama" value="{{ $r->nama }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">NIK</label>
                                                        <input type="text" class="form-control" name="nik" value="{{ $r->nik }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Jabatan</label>
                                                        <input type="text" class="form-control" name="jabatan" value="{{ $r->jabatan }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Gol</label>
                                                        <input type="text" class="form-control" name="gol" value="{{ $r->gol }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Jenjang</label>
                                                        <input type="text" class="form-control" name="jenjang" value="{{ $r->jenjang }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">TTL</label>
                                                        <input type="text" class="form-control" name="ttl" value="{{ $r->ttl }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Pendidikan</label>
                                                        <input type="text" class="form-control" name="pendidikan" value="{{ $r->pendidikan }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat</label>
                                                        <textarea name="alamat" rows="3" class="form-control">{{ $r->alamat }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status Kepegawaian</label>
                                                        <select name="status_kepegawaian" class="form-select">
                                                            <option value="">Pilih Status</option>
                                                            <option value="PNS" {{ $r->status_kepegawaian == 'PNS' ? 'selected' : '' }}>PNS</option>
                                                            <option value="PPPK" {{ $r->status_kepegawaian == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                                            <option value="Honorer" {{ $r->status_kepegawaian == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                                                            <option value="Kontrak" {{ $r->status_kepegawaian == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Resign</label>
                                                        <input type="date" class="form-control" name="tanggal_resign" value="{{ $r->tanggal_resign }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Alasan Resign</label>
                                                        <textarea name="alasan_resign" rows="4" class="form-control">{{ $r->alasan_resign }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal SK</label>
                                                        <input type="number" class="form-control" name="tgl" value="{{ $r->tgl }}" min="1" max="31">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Bulan SK</label>
                                                        <input type="number" class="form-control" name="bln" value="{{ $r->bln }}" min="1" max="12">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tahun SK</label>
                                                        <input type="number" class="form-control" name="thn" value="{{ $r->thn }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">No SK</label>
                                                        <input type="text" class="form-control" name="no_sk" value="{{ $r->no_sk }}">
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
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data resign</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-resign', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/resign/" + id,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.message, 'success')
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error')
                        }
                    })
                }
            })
        })
    </script>
@endpush