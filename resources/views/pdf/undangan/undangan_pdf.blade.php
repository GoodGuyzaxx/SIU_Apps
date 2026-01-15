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
            margin-bottom: 50px;
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
