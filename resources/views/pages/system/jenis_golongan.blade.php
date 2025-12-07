@extends('layouts.app')

@section('title', 'Data Jenis Golongan Pegawai')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Jenis Golongan Pegawai</h4>

        <div class="d-block mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                Tambah
            </button>
        </div>

        <!-- Modal Tambah-->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('jenis.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Data Jenis Golongan Pegawai</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label">Jenis Golongan Pegawai <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jenis" placeholder="Jenis Golongan"
                                       value="{{ old('jenis') }}">
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
                        <th>Jenis Golongan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach ($jenis_golongan as $key => $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->jenis }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $k->jenisId }}">
                                    Edit
                                </button>

                                <button class="btn btn-danger btn-delete-jenis btn-sm"
                                        data-id="{{ $k->jenisId }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Update-->
                        <div class="modal fade" id="updateModal{{ $k->jenisId }}" tabindex="-1"
                            aria-labelledby="updateModal{{ $k->jenisId }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('jenis.update', ['id' => $k->jenisId]) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Data Jenis Golongan Pegawai</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label class="form-label">Jenis Golongan Pegawai <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                       name="jenis"
                                                       value="{{ $k->jenis }}">
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
    $(document).on('click', '.btn-delete-jenis', function() {
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
                    url: "/jenis/" + id,
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
