<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data KRS Mahasiswa</title>
</head>
<style>
    body {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
    }
</style>
<body onload="{{ ( isset($format)  ? 'window.print()'  : '' ) }}">

    <table style="border-bottom-style:double;padding-bottom:20px;margin-bottom:10px;" width="100%">
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
                <td colspan="4" align="center">
                    <font size="5">
                        <strong>DAFTAR KRS PER PERIODE</strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>Perguruan Tinggi</strong></td>
                <td width="30%" align="left"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td width="20%" align="left"><strong>Tahun Ajaran</strong></td>
                <td align="left"><strong>:</strong> {{ $selKRS[0]->tahun_ajaran.' - '.$selKRS[0]->jenis_semester }}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{ $selKRS[0]->nama_jenjang.' '.$selKRS[0]->nama_jurusan }}</td>
                <td align="left"><strong>Data Per Tanggal</strong></td>
                <td align="left"><strong>:</strong> {{ date('d F Y') }}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">NIM</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Program Studi</th>
                <th rowspan="2">Kode MK</th>
                <th rowspan="2">Nama MK</th>
                <th rowspan="2">Bobot MK<br>(sks)</th>
                <th colspan="3">Nilai</th>
            </tr>
            <tr>
                <th>Angka</th>
                <th>Huruf</th>
                <th>Indeks</th>
            </tr>
            @php $no = 1; @endphp
            @foreach($selKRS as $skrs)
            <tr>
                <td align="center">{{ $no++ }}</td>
                <td align="center">{{ $skrs->nim }}</td>
                <td>{{ $skrs->nama }}</td>
                <td>{{ $skrs->nama_jenjang.' '.$skrs->nama_jurusan }}</td>
                <td align="center">{{ $skrs->kode_matakuliah }}</td>
                <td>{{ $skrs->nama_matakuliah }}</td>
                <td align="center">{{  number_format((float)$skrs->bobot_mata_kuliah, 2, '.', '')  }}</td>
                <td align="center">{{  number_format((float)$skrs->nilai_angka, 1, '.', '')  }}</td>
                <td align="center">{{ $skrs->nilai_huruf }}</td>
                <td align="center">{{  number_format((float)$skrs->nilai_index, 2, '.', '')  }}</td>
            </tr>     
            @endforeach      
        </tbody>
    </table>



</body>

</html>