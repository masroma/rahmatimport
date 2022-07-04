<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Aktivitas Mengajar Dosen</title>
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
                        <strong>AKTIVITAS MENGAJAR DOSEN PER PERIODE</strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>Perguruan Tinggi</strong></td>
                <td width="30%" align="left"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td width="20%" align="left"><strong>Tahun Ajaran</strong></td>
                <td align="left"><strong>:</strong> {{ $selAMD[0]->tahun_ajaran.' - '.$selAMD[0]->jenis_semester }}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{ $selAMD[0]->nama_jenjang.' '.$selAMD[0]->nama_jurusan }}</td>
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
                <th rowspan="2">Kelas</th>
                <th rowspan="2">Bobot (sks)</th>
                <th rowspan="2">Bobot Ajar <br>Dosen (sks)</th>
                <th colspan="2">Jumlah Pertemuan</th>
            </tr>
            <tr>
                <th>Rencana</th>
                <th>Realisasi</th>
            </tr>
            @php $no = 1; @endphp
            @foreach($selAMD as $samd)
            <tr>
                <td align="center">{{ $no++ }}</td>
                <td>{{ $samd->nidn }}</td>
                <td>{{ $samd->nama_dosen }}</td>
                <td>{{ $samd->nama_jenjang.' '.$samd->nama_jurusan }}</td>
                <td align="center">{{ $samd->kode_matakuliah }}</td>
                <td align="center">{{ $samd->nama_matakuliah }}</td>
                <td align="center">{{ $samd->nama_kelas }}</td>
                <td align="center">{{  number_format((float)$samd->bobot_mata_kuliah, 2, '.', '')  }}</td>
                <td align="center">{{  number_format((float)$samd->bobot_sks, 2, '.', '')  }}</td>
                <td align="center">{{ $samd->jumlah_rencana_pertemuan }}</td>
                <td align="center">{{ $samd->jumlah_realisasi_pertemuan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>



</body>

</html>