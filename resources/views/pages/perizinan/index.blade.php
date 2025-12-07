@extends('layouts.app')

@section('title', 'Data Perizinan Cuti')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Perizinan Cuti</h4>

        <div class="d-block mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                Tambah Manual
            </button>
        </div>

        <!-- Modal Tambah-->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('perizinan.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Data Perizinan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                {{-- Tanggal Surat --}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Surat Permohonan Cuti
                                            <span style="color:red">*</span>
                                        </label>
                                        <input type="date"
                                               class="form-control"
                                               name="tglSurat"
                                               id="tglSurat_tambah"
                                               required>
                                    </div>
                                </div>

                                {{-- Nama Staff --}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="staffId" class="form-label">Nama Staff
                                            <span style="color:red">*</span>
                                        </label>
                                        <select name="staffId" id="staffId" class="form-select select2" required>
                                            <option value="" selected hidden>=== Pilih Staff ===</option>
                                            @foreach ($staff as $st)
                                                <option value="{{ $st->staffId }}">
                                                    {{ $st->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- NPA --}}
                                <div class="col-md-4 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">NPA</label>
                                        <input type="text" class="form-control" name="npa" placeholder="Masukkan NPA">
                                    </div>
                                </div>

                                {{-- Jenjang --}}
                                <div class="col-md-4 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Jenjang</label>
                                        <input type="text" class="form-control" name="jenjang" placeholder="Masukkan Jenjang">
                                    </div>
                                </div>

                                {{-- Jabatan --}}
                                <div class="col-md-4 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" placeholder="Masukkan Jabatan">
                                    </div>
                                </div>

                                {{-- Tanggal Mulai Cuti --}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Mulai Cuti
                                            <span style="color:red">*</span>
                                        </label>
                                        <input type="date"
                                               class="form-control"
                                               name="tglMulai"
                                               id="tglMulai_tambah"
                                               required>
                                    </div>
                                </div>

                                {{-- Tanggal Akhir Cuti --}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Berakhir Cuti
                                            <span style="color:red">*</span>
                                        </label>
                                        <input type="date"
                                               class="form-control"
                                               name="tglAkhir"
                                               id="tglAkhir_tambah"
                                               required>
                                    </div>
                                </div>

                                {{-- Alasan Cuti --}}
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Alasan Cuti
                                            <span style="color:red">*</span>
                                        </label>
                                        <textarea name="alasan" cols="30" rows="4" class="form-control" required></textarea>
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

        {{-- Tabel Perizinan (dipendekkan kolomnya) --}}
        <div class="table-responsive mt-3">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Surat Permohonan Cuti</th>
                        <th>Nama Lengkap</th>
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
                    @foreach ($perizinan as $key => $p)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            {{-- Tgl Surat --}}
                            <td>
                                @if ($p->tglSurat)
                                    {{ \Carbon\Carbon::parse($p->tglSurat)->locale('id_ID')->translatedFormat('d F Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Nama --}}
                            <td>{{ $p->staff->name ?? $p->name ?? '-' }}</td>

                            {{-- Jenjang --}}
                            <td>{{ $p->jenjang ?? '-' }}</td>

                            {{-- Jabatan --}}
                            <td>{{ $p->jabatan ?? '-' }}</td>

                            {{-- Tgl Mulai --}}
                            <td>
                                @if ($p->tglMulai)
                                    {{ \Carbon\Carbon::parse($p->tglMulai)->locale('id_ID')->translatedFormat('d F Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Tgl Akhir --}}
                            <td>
                                @if ($p->tglAkhir)
                                    {{ \Carbon\Carbon::parse($p->tglAkhir)->locale('id_ID')->translatedFormat('d F Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Lama Cuti --}}
                            <td>{{ $p->lamaCuti ? $p->lamaCuti . ' hari' : '-' }}</td>

                            {{-- Alasan (dibatasi lebar supaya rapi) --}}
                            <td style="word-wrap: break-word; max-width: 250px;">
                                {{ $p->alasan ?? '-' }}
                            </td>

                            {{-- Status --}}
                            <td>
                                @if ($p->isComback)
                                    <span class="badge rounded-pill bg-success">Sudah Kembali</span>
                                @else
                                    <span class="badge rounded-pill bg-warning">Belum Kembali</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- Info lengkap --}}
                                        <button class="dropdown-item"
                                                data-bs-toggle="modal"
                                                data-bs-target="#infoModal{{ $p->perizinanId }}">
                                            <i class="ti ti-info-circle me-1"></i>Info
                                        </button>

                                        {{-- Tandai sudah kembali --}}
                                        @if (!$p->isComback)
                                            <button class="dropdown-item update-status"
                                                    data-id="{{ $p->perizinanId }}">
                                                <i class="ti ti-transfer-in me-1"></i>Tandai Sudah Kembali
                                            </button>
                                        @endif

                                        {{-- Edit --}}
                                        <button class="dropdown-item"
                                                data-bs-toggle="modal"
                                                data-bs-target="#updateModal{{ $p->perizinanId }}">
                                            <i class="ti ti-pencil me-1"></i>Edit
                                        </button>

                                        {{-- Delete --}}
                                        <button class="dropdown-item delete-perizinan"
                                                data-id="{{ $p->perizinanId }}">
                                            <i class="ti ti-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Info: semua data lengkap ditampilkan di sini --}}
                        <div class="modal fade" id="infoModal{{ $p->perizinanId }}" tabindex="-1"
                             aria-labelledby="infoModal{{ $p->perizinanId }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="infoModal{{ $p->perizinanId }}Label">
                                            Detail Perizinan Cuti
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @php
                                            $tglSurat = $p->tglSurat
                                                ? \Carbon\Carbon::parse($p->tglSurat)->locale('id_ID')->translatedFormat('d F Y')
                                                : '-';
                                            $tglMulai = $p->tglMulai
                                                ? \Carbon\Carbon::parse($p->tglMulai)->locale('id_ID')->translatedFormat('d F Y')
                                                : '-';
                                            $tglAkhir = $p->tglAkhir
                                                ? \Carbon\Carbon::parse($p->tglAkhir)->locale('id_ID')->translatedFormat('d F Y')
                                                : '-';
                                            $ttlText = $p->birthPlace ?? '';
                                            if ($p->birthDate) {
                                                $ttlText .= ($ttlText ? ', ' : '') .
                                                    \Carbon\Carbon::parse($p->birthDate)->locale('id_ID')->translatedFormat('d F Y');
                                            }
                                            $ttlText = $ttlText ?: '-';
                                        @endphp

                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><b>Tanggal Surat:</b> {{ $tglSurat }}</p>
                                                <p><b>Nama Lengkap:</b> {{ $p->staff->name ?? $p->name ?? '-' }}</p>
                                                <p><b>NIK:</b> {{ $p->nik ?? '-' }}</p>
                                                <p><b>NPA:</b> {{ $p->npa ?? '-' }}</p>
                                                <p><b>Tempat, Tanggal Lahir:</b> {{ $ttlText }}</p>
                                                <p><b>Alamat:</b> {{ $p->alamat ?? '-' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><b>Jenjang:</b> {{ $p->jenjang ?? '-' }}</p>
                                                <p><b>Jabatan:</b> {{ $p->jabatan ?? '-' }}</p>
                                                <p><b>Tanggal Mulai Cuti:</b> {{ $tglMulai }}</p>
                                                <p><b>Tanggal Berakhir Cuti:</b> {{ $tglAkhir }}</p>
                                                <p><b>Lama Cuti:</b> {{ $p->lamaCuti ? $p->lamaCuti . ' hari' : '-' }}</p>
                                                <p><b>Status:</b>
                                                    @if ($p->isComback)
                                                        <span class="text-success">Sudah Kembali</span>
                                                    @else
                                                        <span class="text-warning">Belum Kembali</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <p><b>Alasan Cuti:</b></p>
                                        <p>{{ $p->alasan ?? '-' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Update (Edit) --}}
                        <div class="modal fade" id="updateModal{{ $p->perizinanId }}" tabindex="-1"
                             aria-labelledby="updateModal{{ $p->perizinanId }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('perizinan.update', ['id' => $p->perizinanId]) }}"
                                          method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModal{{ $p->perizinanId }}Label">
                                                Update Data Perizinan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                {{-- Tanggal Surat --}}
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Surat Permohonan Cuti
                                                            <span style="color:red">*</span>
                                                        </label>
                                                        <input type="date"
                                                               class="form-control"
                                                               name="tglSurat"
                                                               value="{{ $p->tglSurat }}"
                                                               id="tglSurat_edit_{{ $p->perizinanId }}"
                                                               required>
                                                    </div>
                                                </div>

                                                {{-- Staff --}}
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Staff
                                                            <span style="color:red">*</span>
                                                        </label>
                                                        <select name="staffId" class="form-select">
                                                            <option value="{{ $p->staffId }}" selected hidden>
                                                                {{ $p->staff->name ?? $p->name ?? 'Pilih Staff' }}
                                                            </option>
                                                            @foreach ($staff as $st)
                                                                <option value="{{ $st->staffId }}"
                                                                    {{ $st->staffId == $p->staffId ? 'selected' : '' }}>
                                                                    {{ $st->name }}
                                                                    @if ($st->nik)
                                                                        - {{ $st->nik }}
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- NPA, Jenjang, Jabatan --}}
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">NPA</label>
                                                        <input type="text" class="form-control" name="npa"
                                                               value="{{ $p->npa }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Jenjang</label>
                                                        <input type="text" class="form-control" name="jenjang"
                                                               value="{{ $p->jenjang }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Jabatan</label>
                                                        <input type="text" class="form-control" name="jabatan"
                                                               value="{{ $p->jabatan }}">
                                                    </div>
                                                </div>

                                                {{-- Tanggal Mulai & Akhir --}}
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Mulai Cuti
                                                            <span style="color:red">*</span>
                                                        </label>
                                                        <input type="date"
                                                               class="form-control"
                                                               name="tglMulai"
                                                               id="tglMulai_edit_{{ $p->perizinanId }}"
                                                               value="{{ $p->tglMulai }}"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Berakhir Cuti
                                                            <span style="color:red">*</span>
                                                        </label>
                                                        <input type="date"
                                                               class="form-control"
                                                               name="tglAkhir"
                                                               id="tglAkhir_edit_{{ $p->perizinanId }}"
                                                               value="{{ $p->tglAkhir }}"
                                                               required>
                                                    </div>
                                                </div>

                                                {{-- Alasan --}}
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Alasan Cuti
                                                            <span style="color:red">*</span>
                                                        </label>
                                                        <textarea name="alasan" cols="30" rows="4" class="form-control" required>{{ $p->alasan }}</textarea>
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
        // Hapus
        $(document).on("click", ".delete-perizinan", function() {
            let perizinanId = $(this).data("id");
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
                        url: "/perizinan/" + perizinanId,
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

        // Update status isComback
        $(document).on("click", ".update-status", function() {
            let perizinanId = $(this).data("id");
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
                        url: "/perizinan/update-status/" + perizinanId,
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

        // Kalau pakai select2
        $(document).ready(function () {
            if ($.fn.select2) {
                $('#staffId').select2({
                    dropdownParent: $('#tambahModal'),
                    width: '100%'
                });
            }
        });
    </script>
@endpush
