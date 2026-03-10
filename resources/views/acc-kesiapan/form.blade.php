<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACC Kesiapan Ujian - Sistem Akademik</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #e2e8f0;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        .card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .header {
            text-align: center;
            margin-bottom: 32px;
        }

        .header .icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 28px;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 14px;
            color: #94a3b8;
        }

        .info-section {
            margin-bottom: 24px;
        }

        .info-section h3 {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .info-item {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.08);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item .label {
            min-width: 120px;
            font-size: 13px;
            color: #94a3b8;
            font-weight: 500;
        }

        .info-item .value {
            font-size: 14px;
            color: #e2e8f0;
            font-weight: 500;
            flex: 1;
        }

        .judul-text {
            background: rgba(99, 102, 241, 0.1);
            border-left: 3px solid #6366f1;
            padding: 12px 16px;
            border-radius: 0 8px 8px 0;
            margin-top: 8px;
            font-size: 14px;
            line-height: 1.6;
            color: #c7d2fe;
        }

        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            gap: 6px;
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .status-approved {
            background: rgba(34, 197, 94, 0.15);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        /* Alert messages */
        .alert {
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #4ade80;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #f87171;
        }

        /* Action buttons */
        .actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            flex: 1;
            padding: 14px 24px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-approve {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }

        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
        }

        .btn-reject {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-reject:hover {
            background: rgba(239, 68, 68, 0.25);
            transform: translateY(-2px);
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: #1e293b;
            border: 1px solid rgba(148, 163, 184, 0.15);
            border-radius: 16px;
            padding: 32px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        }

        .modal h3 {
            font-size: 18px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 8px;
        }

        .modal p {
            font-size: 14px;
            color: #94a3b8;
            margin-bottom: 20px;
        }

        .modal textarea {
            width: 100%;
            min-height: 100px;
            padding: 14px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 10px;
            background: rgba(15, 23, 42, 0.8);
            color: #e2e8f0;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            resize: vertical;
            outline: none;
            transition: border-color 0.3s;
        }

        .modal textarea:focus {
            border-color: #6366f1;
        }

        .modal textarea::placeholder {
            color: #475569;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        .btn-modal-cancel {
            flex: 1;
            padding: 12px;
            background: rgba(148, 163, 184, 0.1);
            border: 1px solid rgba(148, 163, 184, 0.2);
            color: #94a3b8;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .btn-modal-cancel:hover {
            background: rgba(148, 163, 184, 0.2);
        }

        .btn-modal-reject {
            flex: 1;
            padding: 12px;
            background: #ef4444;
            border: none;
            color: white;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .btn-modal-reject:hover {
            background: #dc2626;
        }

        .error-text {
            color: #f87171;
            font-size: 12px;
            margin-top: 6px;
        }

        /* Confirm modal */
        .confirm-text {
            font-size: 15px;
            color: #e2e8f0;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .btn-modal-confirm {
            flex: 1;
            padding: 12px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            color: white;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .btn-modal-confirm:hover {
            transform: translateY(-1px);
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #475569;
            margin-top: 16px;
        }

        @media (max-width: 480px) {
            .card {
                padding: 24px;
            }

            .info-item {
                flex-direction: column;
                gap: 4px;
            }

            .info-item .label {
                min-width: auto;
            }

            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="alert alert-success">
            <span>✅</span> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <span>⚠️</span> {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            <span>⚠️</span>
            @foreach($errors->all() as $error)
            {{ $error }}
            @endforeach
        </div>
        @endif

        <div class="card">
            <div class="header">
                <div class="icon">📋</div>
                <h1>ACC Kesiapan Ujian</h1>
                <p>Permintaan Persetujuan Kehadiran</p>
            </div>

            {{-- Status --}}
            <div style="text-align: center; margin-bottom: 24px;">
                @if($acc->isPending())
                <span class="status-badge status-pending">⏳ Menunggu Respon</span>
                @elseif($acc->isApproved())
                <span class="status-badge status-approved">✅ Disetujui</span>
                @elseif($acc->isRejected())
                <span class="status-badge status-rejected">❌ Ditolak</span>
                @endif
            </div>

            {{-- Informasi Dosen Penguji --}}
            <div class="info-section">
                <h3>Dosen Penguji 1</h3>
                <div class="info-item">
                    <span class="label">Nama</span>
                    <span class="value">{{ $acc->dosen->nama ?? '-' }}</span>
                </div>
            </div>

            {{-- Informasi Ujian --}}
            <div class="info-section">
                <h3>Detail Ujian</h3>
                <div class="info-item">
                    <span class="label">Perihal</span>
                    <span class="value">{{ $undangan->perihal }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Mahasiswa</span>
                    <span class="value">{{ $undangan->judul->mahasiswa->nama ?? '-' }} ({{
                        $undangan->judul->mahasiswa->npm ?? '-' }})</span>
                </div>
                <div class="info-item">
                    <span class="label">Tanggal</span>
                    <span class="value">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $undangan->tanggal_hari)->format('d
                        F Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Waktu</span>
                    <span class="value">{{ \Carbon\Carbon::parse($undangan->waktu)->format('H:i') }} WIT</span>
                </div>
                <div class="info-item">
                    <span class="label">Tempat</span>
                    <span class="value">{{ $undangan->tempat }}</span>
                </div>
            </div>

            {{-- Judul Skripsi --}}
            <div class="info-section">
                <h3>Judul</h3>
                <div class="judul-text">
                    {{ $undangan->judul->judul ?? '-' }}
                </div>
            </div>

            {{-- Alasan Penolakan (jika ditolak) --}}
            @if($acc->isRejected())
            <div class="info-section">
                <h3>Alasan Penolakan</h3>
                <div class="judul-text"
                    style="border-left-color: #ef4444; background: rgba(239,68,68,0.1); color: #fca5a5;">
                    {{ $acc->alasan_penolakan }}
                </div>
            </div>
            @endif

            {{-- Tombol Aksi (hanya jika pending) --}}
            @if($acc->isPending())
            <div class="actions">
                <button class="btn btn-approve" onclick="showConfirmModal()">
                    ✅ Setuju Hadir
                </button>
                <button class="btn btn-reject" onclick="showRejectModal()">
                    ❌ Tolak
                </button>
            </div>
            @endif

            @if($acc->isApproved() && $acc->responded_at)
            <div style="text-align: center; margin-top: 16px; font-size: 13px; color: #64748b;">
                Direspon pada: {{ $acc->responded_at->format('d/m/Y H:i') }}
            </div>
            @endif

            @if($acc->isRejected() && $acc->responded_at)
            <div style="text-align: center; margin-top: 16px; font-size: 13px; color: #64748b;">
                Ditolak pada: {{ $acc->responded_at->format('d/m/Y H:i') }}
            </div>
            @endif
        </div>

        <div class="footer">
            Sistem Akademik &mdash; Universitas Doktor Husni Ingratubun Papua
        </div>
    </div>

    {{-- Confirm Approve Modal --}}
    <div class="modal-overlay" id="confirmModal">
        <div class="modal">
            <h3>Konfirmasi Persetujuan</h3>
            <p class="confirm-text">
                Apakah Anda yakin <strong>bersedia hadir</strong> sebagai Penguji 1
                pada tanggal <strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $undangan->tanggal_hari)->format('d F
                    Y') }}</strong>
                pukul <strong>{{ \Carbon\Carbon::parse($undangan->waktu)->format('H:i') }} WIT</strong>?
            </p>
            <p style="font-size: 13px; color: #94a3b8;">
                Setelah Anda menyetujui, undangan akan otomatis dikirim ke seluruh dosen pembimbing dan penguji melalui
                WhatsApp.
            </p>
            <div class="modal-actions">
                <button class="btn-modal-cancel" onclick="hideConfirmModal()">Batal</button>
                <form action="{{ route('acc.kesiapan.setujui', ['token' => $acc->token]) }}" method="POST"
                    style="flex: 1;">
                    @csrf
                    <button type="submit" class="btn-modal-confirm" style="width: 100%;">Ya, Saya Bersedia</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div class="modal-overlay" id="rejectModal">
        <div class="modal">
            <h3>Tolak ACC Kesiapan Ujian</h3>
            <p>Silakan berikan alasan mengapa Anda tidak dapat hadir pada ujian ini.</p>
            <form action="{{ route('acc.kesiapan.tolak', ['token' => $acc->token]) }}" method="POST" id="rejectForm">
                @csrf
                <textarea name="alasan_penolakan" placeholder="Tuliskan alasan penolakan..." required
                    id="alasanInput"></textarea>
                <div class="error-text" id="errorText" style="display: none;">Alasan penolakan wajib diisi.</div>
                <div class="modal-actions">
                    <button type="button" class="btn-modal-cancel" onclick="hideRejectModal()">Batal</button>
                    <button type="submit" class="btn-modal-reject">Tolak ACC</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showConfirmModal() {
            document.getElementById('confirmModal').classList.add('active');
        }

        function hideConfirmModal() {
            document.getElementById('confirmModal').classList.remove('active');
        }

        function showRejectModal() {
            document.getElementById('rejectModal').classList.add('active');
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.remove('active');
        }

        // Close modal on overlay click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function (e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });

        // Validate reject form
        document.getElementById('rejectForm').addEventListener('submit', function (e) {
            const alasan = document.getElementById('alasanInput').value.trim();
            if (!alasan) {
                e.preventDefault();
                document.getElementById('errorText').style.display = 'block';
            }
        });
    </script>
</body>

</html>