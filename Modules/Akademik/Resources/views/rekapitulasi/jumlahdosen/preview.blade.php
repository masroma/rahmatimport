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
                        <strong>LAPORAN JUMLAH DOSEN PER TAHUN AJARAN</strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td align="left" width="20%"><strong>Perguruan Tinggi</strong></td>
                <td align="left" width="30%"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td align="left" width="20%"><strong>Periode</strong></td>
                <td align="left"><strong>:</strong> {{$tahun}}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> Semua Program Studi</td>
                <td align="left"><strong>Data Per Tanggal</strong></td>
                <td align="left"><strong>:</strong> {{date('d F Y')}}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <th rowspan="2">Program Studi</th>
                <th colspan="2">Jumlah Dosen</th>
            </tr>
            <tr>
                <th>Homebase</th>
                <th>Non Homebase </th>
            </tr>
            @foreach ($main as $item)
            <tr>
                <td> {{$item->nama_jurusan}}</td>
                <td style="text-align:right">{{$item->home_base}}</td>
                <td style="text-align:right"> {{$item->non_home_base}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
