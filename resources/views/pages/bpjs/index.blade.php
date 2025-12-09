@extends('layouts.app')

@section('title', 'BPJS')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">BPJS</h4>

        {{-- Tombol Aksi --}}
        <div class="d-block mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                Tambah
            </button>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">
                Import
            </button>
        </div>

        {{-- Modal Tambah --}}
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('bpjs.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Data BPJS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                {{-- Nama Staff (dropdown + search) --}}
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="staffId" class="form-label">Nama Staff <span style="color:red">*</span></label>
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

                                {{-- No BPJS --}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="noBpjs" class="form-label">No BPJS</label>
                                        <input type="text" class="form-control" id="noBpjs"
                                               placeholder="Masukkan nomor BPJS" name="noBpjs" />
                                    </div>
                                </div>

                                {{-- No KJP 2P --}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="kjp_2p" class="form-label">No KJP 2P</label>
                                        <input type="text" class="form-control" id="kjp_2p"
                                               placeholder="Masukkan nomor KJP 2P" name="kjp_2p" />
                                    </div>
                                </div>

                                {{-- No KJP 3P --}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="kjp_3p" class="form-label">No KJP 3P</label>
                                        <input type="text" class="form-control" id="kjp_3p"
                                               placeholder="Masukkan nomor KJP 3P" name="kjp_3p" />
                                    </div>
                                </div>

                                {{-- Keterangan --}}
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <input type="text" class="form-control" id="keterangan"
                                               placeholder="Keterangan tambahan" name="keterangan" />
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
                    <form action="{{ route('bpjs.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Import Data BPJS</h5>
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
                                        <a role="button" href="{{ route('bpjs.template') }}"
                                           class="btn btn-warning">Download Template BPJS</a>
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

        {{-- Tabel BPJS (DataTables) --}}
        <div class="table-responsive">
            <table class="table" id="bpjs-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Staff</th>
                        <th>No BPJS</th>
                        <th>No KJP 2P</th>
                        <th>No KJP 3P</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    {{-- Data diisi oleh DataTables via AJAX --}}
                </tbody>
            </table>
        </div>

        {{-- Modal Info Global --}}
        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="infoModalLabel">Info Data BPJS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><b>Nama Staff :</b> <span id="infoNamaStaff"></span></p>
                        <p><b>No BPJS :</b> <span id="infoNoBpjs"></span></p>
                        <p><b>No KJP 2P :</b> <span id="infoKjp2p"></span></p>
                        <p><b>No KJP 3P :</b> <span id="infoKjp3p"></span></p>
                        <p><b>Keterangan :</b> <span id="infoKeterangan"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Edit Global --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Update Data BPJS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                {{-- Nama Staff (dropdown) --}}
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Staff <span style="color:red">*</span></label>
                                        <select name="staffId" id="editStaffId" class="form-select" required>
                                            <option value="" hidden>Pilih Staff</option>
                                            @foreach ($staff as $st)
                                                <option value="{{ $st->staffId }}">
                                                    {{ $st->name }}
                                                    @if($st->nik)
                                                        - {{ $st->nik }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- No BPJS --}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">No BPJS</label>
                                        <input type="text" class="form-control" name="noBpjs" id="editNoBpjs" />
                                    </div>
                                </div>

                                {{-- No KJP 2P --}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">No KJP 2P</label>
                                        <input type="text" class="form-control" name="kjp_2p" id="editKjp2p" />
                                    </div>
                                </div>

                                {{-- No KJP 3P --}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">No KJP 3P</label>
                                        <input type="text" class="form-control" name="kjp_3p" id="editKjp3p" />
                                    </div>
                                </div>

                                {{-- Keterangan --}}
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <input type="text" class="form-control" name="keterangan" id="editKeterangan" />
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

    </div>
@endsection

@push('scripts')
<script>
    let table;

    $(document).ready(function () {
        table = $('#bpjs-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('bpjs.data') }}',
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                { data: 'nama_staff', name: 'nama_staff' },
                { data: 'noBpjs', name: 'noBpjs' },
                { data: 'kjp_2p', name: 'kjp_2p' },
                { data: 'kjp_3p', name: 'kjp_3p' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item btn-info-bpjs" data-id="${row.bpjsId}">
                                        <i class="ti ti-info-circle me-1"></i>Info
                                    </button>
                                    <button class="dropdown-item btn-edit-bpjs" data-id="${row.bpjsId}">
                                        <i class="ti ti-pencil me-1"></i>Edit
                                    </button>
                                    <button class="dropdown-item delete-bpjs" data-id="${row.bpjsId}">
                                        <i class="ti ti-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        `;
                    }
                },
            ]
        });

        // Select2 tambah
        $('#staffId').select2({
            dropdownParent: $('#tambahModal'),
            width: '100%'
        });

        // Select2 edit
        $('#editStaffId').select2({
            dropdownParent: $('#editModal'),
            width: '100%'
        });
    });

    // INFO
    $(document).on('click', '.btn-info-bpjs', function () {
        const tr = $(this).closest('tr');
        const rowData = table.row(tr).data();

        $('#infoNamaStaff').text(rowData.nama_staff || '-');
        $('#infoNoBpjs').text(rowData.noBpjs || '-');
        $('#infoKjp2p').text(rowData.kjp_2p || '-');
        $('#infoKjp3p').text(rowData.kjp_3p || '-');
        $('#infoKeterangan').text(rowData.keterangan || '-');

        $('#infoModal').modal('show');
    });

    // EDIT
    $(document).on('click', '.btn-edit-bpjs', function () {
        const tr = $(this).closest('tr');
        const rowData = table.row(tr).data();

        const url = `/bpjs/${rowData.bpjsId}`;
        $('#editForm').attr('action', url);

        $('#editStaffId').val(rowData.staffId).trigger('change');
        $('#editNoBpjs').val(rowData.noBpjs && rowData.noBpjs !== 'Tidak ikut lembaga' ? rowData.noBpjs : '');
        $('#editKjp2p').val(rowData.kjp_2p && rowData.kjp_2p !== 'Tidak ikut lembaga' ? rowData.kjp_2p : '');
        $('#editKjp3p').val(rowData.kjp_3p && rowData.kjp_3p !== 'Tidak ikut lembaga' ? rowData.kjp_3p : '');
        $('#editKeterangan').val(rowData.keterangan || '');

        $('#editModal').modal('show');
    });

    // DELETE
    $(document).on('click', '.delete-bpjs', function() {
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
                    url: "/bpjs/" + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Terhapus!',
                            response.message || 'Data BPJS berhasil dihapus',
                            'success'
                        );
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Gagal!',
                            xhr.responseJSON?.message || 'Terjadi kesalahan',
                            'error'
                        );
                    }
                })
            }
        })
    });
</script>
@endpush

