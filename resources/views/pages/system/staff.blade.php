@extends('layouts.app')

@section('title', 'Data Diri Staff')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Diri Staff</h4>

        <div class="d-block mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah</button>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">Import</button>
        </div>

        {{-- Modal Tambah --}}
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('staff.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Data Staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Staff <span style="color:red">*</span></label>
                                        <input type="text" class="form-control" id="name" placeholder="Nama Lengkap"
                                            name="name" required />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control" id="nik" placeholder="Masukkan NIK"
                                            name="nik" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="birthPlace" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="birthPlace"
                                            placeholder="Masukkan Tempat Lahir" name="birthPlace" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="birthDate" class="form-label">Tanggal Lahir</label>
                                        <input type="text" class="form-control" placeholder="YYYY-MM-DD"
                                            id="birthDate" name="birthDate" />
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="noHp" class="form-label">No HP</label>
                                        <input type="text" class="form-control" id="noHp"
                                            placeholder="Masukkan nomor HP" name="noHp" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="statusPerkawinan" class="form-label">Status Perkawinan</label>
                                        <select name="statusPerkawinan" id="statusPerkawinan" class="form-select">
                                            <option value="" selected hidden>Pilih Status</option>
                                            <option value="Belum Kawin">Belum Kawin</option>
                                            <option value="Kawin">Kawin</option>
                                            <option value="Cerai Hidup">Cerai Hidup</option>
                                            <option value="Cerai Mati">Cerai Mati</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="suami_istri" class="form-label">Nama Suami/Istri</label>
                                        <input type="text" class="form-control" id="suami_istri"
                                            placeholder="Masukkan nama suami/istri" name="suami_istri" />
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email"
                                            placeholder="Masukkan email" name="email" />
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

        {{-- Modal Import --}}
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('staff.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Import Data Staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="excelFile">File (xlsx,xls) <span style="color:red">*</span></label>
                                        <input type="file" name="excelFile" id="excelFile" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <a role="button" href="{{ route('staff.template') }}"
                                            class="btn btn-warning">Download Template</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- Tabel Staff --}}
        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Staff</th>
                        <th>NIK</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Status Perkawinan</th>
                        <th>Nama Suami/Istri</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($staff as $key => $s)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->nik ?? '-' }}</td>
                            <td>{{ $s->birthPlace ?? '-' }}</td>
                            <td>{{ $s->birthDate ?? '-' }}</td>
                            <td>{{ $s->alamat ?? '-' }}</td>
                            <td>{{ $s->noHp ?? '-' }}</td>
                            <td>{{ $s->statusPerkawinan ?? '-' }}</td>
                            <td>{{ $s->suami_istri ?? '-' }}</td>
                            <td>{{ $s->email ?? '-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#infoModal{{ $s->staffId }}"><i
                                                class="ti ti-info-circle me-1"></i>Info</button>
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#updateModal{{ $s->staffId }}"><i
                                                class="ti ti-pencil me-1"></i>Edit</button>
                                        <button class="dropdown-item delete-staff"
                                            data-id="{{ $s->staffId }}"><i class="ti ti-trash me-1"></i>Delete</button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Info --}}
                        <div class="modal fade" id="infoModal{{ $s->staffId }}" tabindex="-1"
                            aria-labelledby="infoModal{{ $s->staffId }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="infoModal{{ $s->staffId }}Label">Info Data Staff</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><b>Nama :</b> {{ $s->name }}</p>
                                        <p><b>TTL :</b>
                                            {{ $s->birthPlace ?? '-' }}
                                            @if ($s->birthDate)
                                                , {{ \Carbon\Carbon::parse($s->birthDate)->translatedFormat('d F Y') }}
                                            @endif
                                        </p>
                                        <p><b>NIK :</b> {{ $s->nik ?? '-' }}</p>
                                        <p><b>Alamat :</b> {{ $s->alamat ?? '-' }}</p>
                                        <p><b>No HP :</b> {{ $s->noHp ?? '-' }}</p>
                                        <p><b>Status Perkawinan :</b> {{ $s->statusPerkawinan ?? '-' }}</p>
                                        <p><b>Suami/Istri :</b> {{ $s->suami_istri ?? '-' }}</p>
                                        <p><b>Email :</b> {{ $s->email ?? '-' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="updateModal{{ $s->staffId }}" tabindex="-1"
                            aria-labelledby="updateModal{{ $s->staffId }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('staff.update', $s->staffId) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModal{{ $s->staffId }}Label">Update Data Staff</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama <span
                                                                style="color:red">*</span></label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $s->name }}" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">NIK</label>
                                                        <input type="text" class="form-control" name="nik"
                                                            value="{{ $s->nik }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tempat Lahir</label>
                                                        <input type="text" class="form-control" name="birthPlace"
                                                            value="{{ $s->birthPlace }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Lahir</label>
                                                        <input type="text" class="form-control" name="birthDate"
                                                            value="{{ $s->birthDate }}" placeholder="YYYY-MM-DD" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat</label>
                                                        <textarea name="alamat" cols="30" rows="3" class="form-control">{{ $s->alamat }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">No HP</label>
                                                        <input type="text" class="form-control" name="noHp"
                                                            value="{{ $s->noHp }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status Perkawinan</label>
                                                        <select name="statusPerkawinan" class="form-select">
                                                            <option value="" {{ $s->statusPerkawinan == null ? 'selected' : '' }}>Pilih Status</option>
                                                            <option value="Belum Kawin" {{ $s->statusPerkawinan == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                                            <option value="Kawin" {{ $s->statusPerkawinan == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                                            <option value="Cerai Hidup" {{ $s->statusPerkawinan == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                                            <option value="Cerai Mati" {{ $s->statusPerkawinan == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Suami/Istri</label>
                                                        <input type="text" class="form-control" name="suami_istri"
                                                            value="{{ $s->suami_istri }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="{{ $s->email }}" />
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
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
        $(document).on('click', '.delete-staff', function() {
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
                        url: "/staff/" + id,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                response.message,
                                'success'
                            )
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                xhr.responseJSON?.message || 'Terjadi kesalahan',
                                'error'
                            )
                        }
                    })
                }
            })
        })
    </script>
@endpush
