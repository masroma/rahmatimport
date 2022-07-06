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
                        <strong> REKAP INDEKS PRESTASI SEMESTER ( IPS ) MAHASISWA PER PERIODE </strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td align="left" width="20%"><strong>Perguruan Tinggi</strong></td>
                <td align="left" width="30%"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td align="left" width="20%"><strong>Periode</strong></td>
                <td align="left"><strong>:</strong> 2021/2022 Genap</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> Semua Program Studi</td>
                <td align="left"><strong>Data Per Tanggal</strong></td>
                <td align="left"><strong>:</strong> 4 July 2022</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <th rowspan="2">Program Studi</th>
                <th colspan="5">Jumlah IPS Mahasiswa</th>
            </tr>
            <tr>
                <th>Range (0 - 1)</th>
                <th>Range (&gt;1 - 2)</th>
                <th>Range (&gt;2 - 3)</th>
                <th>Range (&gt;3 - 4)</th>
                <th>Range (&gt;4)</th>
            </tr>
            @php
            $sum_01 = [];
            $sum_12 = [];
            $sum_23 = [];
            $sum_34 = [];
            $sum_4 = [];
            @endphp
            @foreach ($main as $item)
            @php
                array_push($sum_01,$item->ips_01);
                array_push($sum_12,$item->ips_12);
                array_push($sum_23,$item->ips_23);
                array_push($sum_34,$item->ips_34);
                array_push($sum_4,$item->ips_4);
            @endphp
                <tr>
                    <td>{{$item->nama_jurusan}}</td>
                    <td align="right">{{$item->ips_01}}</td>
                    <td align="right">{{$item->ips_12}}</td>
                    <td align="right">{{$item->ips_23}}</td>
                    <td align="right">{{$item->ips_34}}</td>
                    <td align="right">{{$item->ips_4}}</td>
                </tr>
                
            @endforeach
            <tr>
                <td align="right"><strong>TOTAL</strong></td>
                <td align="right">{{array_sum($sum_01)}}</td>
                <td align="right">{{array_sum($sum_12)}}</td>
                <td align="right">{{array_sum($sum_23)}}</td>
                <td align="right">{{array_sum($sum_34)}}</td>
                <td align="right">{{array_sum($sum_4)}}</td>
            </tr>
        </tbody>
    </table>


</body>

</html>
