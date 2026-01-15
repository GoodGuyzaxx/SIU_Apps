<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Undangan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            text-align: justify;
            margin-right: 20px;
            margin-left: 20px;
            line-height: 1.3;
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: -10px;
        }

        .header img {
            max-width: 100%;
        }

        /* Letter Details */
        .letter-header {
            margin-bottom: 5px;
        }

        .letter-row {
            margin-bottom: 3px;
        }

        .letter-label {
            width: 70px;
            display: inline-block;
        }

        .letter-separator {
            width: 20px;
            display: inline-block;
        }

        /* Recipient Section */
        .recipient-section {
            margin: 10px 0;
            text-align: start;
        }

        .recipient-section table,td,th {
            /*border: 1px solid black;*/
            vertical-align: top;
        }

        .recipient-title {
            margin-bottom: 5px;
        }

        .recipient-list {
            margin-left: 0;
            list-style: none;
        }

        .recipient-list li {
            margin-bottom: 3px;
        }

        .recipient-location {
            margin-top: 5px;
            margin-left: 0;
        }

        /* Greeting */
        .greeting {
            /*margin: 20px 0;*/
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: justify;
            text-indent: 50px;
        }

        /* Student Info Table */
        .student-info {
            /*margin: 20px 0 20px 80px;*/
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;

        }

        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .info-label {
            width: 200px;
        }

        .info-colon {
            width: 20px;
        }

        /* Schedule Section */
        .schedule-section {
            margin: 20px 0 20px 80px;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
        }

        .schedule-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .schedule-label {
            width: 150px;
        }

        /* Closing */
        .closing {
            margin-top:15px;
            text-align: justify;
        }

        /* Notes Section */
        .notes-section {

            text-align: justify;
        }

        .notes-title {
            margin: 0;
            padding: 0;
            margin-left: 5px;
        }

        .notes-list {
            margin: 0;
            margin-left: 7%;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 20px;
            text-align: right;
        }

        .signature-box {
            display: inline-block;
            min-width: 250px;
            text-align: left;
        }

        .signature-date {
            margin-bottom: 5px;
        }

        .signature-role {
            /*margin-bottom: 50px;*/
        }


        .signature-name {
            margin-bottom: 3px;
        }

        /* Tembusan Section */
        .tembusan-section {

        }

        .tembusan-title {
            margin: 0;
        }


        .tembusan-list {
            margin: 0;
            padding: 0;
            padding-left: 20px;
        }

        ul, ol {
            margin: 0;
            padding: 0;
            padding-left: 20px;
        }

        .add-content-padding {
            margin-left: 7%;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        @php $logo = public_path('kop_logo.png'); @endphp
        @inlinedImage($logo)
    </div>

    <!-- Letter Details -->
    <div class="letter-header">
        <div class="letter-row">
            <span class="letter-label">Nomor</span>
            <span class="letter-separator">:</span>
            <span>B/ {{$data->nomor}} / KPSIH-FH / UND / {{\Illuminate\Support\Carbon::now()->year}} </span>
        </div>
        <div class="letter-row">
            <span class="letter-label">Perihal</span>
            <span class="letter-separator">:</span>
            <span>{{$data->perihal}}</span>
        </div>
    </div>

    <div class="add-content-padding">
        <!-- Recipient -->
        <div class="recipient-section">
            <div class="recipient-title">Kepada Yth :</div>
            <table style="width: 100%; font-size: 11pt;">
                <tbody>
                <tr>
                    <td style="width: 0%;"> <strong>1.</strong></td>
                    <td style="font-weight: bold; width: 50%;">{{$data->judul->pembimbingSatu->nama}} </td>
                    <td style="width: 30%;">(Ketua Merangkap Anggota/ Penguji)</td>
                </tr>
                <tr>
                    <td><strong>2.</strong></td>
                    <td style="font-weight: bold">{{$data->judul->pembimbingDua->nama}} </td>
                    <td>(Sekretaris/ Penguji)</td>
                </tr>
                <tr>
                    <td><strong>3.</strong></td>
                    <td style="font-weight: bold">{{$data->judul->pengujiSatu->nama}}</td>
                    <td>(Penguji)</td>
                </tr>
                <tr>
                    <td><strong>4.</strong></td>
                    <td style="font-weight: bold">{{$data->judul->pengujiDua->nama}}</td>
                    <td>(Penguji)</td>
                </tr>
                </tbody>
            </table>
            <br>
            <div class="recipient-location">
                Di – <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jayapura
            </div>
        </div>

        <!-- Greeting -->
        <div class="greeting">
            Dengan hormat kami mengundang Bapak / Ibu untuk hadir dan bertindak sebagai penguji dalam Sidang Ujian bagi mahasiswa Program Studi Ilmu Hukum sebagai berikut :
        </div>

        <!-- Student Information -->
        <div class="student-info">
            <table class="info-table">
                <tr>
                    <td class="info-label">Nama</td>
                    <td class="info-colon">:</td>
                    <td style="font-weight: bold">{{$data->judul->mahasiswa->nama}}</td>
                </tr>
                <tr>
                    <td class="info-label">Nomor Pokok Mahasiswa</td>
                    <td class="info-colon">:</td>
                    <td>{{$data->judul->mahasiswa->npm}}</td>
                </tr>
                <tr>
                    <td class="info-label">Judul</td>
                    <td class="info-colon">:</td>
                    <td>{{$data->judul->judul}}</td>
                </tr>
                <tr>
                    <td class="info-label">Pada hari, tanggal</td>
                    <td class="info-colon">:</td>
                    <td>{{\Carbon\Carbon::parse($data->tanggal_hari)->isoFormat('dddd,d MMMM YYYY')}}</td>
                </tr>
                <tr>
                    <td class="schedule-label">Waktu</td>
                    <td class="info-colon">:</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($data->waktu)->format('H.i').' WIT' ?? '-' }} s/d Selesai</td>
                </tr>
                <tr>
                    <td class="schedule-label">Tempat</td>
                    <td class="info-colon">:</td>
                    @if($data->tempat == 'online')
                        <td>Ujian dilaksanakan secara Online via aplikasi Zoom <br>Meeting ID {{$data->meeting_id}} <br>Passcode {{$data->passcode}}</td>
                    @else
                        <td>{{$data->tempat}}</td>

                    @endif
                </tr>
            </table>
        </div>
        <!-- Closing -->
        <div class="closing">
            Atas perhatian dan kehadirannya kami ucapkan terima kasih.
        </div>
    </div>


    <!-- Notes -->
    <div class="notes-section">
        <div class="notes-title"><strong>Catatan :</strong></div>
        <ol class="notes-list">
            <li>Mahasiswa Wajib Menggunakan Jas Almamater dan Dasi</li>
            <li>Bapak/Ibu Dosen Wajib Menggunakan Jas Almamater UNINGRAT Papua Warna Merah</li>
        </ol>
    </div>

    <!-- Signature -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-date">Jayapura, {{\Carbon\Carbon::parse($data->create_at)->translatedFormat('d F Y')}}</div>
            <div class="signature-role">a.n Dekan<br>Ketua Program Studi Ilmu Hukum</div>
            <img  style="width: 30%; padding-left: 10px;" src="data:image/png;base64,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"/>
            <div class="signature-name">Muhammad Toha Ingratubun, S.H., M.H</div>
            <div class="signature-nrp">Nrp 2010160</div>
        </div>
    </div>

    <!-- Tembusan -->
    <div class="tembusan-section">
        <div class="tembusan-title" style="text-decoration: underline;"><strong>Tembusan Kepada Yth.</strong></div>
        <ol class="tembusan-list">
            <li>Rektor Uningrat Papua (Sebagai Laporan);</li>
            <li>Dekan Fakultas Hukum Uningrat Papua;</li>
            <li>Saudara/i {{$data->judul->mahasiswa->nama}}</li>
            <li>File</li>
        </ol>
    </div>
</div>
</body>
</html>


