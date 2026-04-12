<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACC Kesiapan Ujian</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg:          #0d1117;
            --surface:     #161b22;
            --surface-2:   #21262d;
            --border:      #30363d;
            --border-soft: rgba(48,54,61,0.6);
            --text:        #e6edf3;
            --text-muted:  #8b949e;
            --text-subtle: #6e7681;
            --accent:      #58a6ff;
            --accent-dim:  rgba(88,166,255,0.12);
            --green:       #3fb950;
            --green-dim:   rgba(63,185,80,0.12);
            --red:         #f85149;
            --red-dim:     rgba(248,81,73,0.12);
            --yellow:      #d29922;
            --yellow-dim:  rgba(210,153,34,0.12);
            --purple:      #a5d6ff;
            --radius:      10px;
            --radius-sm:   6px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 32px 16px 48px;
            color: var(--text);
            line-height: 1.5;
        }

        .wrap { width: 100%; max-width: 600px; }

        /* ── Toast alerts ── */
        .toast {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; border-radius: var(--radius-sm);
            font-size: 13.5px; font-weight: 500; margin-bottom: 12px;
            border: 1px solid;
            animation: slideIn .25s ease;
        }
        @keyframes slideIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:none; } }
        .toast-success { background: var(--green-dim);  border-color: rgba(63,185,80,.3);   color: var(--green); }
        .toast-error   { background: var(--red-dim);    border-color: rgba(248,81,73,.3);   color: var(--red); }
        .toast-icon    { font-size: 16px; flex-shrink: 0; }

        /* ── Card ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            margin-bottom: 16px;
        }

        /* ── Card header ── */
        .card-header {
            padding: 20px 24px 18px;
            border-bottom: 1px solid var(--border-soft);
            display: flex; align-items: flex-start; gap: 14px;
        }
        .card-header-icon {
            width: 40px; height: 40px; border-radius: var(--radius-sm);
            background: var(--accent-dim); border: 1px solid rgba(88,166,255,.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .card-header-text h1 {
            font-size: 16px; font-weight: 700; color: var(--text);
            line-height: 1.3; margin-bottom: 3px;
        }
        .card-header-text p { font-size: 12.5px; color: var(--text-muted); }

        /* ── My status pill ── */
        .my-status {
            padding: 12px 24px;
            border-bottom: 1px solid var(--border-soft);
            display: flex; align-items: center; justify-content: space-between;
            background: var(--surface-2);
        }
        .my-status-label { font-size: 12px; color: var(--text-subtle); }
        .my-status-label strong { color: var(--accent); font-weight: 600; }

        /* ── Badge ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600; border: 1px solid;
        }
        .badge-pending  { background: var(--yellow-dim); border-color: rgba(210,153,34,.35); color: var(--yellow); }
        .badge-approved { background: var(--green-dim);  border-color: rgba(63,185,80,.35);  color: var(--green); }
        .badge-rejected { background: var(--red-dim);    border-color: rgba(248,81,73,.35);  color: var(--red); }

        /* ── Section inside card ── */
        .section { padding: 20px 24px; border-bottom: 1px solid var(--border-soft); }
        .section:last-child { border-bottom: none; }
        .section-title {
            font-size: 11px; font-weight: 700; letter-spacing: .8px;
            text-transform: uppercase; color: var(--text-subtle);
            margin-bottom: 14px;
        }

        /* ── Key-value rows ── */
        .kv { display: flex; align-items: baseline; gap: 12px; padding: 6px 0; }
        .kv + .kv { border-top: 1px solid var(--border-soft); }
        .kv-key {
            flex-shrink: 0; width: 90px;
            font-size: 12px; color: var(--text-subtle); font-weight: 500;
        }
        .kv-val { font-size: 13.5px; color: var(--text); font-weight: 500; flex: 1; }

        /* ── Judul block ── */
        .judul-block {
            background: var(--surface-2);
            border: 1px solid var(--border-soft);
            border-left: 3px solid var(--accent);
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            padding: 12px 14px;
            font-size: 13.5px; color: var(--text); line-height: 1.65;
        }

        /* ── Softcopy status ── */
        .file-box {
            border-radius: var(--radius-sm);
            border: 1px solid;
            padding: 14px 16px;
            display: flex; align-items: center; gap: 14px;
        }
        .file-box.has-file {
            background: var(--green-dim); border-color: rgba(63,185,80,.3);
        }
        .file-box.no-file {
            background: var(--yellow-dim); border-color: rgba(210,153,34,.3);
        }
        .file-box-icon { font-size: 24px; flex-shrink: 0; }
        .file-box-body { flex: 1; min-width: 0; }
        .file-box-title { font-size: 13px; font-weight: 600; margin-bottom: 2px; }
        .file-box.has-file .file-box-title { color: var(--green); }
        .file-box.no-file  .file-box-title { color: var(--yellow); }
        .file-box-sub { font-size: 11.5px; color: var(--text-muted); }
        .file-actions { display: flex; gap: 8px; flex-shrink: 0; }
        .btn-file {
            padding: 7px 14px; border-radius: var(--radius-sm);
            font-size: 12.5px; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: opacity .15s;
            display: inline-flex; align-items: center; gap: 5px;
            border: 1px solid;
        }
        .btn-view     { background: var(--accent-dim);  border-color: rgba(88,166,255,.35); color: var(--accent); }
        .btn-download { background: var(--green-dim);   border-color: rgba(63,185,80,.35);  color: var(--green); }
        .btn-file:hover { opacity: .75; }

        /* ── Dosen ACC grid ── */
        .dosen-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .dosen-item {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            transition: border-color .2s;
        }
        .dosen-item.is-me { border-color: rgba(88,166,255,.4); background: var(--accent-dim); }
        .dosen-role { font-size: 10.5px; text-transform: uppercase; letter-spacing: .6px; color: var(--text-subtle); font-weight: 700; margin-bottom: 4px; }
        .dosen-name { font-size: 13px; color: var(--text); font-weight: 600; margin-bottom: 8px; line-height: 1.35; }

        /* ── Rejection note ── */
        .rejection-box {
            background: var(--red-dim); border: 1px solid rgba(248,81,73,.3);
            border-left: 3px solid var(--red);
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            padding: 12px 14px;
            font-size: 13.5px; color: #ffa198; line-height: 1.6;
        }

        /* ── Actions ── */
        .actions {
            padding: 20px 24px;
            display: flex; gap: 10px;
        }
        .btn-main {
            flex: 1; padding: 11px 20px; border: none; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 600; cursor: pointer;
            font-family: inherit; transition: all .2s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
        }
        .btn-approve {
            background: var(--green); color: #0d1117;
            box-shadow: 0 0 0 0 rgba(63,185,80,0);
        }
        .btn-approve:hover { background: #56d364; box-shadow: 0 4px 14px rgba(63,185,80,.35); }
        .btn-reject {
            background: var(--surface-2); color: var(--red);
            border: 1px solid rgba(248,81,73,.35);
        }
        .btn-reject:hover { background: var(--red-dim); }

        .responded-at {
            padding: 10px 24px 16px;
            font-size: 11.5px; color: var(--text-subtle); text-align: center;
        }

        /* ── Footer ── */
        .footer {
            text-align: center; font-size: 12px; color: var(--text-subtle);
            padding-top: 8px;
        }

        /* ── Modal ── */
        .modal-bg {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.65); backdrop-filter: blur(4px);
            z-index: 100; align-items: center; justify-content: center; padding: 20px;
        }
        .modal-bg.open { display: flex; }
        .modal {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px; width: 100%; max-width: 440px;
            box-shadow: 0 24px 60px rgba(0,0,0,.6);
            animation: popIn .2s ease;
        }
        @keyframes popIn { from { opacity:0; transform: scale(.96) translateY(6px); } to { opacity:1; transform: none; } }
        .modal h3 { font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
        .modal-desc { font-size: 13.5px; color: var(--text-muted); margin-bottom: 18px; line-height: 1.6; }
        .modal-desc strong { color: var(--text); }
        .modal textarea {
            width: 100%; min-height: 96px; padding: 12px 14px;
            background: var(--surface-2); border: 1px solid var(--border);
            border-radius: var(--radius-sm); color: var(--text);
            font-family: inherit; font-size: 13.5px; resize: vertical;
            outline: none; transition: border-color .2s;
        }
        .modal textarea:focus { border-color: var(--accent); }
        .modal textarea::placeholder { color: var(--text-subtle); }
        .err-msg { font-size: 12px; color: var(--red); margin-top: 6px; display: none; }
        .modal-footer { display: flex; gap: 8px; margin-top: 16px; }
        .mbtn {
            flex: 1; padding: 10px 16px; border-radius: var(--radius-sm);
            font-size: 13.5px; font-weight: 600; cursor: pointer;
            font-family: inherit; transition: all .15s;
        }
        .mbtn-cancel { background: var(--surface-2); border: 1px solid var(--border); color: var(--text-muted); }
        .mbtn-cancel:hover { background: var(--border); }
        .mbtn-confirm { background: var(--green); border: none; color: #0d1117; }
        .mbtn-confirm:hover { background: #56d364; }
        .mbtn-danger  { background: var(--red); border: none; color: #fff; }
        .mbtn-danger:hover { background: #ff7b73; }

        @media (max-width: 480px) {
            body { padding: 20px 12px 40px; }
            .card-header, .section, .actions { padding-left: 16px; padding-right: 16px; }
            .my-status { padding-left: 16px; padding-right: 16px; }
            .responded-at { padding-left: 16px; padding-right: 16px; }
            .kv-key { width: 76px; }
            .dosen-grid { grid-template-columns: 1fr; }
            .actions { flex-direction: column; }
            .file-actions { flex-direction: column; flex-shrink: 0; }
        }
    </style>
</head>
<body>
<div class="wrap">

    {{-- ── Toasts ── --}}
    @if(session('success'))
    <div class="toast toast-success">
        <span class="toast-icon">✓</span>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="toast toast-error">
        <span class="toast-icon">!</span>
        {{ session('error') }}
    </div>
    @endif
    @foreach($errors->all() as $err)
    <div class="toast toast-error">
        <span class="toast-icon">!</span>
        {{ $err }}
    </div>
    @endforeach

    {{-- ── Main Card ── --}}
    @php
        $roleLabel = match($acc->role) {
            'pembimbing_satu' => 'Pembimbing 1',
            'pembimbing_dua'  => 'Pembimbing 2',
            'penguji_satu'    => 'Penguji 1',
            'penguji_dua'     => 'Penguji 2',
            default           => $acc->role ?? '-',
        };
        $hasSoftcopy = !empty($undangan->softcopy_file_path);
    @endphp

    <div class="card">

        {{-- Header --}}
        <div class="card-header">
            <div class="card-header-icon">📋</div>
            <div class="card-header-text">
                <h1>ACC Kesiapan Ujian</h1>
                <p>Permintaan persetujuan kehadiran ujian</p>
            </div>
        </div>

        {{-- My status bar --}}
        <div class="my-status">
            <span class="my-status-label">
                Status Anda sebagai <strong>{{ $roleLabel }}</strong>
            </span>
            @if($acc->isPending())
                <span class="badge badge-pending">⏳ Menunggu</span>
            @elseif($acc->isApproved())
                <span class="badge badge-approved">✓ Disetujui</span>
            @elseif($acc->isRejected())
                <span class="badge badge-rejected">✕ Ditolak</span>
            @endif
        </div>

        {{-- Dosen identity --}}
        <div class="section">
            <div class="section-title">Identitas Anda</div>
            <div class="kv">
                <span class="kv-key">Nama</span>
                <span class="kv-val">{{ $acc->dosen->nama ?? '-' }}</span>
            </div>
            <div class="kv">
                <span class="kv-key">Peran</span>
                <span class="kv-val">{{ $roleLabel }}</span>
            </div>
        </div>

        {{-- Exam detail --}}
        <div class="section">
            <div class="section-title">Detail Ujian</div>
            <div class="kv">
                <span class="kv-key">Perihal</span>
                <span class="kv-val">{{ $undangan->perihal }}</span>
            </div>
            <div class="kv">
                <span class="kv-key">Mahasiswa</span>
                <span class="kv-val">
                    {{ $undangan->judul->mahasiswa->nama ?? '-' }}
                    <span style="color:var(--text-muted); font-size:12px; font-weight:400;">
                        &nbsp;{{ $undangan->judul->mahasiswa->npm ?? '' }}
                    </span>
                </span>
            </div>
            <div class="kv">
                <span class="kv-key">Tanggal</span>
                <span class="kv-val">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $undangan->tanggal_hari)->translatedFormat('d F Y') }}</span>
            </div>
            <div class="kv">
                <span class="kv-key">Waktu</span>
                <span class="kv-val">{{ \Carbon\Carbon::parse($undangan->waktu)->format('H:i') }} WIT</span>
            </div>
            <div class="kv">
                <span class="kv-key">Tempat</span>
                <span class="kv-val">{{ $undangan->tempat }}</span>
            </div>
        </div>

        {{-- Judul --}}
        <div class="section">
            <div class="section-title">Judul Penelitian</div>
            <div class="judul-block">{{ $undangan->judul->judul ?? '-' }}</div>
        </div>

        {{-- Softcopy / Draft --}}
        <div class="section">
            <div class="section-title">Dokumen Draft Mahasiswa</div>
            @if($hasSoftcopy)
                @php
                    $filename = basename($undangan->softcopy_file_path);
                    $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $icon     = match($ext) {
                        'pdf'          => '📄',
                        'doc', 'docx'  => '📝',
                        default        => '📎',
                    };
                    $fileUrl  = asset('storage/' . $undangan->softcopy_file_path);
                @endphp
                <div class="file-box has-file">
                    <div class="file-box-icon">{{ $icon }}</div>
                    <div class="file-box-body">
                        <div class="file-box-title">Draft telah diunggah</div>
                        <div class="file-box-sub">{{ $filename }}</div>
                    </div>
                    <div class="file-actions">
                        <a href="{{ $fileUrl }}" target="_blank" class="btn-file btn-view">
                            👁 Lihat
                        </a>
                        <a href="{{ $fileUrl }}" download="{{ $filename }}" class="btn-file btn-download">
                            ↓ Unduh
                        </a>
                    </div>
                </div>
            @else
                <div class="file-box no-file">
                    <div class="file-box-icon">📭</div>
                    <div class="file-box-body">
                        <div class="file-box-title">Draft belum diunggah</div>
                        <div class="file-box-sub">Mahasiswa belum mengunggah softcopy dokumen</div>
                    </div>
                </div>
            @endif
        </div>

        {{-- ACC status all dosen --}}
        <div class="section">
            <div class="section-title">Status ACC Dosen</div>
            <div class="dosen-grid">
                @foreach($allAcc as $item)
                @php
                    $itemRole = match($item->role) {
                        'pembimbing_satu' => 'Pembimbing 1',
                        'pembimbing_dua'  => 'Pembimbing 2',
                        'penguji_satu'    => 'Penguji 1',
                        'penguji_dua'     => 'Penguji 2',
                        default           => $item->role ?? '-',
                    };
                    $isCurrent = $item->id === $acc->id;
                @endphp
                <div class="dosen-item {{ $isCurrent ? 'is-me' : '' }}">
                    <div class="dosen-role">{{ $itemRole }}{{ $isCurrent ? ' · Anda' : '' }}</div>
                    <div class="dosen-name">{{ $item->dosen->nama ?? '-' }}</div>
                    @if($item->status === 'pending')
                        <span class="badge badge-pending">⏳ Pending</span>
                    @elseif($item->status === 'disetujui')
                        <span class="badge badge-approved">✓ Setuju</span>
                    @elseif($item->status === 'ditolak')
                        <span class="badge badge-rejected">✕ Ditolak</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        {{-- Rejection reason --}}
        @if($acc->isRejected())
        <div class="section">
            <div class="section-title">Alasan Penolakan Anda</div>
            <div class="rejection-box">{{ $acc->alasan_penolakan }}</div>
        </div>
        @endif

        {{-- Action buttons --}}
        @if($acc->isPending())
        <div class="actions">
            <button class="btn-main btn-approve" onclick="openModal('confirmModal')">
                ✓ Setuju Hadir
            </button>
            <button class="btn-main btn-reject" onclick="openModal('rejectModal')">
                ✕ Tolak
            </button>
        </div>
        @endif

        @if($acc->responded_at)
        <div class="responded-at">
            Direspon pada {{ $acc->responded_at->format('d/m/Y H:i') }}
        </div>
        @endif

    </div>{{-- /card --}}

    <div class="footer">Sistem Akademik — Universitas Doktor Husni Ingratubun Papua</div>

</div>{{-- /wrap --}}

{{-- ── Confirm Modal ── --}}
<div class="modal-bg" id="confirmModal">
    <div class="modal">
        <h3>Konfirmasi Kehadiran</h3>
        <p class="modal-desc">
            Anda akan menyatakan <strong>bersedia hadir</strong> sebagai
            <strong>{{ $roleLabel }}</strong> pada
            <strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $undangan->tanggal_hari)->translatedFormat('d F Y') }}</strong>
            pukul <strong>{{ \Carbon\Carbon::parse($undangan->waktu)->format('H:i') }} WIT</strong>.
        </p>
        <div class="modal-footer">
            <button class="mbtn mbtn-cancel" onclick="closeModal('confirmModal')">Batal</button>
            <form action="{{ route('acc.kesiapan.setujui', ['token' => $acc->token]) }}" method="POST" style="flex:1;">
                @csrf
                <button type="submit" class="mbtn mbtn-confirm" style="width:100%;">Ya, Saya Bersedia</button>
            </form>
        </div>
    </div>
</div>

{{-- ── Reject Modal ── --}}
<div class="modal-bg" id="rejectModal">
    <div class="modal">
        <h3>Tolak ACC Kesiapan</h3>
        <p class="modal-desc">Berikan alasan mengapa Anda tidak dapat hadir.</p>
        <form action="{{ route('acc.kesiapan.tolak', ['token' => $acc->token]) }}" method="POST" id="rejectForm">
            @csrf
            <textarea name="alasan_penolakan" id="alasanInput" placeholder="Tuliskan alasan penolakan…" required></textarea>
            <div class="err-msg" id="errMsg">Alasan wajib diisi.</div>
            <div class="modal-footer">
                <button type="button" class="mbtn mbtn-cancel" onclick="closeModal('rejectModal')">Batal</button>
                <button type="submit" class="mbtn mbtn-danger">Tolak ACC</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    document.querySelectorAll('.modal-bg').forEach(bg => {
        bg.addEventListener('click', e => { if (e.target === bg) bg.classList.remove('open'); });
    });

    document.getElementById('rejectForm').addEventListener('submit', function(e) {
        const v = document.getElementById('alasanInput').value.trim();
        if (!v) {
            e.preventDefault();
            document.getElementById('errMsg').style.display = 'block';
        }
    });
    document.getElementById('alasanInput').addEventListener('input', function() {
        if (this.value.trim()) document.getElementById('errMsg').style.display = 'none';
    });
</script>
</body>
</html>
