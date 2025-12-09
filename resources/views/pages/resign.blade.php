@extends('layouts.app')

@section('title', 'Data Resign')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Resign Pegawai</h4>

        
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="ti ti-plus me-1"></i>Tambah Manual
            </button>

                

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

                        {{-- Modal Tambah --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('resign.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Data Resign</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Mulai Bertugas</label>
                                <input type="date" class="form-control" name="mulai_bertugas">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">NPA</label>
                                <input type="text" class="form-control" name="npa">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Golongan</label>
                                <input type="text" class="form-control" name="gol">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Jenjang</label>
                                <input type="text" class="form-control" name="jenjang">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">TTL</label>
                                <input type="text" class="form-control" name="ttl">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pendidikan</label>
                                <input type="text" class="form-control" name="pendidikan">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" rows="3" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status Kepegawaian</label>
                                <select name="status_kepegawaian" class="form-select">
                                    <option value="">Pilih Status</option>
                                    <option value="PNS">PNS</option>
                                    <option value="PPPK">PPPK</option>
                                    <option value="Honorer">Honorer</option>
                                    <option value="Kontrak">Kontrak</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Resign</label>
                                <input type="date" class="form-control" name="tanggal_resign">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Alasan Resign</label>
                                <textarea name="alasan_resign" rows="4" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Tanggal SK</label>
                                <input type="number" class="form-control" name="tgl" min="1" max="31">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Bulan SK</label>
                                <input type="number" class="form-control" name="bln" min="1" max="12">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Tahun SK</label>
                                <input type="number" class="form-control" name="thn">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">No SK</label>
                                <input type="text" class="form-control" name="no_sk">
                            </div>
                        </div>

                    </div> {{-- row --}}
                </div> {{-- modal-body --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>


                        {{-- Modal Info --}}
                        <!-- Modal Tambah Resign -->
<div class="modal fade" id="modalTambahResign" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Tambah Data Resign Pegawai</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('resign.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <!-- Jika datang dari Data Induk -->
                    @if(isset($data))
                        <input type="hidden" name="data_induk_id" value="{{ $data->id }}">

                        <div class="alert alert-info">
                            <strong>Resign Dari Data Induk:</strong><br>
                            Nama: <b>{{ $data->nama }}</b><br>
                            Jabatan: <b>{{ $data->jabatan }}</b><br>
                            Jenjang: <b>{{ $data->jenjang }}</b>
                        </div>
                    @endif

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nama Pegawai</label>
                            <input type="text" name="nama" class="form-control"
                                   value="{{ $data->nama ?? '' }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NPA</label>
                            <input type="text" name="npa" class="form-control"
                                   value="{{ $data->npa ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control"
                                   value="{{ $data->jabatan ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenjang</label>
                            <input type="text" name="jenjang" class="form-control"
                                   value="{{ $data->jenjang ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Golongan</label>
                            <input type="text" name="gol" class="form-control"
                                   value="{{ $data->gol ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai Bertugas</label>
                            <input type="date" name="mulai_bertugas" class="form-control"
                                   value="{{ $data->mulai_bertugas ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Resign</label>
                            <input type="date" name="tanggal_resign" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alasan Resign</label>
                            <textarea name="alasan_resign" class="form-control" rows="3"></textarea>
                        </div>

                    </div><!-- row -->

                </div><!-- modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Simpan Resign</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Auto Open Modal Jika Dari Data Induk -->
@if(isset($open_create_modal) && $open_create_modal)
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var modal = new bootstrap.Modal(document.getElementById('modalTambahResign'));
        modal.show();
    });
</script>
@endif


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
                                                        <label class="form-label">Golongan</label>
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