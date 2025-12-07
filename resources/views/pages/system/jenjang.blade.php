@extends('layouts.app')

@section('title', 'Data Jenjang Pegawai')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Jenjang Pegawai</h4>

        <div class="d-block mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                Tambah
            </button>
        </div>

        <!-- Modal Tambah-->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('jenjang.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Data Jenjang Pegawai</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label">Nama Jenjang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_jenjang" placeholder="Nama Jenjang"
                                       value="{{ old('nama_jenjang') }}">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
                        <th>Nama Jenjang</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach ($jenjang as $key => $j)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $j->nama_jenjang }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $j->jenjangId }}">
                                    Edit
                                </button>

                                <button class="btn btn-danger btn-delete-jenjang btn-sm"
                                        data-id="{{ $j->jenjangId }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Update-->
                        <div class="modal fade" id="updateModal{{ $j->jenjangId }}" tabindex="-1"
                            aria-labelledby="updateModal{{ $j->jenjangId }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('jenjang.update', ['id' => $j->jenjangId]) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Data Jenjang Pegawai</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label class="form-label">Nama Jenjang <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                       name="nama_jenjang"
                                                       value="{{ $j->nama_jenjang }}">
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                Save
                                            </button>
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
    $(document).on('click', '.btn-delete-jenjang', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "/jenjang/" + id,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE"
                    },
                    success: function(response) {
                        Swal.fire('Terhapus!', response.message, 'success');
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Terjadi kesalahan', 'error');
                    }
                });

            }
        });
    });
</script>
@endpush
