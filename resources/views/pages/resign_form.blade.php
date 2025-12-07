<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Resign Pegawai</title>
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .custom-form-container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 40px;
        }

        .custom-form-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
            border-bottom: 3px solid #5d5fef;
            padding-bottom: 15px;
        }

        .custom-form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .custom-form-group {
            flex: 1;
            min-width: 200px;
        }

        .custom-form-group.full-width {
            flex: 100%;
        }

        .custom-form-group.half-width {
            flex: 0 0 calc(50% - 10px);
        }

        .custom-form-group.third-width {
            flex: 0 0 calc(33.333% - 14px);
        }

        .custom-form-group.quarter-width {
            flex: 0 0 calc(25% - 15px);
        }

        .custom-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        .custom-label .required {
            color: #e74c3c;
            font-weight: bold;
        }

        .custom-input,
        .custom-textarea,
        .custom-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
            background: #fafafa;
        }

        .custom-input:focus,
        .custom-textarea:focus,
        .custom-select:focus {
            outline: none;
            border-color: #5d5fef;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(93, 95, 239, 0.1);
        }

        .custom-input:hover,
        .custom-textarea:hover,
        .custom-select:hover {
            border-color: #b0b0b0;
        }

        .custom-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .custom-section-title {
            font-size: 20px;
            font-weight: 700;
            margin: 40px 0 20px 0;
            padding: 10px 0;
            color: #333;
            border-left: 5px solid #5d5fef;
            padding-left: 15px;
            background: #f8f9ff;
            border-radius: 5px;
        }

        .custom-button-group {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #e0e0e0;
        }

        .custom-btn {
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .custom-btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .custom-btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .custom-btn-secondary {
            background: #95a5a6;
            color: white;
            box-shadow: 0 4px 15px rgba(149, 165, 166, 0.3);
        }

        .custom-btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

        .custom-btn:active {
            transform: translateY(0);
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .custom-form-container {
                padding: 20px;
            }

            .custom-form-row {
                flex-direction: column;
            }
            
            .custom-form-group.half-width,
            .custom-form-group.third-width,
            .custom-form-group.quarter-width {
                flex: 100%;
            }

            .custom-form-title {
                font-size: 22px;
            }

            .custom-button-group {
                flex-direction: column;
            }

            .custom-btn {
                width: 100%;
            }
        }

        /* Loading Animation */
        .custom-btn-primary:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="custom-form-container">
        <h1 class="custom-form-title">📋 Form Resign Pegawai</h1>
        
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('resign.store') }}" method="POST">
            @csrf
            
            @if($dataInduk)
                <input type="hidden" name="data_induk_id" value="{{ $dataInduk->id }}">
            @endif

            <!-- Baris 1: No, Mulai Bertugas, NPA -->
            <div class="custom-form-row">
                <div class="custom-form-group third-width">
                    <label class="custom-label">No</label>
                    <input type="number" name="no" class="custom-input" value="{{ $dataInduk->no ?? '' }}">
                </div>
                <div class="custom-form-group third-width">
                    <label class="custom-label">Mulai Bertugas</label>
                    <input type="date" name="mulai_bertugas" class="custom-input" value="{{ $dataInduk->mulai_bertugas ?? '' }}">
                </div>
                <div class="custom-form-group third-width">
                    <label class="custom-label">NPA</label>
                    <input type="text" name="npa" class="custom-input" value="{{ $dataInduk->npa ?? '' }}" placeholder="Masukkan NPA">
                </div>
            </div>

            <!-- Baris 2: Nama, NIK -->
            <div class="custom-form-row">
                <div class="custom-form-group half-width">
                    <label class="custom-label">
                        Nama <span class="required">*</span>
                    </label>
                    <input type="text" name="nama" class="custom-input" value="{{ $dataInduk->nama ?? '' }}" placeholder="Nama Lengkap" required>
                </div>
                <div class="custom-form-group half-width">
                    <label class="custom-label">NIK</label>
                    <input type="text" name="nik" class="custom-input" placeholder="Masukkan NIK">
                </div>
            </div>

            <!-- Baris 3: Jabatan, Gol, Jenjang -->
            <div class="custom-form-row">
                <div class="custom-form-group third-width">
                    <label class="custom-label">Jabatan</label>
                    <input type="text" name="jabatan" class="custom-input" value="{{ $dataInduk->jenjang_jabatan ?? '' }}" placeholder="Masukkan Jabatan">
                </div>
                <div class="custom-form-group third-width">
                    <label class="custom-label">Gol</label>
                    <input type="text" name="gol" class="custom-input" value="{{ $dataInduk->gol ?? '' }}" placeholder="Golongan">
                </div>
                <div class="custom-form-group third-width">
                    <label class="custom-label">Jenjang</label>
                    <input type="text" name="jenjang" class="custom-input" placeholder="Masukkan Jenjang">
                </div>
            </div>

            <!-- Baris 4: TTL, Pendidikan -->
            <div class="custom-form-row">
                <div class="custom-form-group half-width">
                    <label class="custom-label">TTL (Tempat Tanggal Lahir)</label>
                    <input type="text" name="ttl" class="custom-input" placeholder="Contoh: Jakarta, 01-01-1990">
                </div>
                <div class="custom-form-group half-width">
                    <label class="custom-label">Pendidikan</label>
                    <input type="text" name="pendidikan" class="custom-input" placeholder="Contoh: S1">
                </div>
            </div>

            <!-- Alamat -->
            <div class="custom-form-row">
                <div class="custom-form-group full-width">
                    <label class="custom-label">Alamat</label>
                    <textarea name="alamat" class="custom-textarea" placeholder="Masukkan alamat lengkap"></textarea>
                </div>
            </div>

            <!-- Baris 5: Status Kepegawaian, Tanggal Resign -->
            <div class="custom-form-row">
                <div class="custom-form-group half-width">
                    <label class="custom-label">Status Kepegawaian</label>
                    <select name="status_kepegawaian" class="custom-select">
                        <option value="">Pilih Status</option>
                        <option value="PNS">PNS</option>
                        <option value="PPPK">PPPK</option>
                        <option value="Honorer">Honorer</option>
                        <option value="Kontrak">Kontrak</option>
                    </select>
                </div>
                <div class="custom-form-group half-width">
                    <label class="custom-label">Tanggal Resign</label>
                    <input type="date" name="tanggal_resign" class="custom-input">
                </div>
            </div>

            <!-- Alasan Resign -->
            <div class="custom-form-row">
                <div class="custom-form-group full-width">
                    <label class="custom-label">Alasan Resign</label>
                    <textarea name="alasan_resign" class="custom-textarea" placeholder="Masukkan alasan resign"></textarea>
                </div>
            </div>

            <!-- Section Tanggal SK -->
            <h3 class="custom-section-title">📅 Tanggal SK</h3>

            <div class="custom-form-row">
                <div class="custom-form-group quarter-width">
                    <label class="custom-label">Tanggal</label>
                    <input type="number" name="tgl" class="custom-input" placeholder="01" min="1" max="31">
                </div>
                <div class="custom-form-group quarter-width">
                    <label class="custom-label">Bulan</label>
                    <input type="number" name="bln" class="custom-input" placeholder="12" min="1" max="12">
                </div>
                <div class="custom-form-group quarter-width">
                    <label class="custom-label">Tahun</label>
                    <input type="number" name="thn" class="custom-input" placeholder="2024">
                </div>
                <div class="custom-form-group quarter-width">
                    <label class="custom-label">No SK</label>
                    <input type="text" name="no_sk" class="custom-input" placeholder="Nomor SK">
                </div>
            </div>

            <!-- Buttons -->
            <div class="custom-button-group">
                <button type="submit" class="custom-btn custom-btn-primary">💾 Simpan Data Resign</button>
                <a href="{{ route('resign.index') }}" class="custom-btn custom-btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</body>
</html>