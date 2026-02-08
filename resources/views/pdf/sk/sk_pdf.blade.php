<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keputusan Dekan Fakultas Hukum Universitas Doktor Husni Ingratubun (UNINGRAT) PAPUA</title>
    <style>
        /*@page {*/
        /*    size: 21cm 33cm;*/
        /*    margin: 0;*/
        /*}*/

        body {
            font-family: "Bookman Old Style", "Bookman", Georgia, serif;
            font-size: 12pt;

        }

        .heading {
            text-align: center;
        }

        .heading-title-text {
            font-weight: bold;
            font-size: 12pt;
        }

        .content {
            text-align: justify;
            margin-left: 20px;
            margin-right: 20px;

        }

        .content-tb-menimbang {
            margin-bottom: 10px;
        }

        .content-tb-menimbang td,
        tr,
        ol {
            vertical-align: top;
        }

        .content-tb-menimbang ol {
            vertical-align: top;
            margin: 0;
            padding-left: 15px
        }

        .content-tb-menimbang li {
            margin: 0;
            padding: 0;
        }

        .content-tb-menimbang p {
            margin: 0;
            padding: 0;
        }

        table,
        th,
        td {

            /* border: 1px solid black; */
            border-collapse: collapse;
        }

        .content-tb-mengingat {
            margin-bottom: 10px;
        }

        .content-tb-mengingat ol {
            vertical-align: top;
            margin: 0;
            padding-left: 15px
        }

        .content-tb-mengingat li {
            margin: 0;
            padding: 0;
        }

        .content-tb-mengingat p {
            margin: 0;
            padding: 0;
        }

        .content-tb-memperhatikan {
            margin-bottom: 10px;
        }

        .content-tb-menetapakan {
            margin-bottom: 10px;
        }

        .content-tb-menetapakan-kesatu {
            margin-bottom: 15px;
        }

        .content-text-memutuskan {
            text-align: center;
        }

        .inner-table {
            text-align: justify;
        }

        .sign-content {
            margin-left: 50%;
            margin-top: 20px;
        }

        .sign-content p {
            margin: 0;
            padding: 0;
        }

        .tembusan {
            margin-left: 20px;
        }

        .tembusan p {
            margin: 0;
            font-weight: bold;
            text-decoration: underline;
        }

        .tembusan ol {
            padding-left: 18px;
            margin: 0;
            list-style-position: outside;
        }

        .dekan-say {
            margin-left: 140px;
            margin-bottom: 0;
        }

        /*ol li {*/
        /*     vertical-align: top;*/
        /*}*/

        .kop {
            margin-bottom: -10px;
        }

        .kop img {
            max-width: 100%;
        }

        .page-pembimbing {
            page-break-after: always;
        }
    </style>
</head>

<body>
<div class="page-pembimbing">
    <div class="kop">
        @php $logo = public_path('kop_logo.png'); @endphp
        @inlinedImage($logo)
    </div>
    <div class="heading">
        <div class="heading-title-text">SURAT KEPUTUSAN</div>
        <div class="heading-title-text">DEKAN FAKULTAS HUKUM</div>
        <div class="heading-title-text">UNIVERSITAS DOKTOR HUSNI INGRATUBUN (UNINGRAT) PAPUA</div>
        <div class="heading-title-normal-text"> NOMOR : {{$data->nomor_sk_pembimbing}}</div>
        <div class="heading-title-normal-text"> T E N T A N G</div>
        <div class="heading-title-text">PENETAPAN PEMBIMBING SKRIPSI PROGRAM STRATA SATU (S.1)</div>
    </div>

    <div class="content">
        <p class="dekan-say">DEKAN FAKULTAS HUKUM UNIVERSITAS DOKTOR HUSNI INGRATUBUN PAPUA</p>
        <div class="content-tb-menimbang">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%;">Menimbang</td>
                    <td>:&nbsp;</td>
                    <td>
{{--                        <ol style="margin: 0; padding-left: 15px;">--}}
                            {!! $data->menimbang !!}
{{--                        </ol>--}}
                    </td>
                </tr>
            </table>
        </div>

        <div class="content-tb-mengingat">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%;">Mengingat</td>
                    <td>:&nbsp;</td>
                    <td>
                        {!! $data->mengingat !!}
{{--                        <ol style="margin: 0; padding-left: 15px;">--}}
{{--                            <li>Undang-Undang RI Nomor 20 Tahun 2003 Tentang Sistem Pendidikan Nasional.</li>--}}
{{--                            <li>Undang-Undang Ri Nomor 14 Tahun 2005 Tentang Guru dan Dosen.</li>--}}
{{--                            <li>Undang-Undang RI Nomor 12 Tahun 2012 Tentang Pendidikan Tinggi.</li>--}}
{{--                            <li>Peraturan Pemerintah RI Nomor 4 Tahun 2014 Tentang Pengelolaan dan Penyelenggaraan--}}
{{--                                Pendidikan.</li>--}}
{{--                            <li>Akreditasi Program Studi S.1 (B) oleh BAN-PT Nomor: 4476/SK/BAN-PT/Ak-PNB/S/XI/2023--}}
{{--                                tanggal 6 November 2023.</li>--}}
{{--                        </ol>--}}
                    </td>
                </tr>
            </table>
        </div>

        <div class="content-tb-memperhatikan">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%;">Memperhatikan</td>
                    <td>:&nbsp;</td>
                    <td>{{$data->memperhatikan}}</td>
                </tr>
            </table>
        </div>

        <div class="content-text-memutuskan">
            M E M U T U S K A N
        </div>

        <div class="content-tb-menetapakan">

            <!-- Pengecakan ketika S1 atau S2 -->
            <table style="width: 100%;">
                <td style="width: 15%;">Menetapkan</td>
                <td>:&nbsp;</td>
                <td>KEPUTUSAN DEKAN FAKULTAS HUKUM UNIVERSITAS DOKTOR HUSNI INGRATUBUN (UNINGRAT) PAPUA TENTANG PENETAPAN DOSEN PEMBIMBING SKRIPSI PROGRAM STRATA SATU (S.1).</td>
            </table>
        </div>

        <div class="content-tb-menetapakan-kesatu">
            <table style="width: 100%;">
                <td style="width: 15%;">Kesatu</td>
                <td>:</td>
                <td>
                    <table class="inner-table" style="width: 100%;">
                        <tr>
                            <td style="width: 30%;">N a m a</td>
                            <td>:</td>
                            <td>{{$data->judul->mahasiswa->nama}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Pokok Mahasiswa</td>
                            <td>:</td>
                            <td>{{$data->judul->mahasiswa->npm}}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Judul Skripsi</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{$data->judul->judul}}</td>
                        </tr>
                    </table>
                </td>
            </table>
        </div>

        <div class="content-tb-menetapakan-kedua">
            <table style="width: 100%;">
                <td style="width: 15%;" rowspan="3">Kedua</td>
                <td rowspan="3">:</td>
                <td colspan="3">Dengan susunan dosen pembimbing skripsi sebagai berikut :</td>
                <tr>
                    <td style="width: 15%;">Pembimbing I</td>
                    <td>:</td>
                    <td> {{$data->judul->pembimbingSatu->nama}}</td>
                </tr>
                <tr>
                    <td>Pembimbing II</td>
                    <td>:</td>
                    <td>{{$data->judul->pembimbingDua->nama}}</td>
                </tr>
            </table>
        </div>

        <div class="content-tb-menetapakan-ketiga">
            <table style="width: 100%;">
                <td style="width: 15%;">Ketiga</td>
                <td>:&nbsp;</td>
                <td> Keputusan ini mulai berlaku sejak tanggal ditetapkan dengan ketentuan bahwa apabila di kemudian hari
                    terdapat kekeliruan didalamnya, maka akan diadakan perbaikan sebagaimana mestinya..</td>
            </table>
        </div>

    </div>

    <div class="sign-content">
        <p>Ditetapkan di<span style="margin-left: 20px; margin-right: 10px">:</span> Jayapura</p>
        <p style="text-decoration: underline">Pada tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp; {{\Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</p>
        <p style="padding-bottom: 4px; margin-top: 5px;">Dekan,</p>
        <br>
        <br>
        <p>Assoc. Prof. Dr. Hj. Fitriyah Ingratubun, SH.,MH</p>
        <p>Nrp. 0908084</p>
    </div>

    <div class="tembusan">
        <p>Tembusan Disampaikan Kepada Yth:</p>
        <ol>
            <li>Rektor Uningrat Papua (Sebagai Laporan);</li>
            <li>Wakil Dekan Fakultas Hukum Uningrat Papua;</li>
            <li>Ketua Program Studi Ilmu Hukum Uningrat Papua;</li>
            <li>Tim Penguji;</li>
            <li>Mahasiswa Yang Bersangkutan Untuk Diketahui;</li>
            <li>File</li>
        </ol>
    </div>
</div>


{{-- PAGE PENGUJI--}}
<div class="page-penguji">
    <div class="kop">
        @php $logo = public_path('kop_logo.png'); @endphp
        @inlinedImage($logo)
    </div>
    <div class="heading">
        <div class="heading-title-text">SURAT KEPUTUSAN</div>
        <div class="heading-title-text">DEKAN FAKULTAS HUKUM</div>
        <div class="heading-title-text">UNIVERSITAS DOKTOR HUSNI INGRATUBUN (UNINGRAT) PAPUA</div>
        <div class="heading-title-normal-text"> NOMOR : {{$data->nomor_sk_pembimbing}}</div>
        <div class="heading-title-normal-text"> T E N T A N G</div>
        <div class="heading-title-text">PENETAPAN PENGUJI SKRIPSI PROGRAM STRATA SATU (S.1)</div>
    </div>

    <div class="content">
        <p class="dekan-say">DEKAN FAKULTAS HUKUM UNIVERSITAS DOKTOR HUSNI INGRATUBUN PAPUA</p>
        <div class="content-tb-menimbang">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%;">Menimbang</td>
                    <td>:&nbsp;</td>
                    <td>
                        {!! $data->menimbang !!}
{{--                        <ol style="margin: 0; padding-left: 15px;">--}}
{{--                            <li>Bahwa untuk memperlancar proses penyusunan skripsi mahasiswa perlu adanya bimbingan dan--}}
{{--                                pengarahan dari dosen penguji.</li>--}}
{{--                            <li>Bahwa sehubungan dengan butir (1) tersebut diatas, maka perlu ditetapkan Surat Keputusan--}}
{{--                                Dekan Fakutas Hukum Universitas Doktor Husni Ingratubun (UNINGRAT) Papua.</li>--}}
{{--                        </ol>--}}
                    </td>
                </tr>
            </table>
        </div>

        <div class="content-tb-mengingat">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%;">Mengingat</td>
                    <td>:&nbsp;</td>
                    <td>
{{--                        <ol style="margin: 0; padding-left: 15px;">--}}
{{--                            <li>Undang-Undang RI Nomor 20 Tahun 2003 Tentang Sistem Pendidikan Nasional.</li>--}}
{{--                            <li>Undang-Undang Ri Nomor 14 Tahun 2005 Tentang Guru dan Dosen.</li>--}}
{{--                            <li>Undang-Undang RI Nomor 12 Tahun 2012 Tentang Pendidikan Tinggi.</li>--}}
{{--                            <li>Peraturan Pemerintah RI Nomor 4 Tahun 2014 Tentang Pengelolaan dan Penyelenggaraan--}}
{{--                                Pendidikan.</li>--}}
{{--                            <li>Akreditasi Program Studi S.1 (B) oleh BAN-PT Nomor: 4476/SK/BAN-PT/Ak-PNB/S/XI/2023--}}
{{--                                tanggal 6 November 2023.</li>--}}
{{--                        </ol>--}}
                        {!! $data->mengingat !!}
                    </td>
                </tr>
            </table>
        </div>

        <div class="content-tb-memperhatikan">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%;">Mengingat</td>
                    <td>:&nbsp;</td>
                    <td>{{$data->memperhatikan}}</td>
{{--                    <td>Hasil Rapat Ketua Program Studi Ilmu Hukum Bersama Dosen Pada Tanggal 03 September 2024 (Note To--}}
{{--                        Ask).</td>--}}
                </tr>
            </table>
        </div>

        <div class="content-text-memutuskan">
            M E M U T U S K A N
        </div>

        <div class="content-tb-menetapakan">

            <!-- Pengecakan ketika S1 atau S2 -->
            <table style="width: 100%;">
                <td style="width: 15%;">Menetapkan</td>
                <td>:&nbsp;</td>
                <td>KEPUTUSAN DEKAN FAKULTAS HUKUM UNIVERSITAS DOKTOR HUSNI INGRATUBUN (UNINGRAT) PAPUA TENTANG
                    PENETAPAN
                    DOSEN PENGUJI SKRIPSI PROGRAM STRATA SATU (S.1).</td>
            </table>
        </div>

        <div class="content-tb-menetapakan-kesatu">
            <table style="width: 100%;">
                <td style="width: 15%;">Kesatu</td>
                <td>:</td>
                <td>
                    <table class="inner-table" style="width: 100%;">
                        <tr>
                            <td style="width: 30%;">N a m a</td>
                            <td>:</td>
                            <td>{{$data->judul->mahasiswa->nama}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Pokok Mahasiswa</td>
                            <td>:</td>
                            <td>{{$data->judul->mahasiswa->npm}}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Judul Skripsi</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{$data->judul->judul}}</td>
                        </tr>
                    </table>
                </td>
            </table>
        </div>

        <div class="content-tb-menetapakan-kedua">
            <table style="width: 100%;">
                <td style="width: 15%;" rowspan="3">Kedua</td>
                <td rowspan="3">:</td>
                <td colspan="3">Dengan susunan dosen pembimbing skripsi sebagai berikut :</td>
                <tr>
                    <td style="width: 10%;">Ketua</td>
                    <td>:</td>
                    <td>1. {{$data->judul->pembimbingSatu->nama}}</td>
                </tr>
                <tr>
                    <td>Anggota</td>
                    <td>:</td>
                    <td>2. {{$data->judul->pembimbingDua->nama}} <br>3. {{$data->judul->pengujiSatu->nama}} <br>4. {{$data->judul->pengujiDua->nama}}</td>

                </tr>
            </table>
        </div>

        <div class="content-tb-menetapakan-ketiga">
            <table style="width: 100%;">
                <td style="width: 15%;">Ketiga</td>
                <td>:&nbsp;</td>
                <td> Keputusan ini mulai berlaku sejak tanggal ditetapkan dengan ketentuan bahwa apabila di kemudian hari
                    terdapat kekeliruan didalamnya, maka akan diadakan perbaikan sebagaimana mestinya..</td>
            </table>
        </div>

    </div>

    <div class="sign-content">
        <p>Ditetapkan di <span style="margin-left: 20px; margin-right: 10px">:</span>Jayapura</p>
        <p style="text-decoration: underline">Pada tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;{{\Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</p>
        <p style="padding-bottom: 4px; margin-top: 5px;">Dekan,</p>
        <br>
        <br>
        <p>Assoc. Prof. Dr. Hj. Fitriyah Ingratubun, SH.,MH</p>
        <p>Nrp. 0908084</p>
    </div>

    <div class="tembusan">
        <p>Tembusan Disampaikan Kepada Yth:</p>
        <ol>
            <li>Rektor Uningrat Papua (Sebagai Laporan);</li>
            <li>Wakil Dekan Fakultas Hukum Uningrat Papua;</li>
            <li>Ketua Program Studi Ilmu Hukum Uningrat Papua;</li>
            <li>Tim Penguji;</li>
            <li>Mahasiswa Yang Bersangkutan Untuk Diketahui;</li>
            <li>File</li>
        </ol>
    </div>
</div>

</body>

</html>
