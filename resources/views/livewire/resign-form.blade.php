<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modalResign" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">{{ $isEdit ? 'Edit Resign' : 'Tambah Resign' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- PILIH PEGAWAI --}}
                    <div class="mb-3">
                        <label class="fw-bold">Pilih Pegawai</label>
                        <select wire:model="staff_id" class="form-control">
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($staffs as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->nama }} - {{ $s->nik }}
                                </option>
                            @endforeach
                        </select>
                        @error('staff_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Nama</label>
                            <input type="text" wire:model="nama" class="form-control" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">NIK</label>
                            <input type="text" wire:model="nik" class="form-control" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">NPA</label>
                            <input type="text" wire:model="npa" class="form-control" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Jabatan</label>
                            <input type="text" wire:model="jabatan" class="form-control" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Jenjang Jabatan</label>
                            <input type="text" wire:model="jenjang" class="form-control" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Tanggal Resign</label>
                            <input type="date" wire:model="tanggal_resign" class="form-control">
                            @error('tanggal_resign') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Alasan Resign</label>
                        <textarea wire:model="alasan" class="form-control"></textarea>
                        @error('alasan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                    <button wire:click="{{ $isEdit ? 'update' : 'save' }}" class="btn btn-danger">
                        {{ $isEdit ? 'Update' : 'Simpan' }}
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('openModal', () => {
        let modal = new bootstrap.Modal(document.getElementById('modalResign'));
        modal.show();
    });

    window.addEventListener('closeModal', () => {
        let modal = bootstrap.Modal.getInstance(document.getElementById('modalResign'));
        if (modal) modal.hide();
    });
</script>
