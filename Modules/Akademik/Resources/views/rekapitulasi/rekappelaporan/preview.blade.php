<html>

<head>
    <title></title>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
    <style>
        html,
        .signature {
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
        }

        td {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
    </style>
</head>

<body data-new-gr-c-s-check-loaded="14.1015.0" data-gr-ext-installed="">
    <table width="100%" style="border-bottom-style:double;padding-bottom:20px;margin-bottom:10px;">
        <tbody>

            <tr>
                <td colspan="4">
                    <div id="repHeader" style="width: 100%;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td align="left">
                                        <div class="repTitle">
                                            <font size="3">
                                                <strong>PANGKALAN DATA PENDIDIKAN TINGGI</strong>
                                            </font>
                                            <br>
                                            <font size="2">
                                                <strong>KEMENTRIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</strong>
                                            </font>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>

            <tr>
                <td align="center" colspan="4">
                    <font size="5">
                        <strong>REKAPITULASI PELAPORAN</strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td align="left" width="20%"><strong>Perguruan Tinggi</strong></td>
                <td align="left" width="30%"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td align="left" width="20%"><strong>Periode</strong></td>
                <td align="left"><strong>:</strong> {{$periode}}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{$jurusan}}</td>
                <td align="left"><strong>Data Per Tanggal</strong></td>
                <td align="left"><strong>:</strong> {{ date('d F Y') }}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <td rowspan="2" style="text-align:center"><strong>No.</strong></td>
                <td rowspan="2" style="text-align:center"><strong>Semester</strong></td>
                <td colspan="8" style="text-align:center"><strong>Rekap</strong></td>
            </tr>
            <tr>
                <td style="text-align:center"><strong>Mahasiswa<br>Baru</strong></td>
                <td style="text-align:center"><strong>Kelas<br>Perkuliahan</strong></td>
                <td style="text-align:center"><strong>KRS<br>Mahasiswa</strong></td>
                <td style="text-align:center"><strong>Aktivitas<br>Kuliah Mahasiswa</strong></td>
                <td style="text-align:center"><strong>Nilai<br>Mahasiswa</strong></td>
            </tr>
            @php($i=1)
            @foreach ($main as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->tahun_ajaran}}</td>
                    <td align="right">{{$item->mahasiswa_baru}}</td>
                    <td align="right">{{$item->kelas_perkuliahan}}</td>
                    <td align="right">{{$item->jumlah_krs}}</td>
                    <td align="right">{{$item->aktifitas_kuliah}}</td>
                    <td align="right">{{$item->nilai_angka}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
