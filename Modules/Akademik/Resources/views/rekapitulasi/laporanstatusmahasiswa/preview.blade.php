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
                        <strong> DAFTAR STATUS MAHASISWA PER ANGKATAN </strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td align="left" width="20%"><strong>Perguruan Tinggi</strong></td>
                <td align="left" width="30%"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td align="left" width="20%"><strong>Angkatan</strong></td>
                <td align="left"><strong>:</strong> {{$angkatan}}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> S1 Desain Komunikasi Visual</td>
                <td align="left"><strong>Data Per Tanggal</strong></td>
                <td align="left"><strong>:</strong> {{date('d F Y')}}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Periode Masuk</th>
                <th>Status</th>
                @foreach ($main as $item)
                <th>{{$item->periode_left}}</th>
                    
                @endforeach
            </tr>
            @php($i=1)
            @php($bef_nim='')
            @foreach ($main as $item)
            @if ($item->nim == $bef_nim)
            <td align="center">{{$item->status_mahasiswa}}</td>
            @else
            @if($bef_nim!='')</tr>@endif
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->nim}}</td>
                    <td>{{$item->nama}}</td>
                    <td align="center">{{$item->periode_masuk}}</td>
                    <td align="center">{{$item->last_sts}}</td>
                    <td align="center">{{$item->status_mahasiswa}}</td>
            @endif
             @php($bef_nim=$item->nim)
            @endforeach
        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td>*keterangan:</td>
                <td>
                    <p>A (Aktif)</p>
                </td>
                <td>
                    <p>C (Cuti)</p>
                </td>
                <td>
                    <p>N (Non-Aktif)</p>
                </td>
            </tr>
        </tbody>
    </table>


</body>

</html>
