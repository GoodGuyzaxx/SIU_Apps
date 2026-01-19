<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        .page-koreksi-judul {
            margin-top: 50px;
            margin-left: 30px;
            margin-right: 30px;
            font-size: 12pt;
        }

        .koreksi-info-label {
            margin-bottom: 15px;
        }

        .koreksi-info-label table{
            width: 100%;
            font-weight: bold;
        }

        .koreksi-info-label table td:nth-child(1) {
            width: 15%;
        }

        .koreksi-judul-proposal-label {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .koreksi-judul-proposal-label table{
            width: 100%;
            border-collapse: collapse;
            border: 1px #000 solid;
        }

        .koreksi-judul-proposal-label table td{
            border: 1px #000 solid;
            text-align: center;
        }

        .koreksi-judul-proposal-label .col-info{
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .koreksi-judul-proposal-label .col-judul{
            padding: 100px 10px;
        }

        .dosen-section {
            text-align: center;
            margin-top: 30px;
        }

        .dosen-section p {
            font-weight: bold;
            margin-bottom: 10pt;
            font-size: 11pt;
        }

        .dosen-signature {
            margin-top: 15px;
            min-height: 80px;
        }

        .dosen-section .nama-dosen {
            text-decoration: underline;
            font-weight: bold;
            display: inline-block;
            font-size: 11pt;
        }

        .tanggal {
            text-align: right;
            margin-top: 20px;
            margin-bottom: 10px;
            margin-right: 30px;
        }

    </style>
</head>
<body>
<div class="page-koreksi-judul">
    <div class="heading">
        <h2>KOREKSI JUDUL</h2>
        <h3>PROPOSAL SKRIPSI</h3>
    </div>

    <div class="koreksi-info-label">
        <table>
            <tr>
                <td>
                    NAMA
                </td>
                <td>
                    : {{$data->judul->mahasiswa->nama?? '-'}}
                </td>
            </tr>
            <tr>
                <td>NPM</td>
                <td>: {{$data->judul->mahasiswa->npm?? '-'}}</td>
            </tr>
        </table>
    </div>

    <div class="koreksi-judul-proposal-label">
        <table>
            <tr>
                <td class="col-info">
                    JUDUL PROPOSAL SEBELUMNYA
                </td>
            </tr>
            <tr>
                <td class="col-judul">
                    {{$data->judul->judul?? '-'}}
                </td>
            </tr>
        </table>
    </div>

    <div class="koreksi-judul-proposal-label">
        <table>
            <tr>
                <td class="col-info">
                    JUDUL PROPOSAL REVISI
                </td>
            </tr>
            <tr>
                <td class="col-judul">
                    &nbsp;
                </td>
            </tr>
        </table>
    </div>

    <div class="tanggal">
        <p>Jayapura, {{\Carbon\Carbon::now()->isoFormat("D MMMM YYYY")}}</p>
    </div>

    <div class="dosen-section">
        <p>Penanggung Jawab</p>
        <div class="dosen-signature">

        </div>
        <span class="nama-dosen">{{ $data->judul->pembimbingSatu->nama ?? 'Nama Dosen, S.H., M.H.' }}</span>
    </div>

</div>

</body>
</html>
