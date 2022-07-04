<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Nilai Transfer</title>
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
                        <strong>DAFTAR NILAI TRANSFER PER PERIODE
                        </strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>Perguruan Tinggi</strong></td>
                <td width="30%" align="left"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td width="20%" align="left"><strong>Tahun Ajaran</strong></td>
                <td align="left"><strong>:</strong> {{  $selMH[0]->tahun_ajaran.' - '.$selMH[0]->jenis_semester }}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{ $selMH[0]->nama_jenjang.' '.$selMH[0]->nama_jurusan }}</td>
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
                <th rowspan="2">Angkatan</th>
                <th rowspan="2">Program Studi</th>
                <th colspan="4">Matakuliah Asal </th>
                <th colspan="5">Matakuliah Diakui</th>
            </tr>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>sks</th>
                <th>Nilai Huruf </th>
                <th>Kode</th>
                <th>Nama</th>
                <th>sks</th>
                <th>Nilai Huruf </th>
                <th>Nilai Angka</th>
            </tr>
            @php $no = 1; @endphp
            @foreach($selMH as $sm)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $sm->nim }}</td>
                <td>{{ $sm->nama }}</td>
                <td align="center">{{ $sm->tahun_ajaran.' - '.$sm->jenis_semester}}</td>
                <td align="center">{{ $sm->nama_jenjang.' '.$sm->nama_jurusan }}</td>
                <td align="center">{{ $sm->kode_mk_asal }}</td>
                <td align="center">{{ $sm->nama_matakuliah_asal }}</td>
                <td align="center">{{ $sm->sks_asal }}</td>
                <td align="center">{{ $sm->nilai_huruf_asal }}</td>
                <td align="center">{{ $sm->kode_matakuliah }}</td>
                <td align="center">{{ $sm->nama_matakuliah }}</td>
                <td align="center">{{ $sm->bobot_mata_kuliah }}</td>
                <td align="center">{{ $sm->nilai_huruf_diakui }}</td>
                <td align="center">{{ $sm->nilai_angka }}</td>
            </tr>
            @endforeach 
        </tbody>
    </table>
</body>

</html>