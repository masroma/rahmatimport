<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi KRS Mahasiswa</title>
</head>

<style>
    body {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
    }
</style>

<body onload="{{ ( isset($format)  ? 'window.print()'  : '' ) }}">
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
                        <strong>KARTU RENCANA STUDI (KRS)</strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td align="left" width="20%"><strong>Nama Mahasiswa</strong></td>
                <td align="left" width="30%"><strong>:</strong> {{ $selKRSMahasiswa[0]->nama }}</td>
                <td align="left" width="20%"><strong>NIM</strong></td>
                <td align="left"><strong>:</strong> {{ $selKRSMahasiswa[0]->nim }}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{ $selKRSMahasiswa[0]->nama_jurusan }}</td>
                <td align="left"><strong>Periode</strong></td>
                <td align="left"><strong>:</strong> {{ $selKRSMahasiswa[0]->tahun_ajaran }} - {{ $selKRSMahasiswa[0]->jenis_semester }}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" border="1|0" style="border-collapse: collapse;">
        <tbody>
            <tr>
                <th rowspan="2" width="5%">No</th>
                <th colspan="3">Mata Kuliah</th>
            </tr>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Bobot(sks)</th>
            </tr>
            @php
            $no = 1;
            $totalsks = 0 ;
            $maxdata = count($selKRSMahasiswa);
            @endphp
            @foreach($selKRSMahasiswa as $skrsm)

            <tr>
                <td align="center">{{ $no++ }}</td>
                <td align="center">{{ $skrsm->kode_matakuliah }}</td>
                <td>{{ $skrsm->nama_matakuliah }} </td>
                <td align="right">{{ number_format((float)$skrsm->bobot_mata_kuliah, 2, '.', '')  }}</td>
            </tr>
            @php
            $totalsks = $totalsks + $skrsm->bobot_mata_kuliah;
            @endphp
            @endforeach            
            <tr>
                <td colspan="3" align="right"><strong>Total sks</strong></td>
                <td align="right">{{  number_format((float)$totalsks, 2, '.', '') }} </td>
            </tr>
        </tbody>
    </table>


</body>

</html>