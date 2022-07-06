<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi KHS Mahasiswa</title>
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
                <td align="left" width="30%"><strong>:</strong> {{ $selKHSMahasiswa[0]->nama }}</td>
                <td align="left" width="20%"><strong>NIM</strong></td>
                <td align="left"><strong>:</strong> {{ $selKHSMahasiswa[0]->nim }}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{ $selKHSMahasiswa[0]->nama_jurusan }}</td>
                <td align="left"><strong>Periode</strong></td>
                <td align="left"><strong>:</strong> {{ $selKHSMahasiswa[0]->tahun_ajaran }} - {{ $selKHSMahasiswa[0]->jenis_semester }}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" border="1|0" style="border-collapse: collapse;">
        <tbody>
            <tr>
                <th rowspan="2" width="5%">No</th>
                <th rowspan="2">Kode MK</th>
                <th rowspan="2">Nama MK</th>
                <th rowspan="2">Bobot MK<br>(sks)</th>
                <th colspan="3">Nilai</th>
                <th rowspan="2">sks * Indeks</th>
            </tr>
            <tr>
                <th>Angka</th>
                <th>Huruf</th>
                <th>Indeks</th>
            </tr>
            @php
            $no = 1;
            $totalsks = 0 ;
            $totalsksxindex = 0 ;
            $sksxindex = 0 ;
            $maxdata = count($selKHSMahasiswa);
            @endphp
            @foreach($selKHSMahasiswa as $skhsm)

            <tr>
            <td align="center">{{ $no++ }}</td>
                <td align="center">{{ $skhsm->kode_matakuliah }}</td>
                <td>{{ $skhsm->nama_matakuliah }} </td>
                <td align="right">{{ number_format((float)$skhsm->bobot_mata_kuliah, 2, '.', '')  }}</td>
                <td align="right">{{  number_format((float)$skhsm->nilai_angka, 1, '.', '')  }}</td>
                <td align="right">{{ $skhsm->nilai_huruf }}</td>
                <td align="right">{{  number_format((float)$skhsm->nilai_index, 2, '.', '')  }}</td>
                @php
                $sksxindex = $skhsm->bobot_mata_kuliah * $skhsm->nilai_index;
                @endphp
                <td style="text-align:right">{{ number_format((float)$sksxindex, 2, '.', '')  }}</td>
            </tr>
            @php
            $totalsks = $totalsks + $skhsm->bobot_mata_kuliah;
            $totalsksxindex = $totalsksxindex + $sksxindex;
            @endphp          
            @endforeach
            <tr>
                <td colspan="3" align="right"><strong>Total sks</strong></td>
                <td align="right">{{ number_format((float)$totalsks, 2, '.', '')  }}</td>
                <td colspan="3" align="right"></td>
                <td align="right">{{ number_format((float)$totalsksxindex, 2, '.', '')  }}</td>
            </tr>
            <tr>
                @php $ips = $totalsksxindex / $maxdata; @endphp
                <td colspan="7" align="right"><strong>IPS ( Indeks Prestasi Semester )</strong></td>
                <th style="text-align:right">{{ number_format((float)$ips, 2, '.', '') }}</th>
            </tr>


        </tbody>
    </table>


</body>

</html>