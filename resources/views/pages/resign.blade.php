@extends('layouts.app')

@section('title', 'Data Resign')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Resign Pegawai</h4>

        {{-- ========================= --}}
        {{-- BUTTON TAMBAH (LIVEWIRE) --}}
        {{-- ========================= --}}
        <button class="btn btn-danger mb-3" wire:click="$emit('openResignModal')">
            + Tambah Data Resign
        </button>

        {{-- ========================= --}}
        {{-- LIVEWIRE MODAL FORM --}}
        {{-- ========================= --}}
        @livewire('resign-form')

        {{-- ========================= --}}
        {{-- TABLE DATA RESIGN --}}
        {{-- ========================= --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar Pegawai Resign</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Jabatan</th>
                                <th>Tanggal Resign</th>
                                <th>Alasan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($resign as $i => $r)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $r->nama }}</td>
                                    <td>{{ $r->nik }}</td>
                                    <td>{{ $r->jabatan }}</td>
                                    <td>{{ $r->tanggal_resign }}</td>
                                    <td>{{ $r->alasan_resign }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm"
                                            wire:click="$emit('editResign', {{ $r->id }})">
                                            Edit
                                        </button>

                                        <button class="btn btn-danger btn-sm"
                                            wire:click="$emit('deleteResign', {{ $r->id }})">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">Belum ada data resign.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
