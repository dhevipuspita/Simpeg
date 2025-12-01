@extends('layouts.app')

@section('title', 'Data Perizinan Cuti')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Perizinan Cuti</h4>

        <div class="d-block">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah</button>
        </div>

        <!-- Modal Tambah-->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('perizinan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Data Perizinan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Alasan Perizinan<span
                                                style="color:red">*</span></label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="santriId" class="form-label">Nama Santri <span
                                                style="color:red">*</span></label>
                                        <select name="santriId" id="santriId" class="form-select select2">
                                            <option selected hidden>=== Pilih Santri ====</option>
                                            @foreach ($santri as $s)
                                                <option value="{{ $s->santriId }}">
                                                    {{ $s->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="santriId" class="form-label">Bukti Pendukung
                                            (.jpg/.png/.jpeg/.pdf)</label>
                                        <input type="file" name="bukti" id="bukti" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="flatpickr-date" class="form-label">Tanggal Keluar<span
                                                style="color:red">*</span></label>
                                        <input type="text" class="form-control" placeholder="YYYY-MM-DD"
                                            id="flatpickr-date" name="tglKeluar" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="flatpickr-date" class="form-label">Tanggal Kembali<span
                                                style="color:red">*</span></label>
                                        <input type="text" class="form-control" placeholder="YYYY-MM-DD"
                                            id="flatpickr-date" name="tglKembali" />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Surat Permohonan Cuti</th>
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>NPA</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Jenjang</th>
                        <th>Jabatan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Berakhir</th>
                        <th>Lama Cuti</th>
                        <th>Alasan Cuti</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($permissions as $key => $p)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $p->tglSurat)->locale('id-ID')->translatedFormat('d F Y') }} </td>
                            <td>{{ $p->santri->pengurus->name }}</td>
                            <td style="world-wrap:break-world;">{{ $p->santri->name }}</td>
                            <td style="world-wrap:break-world;">{{ $p->nik }}</td>
                            <td style="world-wrap:break-world;">{{ $p->npa }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $p->ttl)->locale('id-ID')->translatedFormat('d F Y') }} </td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $p->tglKeluar)->locale('id-ID')->translatedFormat('d F Y') }} </td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $p->tglKembali)->locale('id-ID')->translatedFormat('d F Y') }} </td>
                            <td>
                                @if ($p->isComback)
                                    <span class="badge rounded-pill bg-success">Sudah Kembali</span>
                                @else
                                    <span class="badge rounded-pill bg-warning">Belum Kembali</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($p->file !== null)
                                    <button class="btn btn-primary" id="bukti-permission"
                                        data-file="{{ $p->file }}">Bukti</button>
                                @else
                                    -
                                @endif
                            </td>
                            <td style="world-wrap:break-world;">{{ $p->description }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                        @if (!$p->isComback)
                                            <button class="dropdown-item" id="update-status"
                                                data-id="{{ $p->permissionId }}"><i
                                                    class="ti ti-transfer-in me-1"></i>Santri
                                                Kembali</button>
                                        @endif

                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#updateModal{{ $p->permissionId }}"><i
                                                class="ti ti-pencil me-1"></i>Edit</button>
                                        <button class="dropdown-item" id="delete-permission"
                                            data-id="{{ $p->permissionId }}"><i
                                                class="ti ti-trash me-1"></i>Delete</button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Update-->
                        <div class="modal fade" id="updateModal{{ $p->permissionId }}" tabindex="-1"
                            aria-labelledby="updateModal{{ $p->permissionId }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('perizinan.update', ['id' => $p->permissionId]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModal{{ $p->permissionId }}Label">Update
                                                Data Perizinan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Alasan Perizinan<span
                                                                style="color:red">*</span></label>
                                                        <textarea name="description" id="description" cols="30" rows="10" class="form-control">
                                                            {{ $p->description }}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="santriId" class="form-label">Nama Santri <span
                                                                style="color:red">*</span></label>
                                                        <select name="santriId" id="santriId" class="form-select">
                                                            <option selected hidden value="{{ $p->santriId }}">
                                                                {{ $p->santri->name }}</option>
                                                            @foreach ($santri as $s)
                                                                <option value="{{ $s->santriId }}">
                                                                    {{ $s->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="santriId" class="form-label">Bukti Pendukung
                                                            (.jpg/.png/.jpeg/.pdf)</label>
                                                        <input type="file" name="bukti" id="bukti"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="flatpickr-date" class="form-label">Tanggal Keluar<span
                                                                style="color:red">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="YYYY-MM-DD" id="flatpickr-date" name="tglKeluar"
                                                            value="{{ $p->tglKeluar }}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="flatpickr-date" class="form-label">Tanggal
                                                            Kembali<span style="color:red">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="YYYY-MM-DD" id="flatpickr-date"
                                                            name="tglKembali" value="{{ $p->tglKembali }}" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
        $(document).on("click", "#bukti-permission", function() {
            let file = $(this).data("file");
            Swal.fire({
                imageUrl: `/storage/bukti/${file}`,
                imageWidth: 800,
                imageHeight: 800,
                imageAlt: "A tall image"
            });
        })

        $(document).on("click", "#delete-permission", function() {
            let permissionId = $(this).data("id");
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
                        url: "/perizinan/" + permissionId,
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire(
                                'Berhasil!',
                                res.message,
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(err) {
                            Swal.fire(
                                'Gagal!',
                                err.responseJSON.message,
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $(document).on("click", "#update-status", function() {
            let permissionId = $(this).data("id");
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data akan diubah menjadi Sudah Kembali!",
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
                        url: "/perizinan/update-status/" + permissionId,
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire(
                                'Berhasil!',
                                res.message,
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(err) {
                            Swal.fire(
                                'Gagal!',
                                err.responseJSON.message,
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endpush
