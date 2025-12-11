<div class="container-xxl flex-grow-1 container-p-y">
    {{-- Row kartu ringkasan --}}
    <div class="row g-4 mb-4">
        {{-- Total Pegawai --}}
        <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Pegawai</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $countStaff }}</h4>
                            </div>
                            <span>Total Staff Terdaftar</span>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-user ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Jenjang</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $countJenjang }}</h4>
                            </div>
                            <span>Total Jenjang </span>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-user ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pegawai Keluar --}}
        <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Pegawai Resign </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $staffKeluar }}</h4>
                            </div>
                            <span>Total Pegawai yang Resign </span>
                        </div>
                        <span class="badge bg-label-danger rounded p-2">
                            <i class="ti ti-user-minus ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pegawai Izin --}}
        <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Pegawai Izin </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $staffIzin }}</h4>
                            </div>
                            <span>Perizinan aktif (belum kembali)</span>
                        </div>
                        <span class="badge bg-label-danger rounded p-2">
                            <i class="ti ti-user-minus ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Staff Kembali --}}
        <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Pegawai Kembali</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $staffKembali }}</h4>
                            </div>
                            <span>Perizinan yang sudah selesai</span>
                        </div>
                        <span class="badge bg-label-success rounded p-2">
                            <i class="ti ti-user-check ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row log perizinan --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h5 class="card-title m-0 me-2 pt-1 mb-1">Log Perizinan Pegawai</h5>
                        <small class="text-muted">3 perizinan terakhir yang tercatat</small>
                    </div>
                </div>

                <div class="card-body pb-0">
                    @if ($latestPerizinan->count() > 0)
                        <ul class="timeline ms-1 mb-0">
                            @foreach ($latestPerizinan as $key => $lp)
                                @php
                                    $tglMulai = $lp->mulai_tanggal
                                        ? \Carbon\Carbon::parse($lp->mulai_tanggal)->locale('id_ID')->translatedFormat('d F Y')
                                        : '-';
                                    $tglAkhir = $lp->akhir_tanggal
                                        ? \Carbon\Carbon::parse($lp->akhir_tanggal)->locale('id_ID')->translatedFormat('d F Y')
                                        : '-';
                                @endphp

                                <li class="timeline-item timeline-item-transparent ps-4">
                                    @if ($key == 0)
                                        <span class="timeline-point timeline-point-primary"></span>
                                    @elseif ($key == 1)
                                        <span class="timeline-point timeline-point-danger"></span>
                                    @else
                                        <span class="timeline-point timeline-point-success"></span>
                                    @endif

                                    <div class="timeline-event">
                                        <div class="timeline-header">
                                            <h6 class="mb-0">
                                                {{ $lp->dataInduk->nama ?? '-' }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ $lp->created_at?->diffForHumans() }}
                                            </small>
                                        </div>

                                        <p class="mb-2">
                                            Cuti dari <strong>{{ $tglMulai }}</strong>
                                            sampai <strong>{{ $tglAkhir }}</strong><br>
                                            Alasan: {{ $lp->alasan ?? '-' }}
                                        </p>

                                        <small class="text-muted">
                                            Status:
                                            @if ($lp->isComback)
                                                <span class="text-success">Sudah kembali</span>
                                            @else
                                                <span class="text-danger">Belum kembali</span>
                                            @endif
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-3">Belum ada data perizinan terbaru.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
