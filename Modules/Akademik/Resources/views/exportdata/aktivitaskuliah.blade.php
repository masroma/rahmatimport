<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Aktivitas Perkuliahan Mahasiswa</title>
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
                        <strong>AKTIVITAS PERKULIAHAN MAHASISWA PER PERIODE</strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>Perguruan Tinggi</strong></td>
                <td width="30%" align="left"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td width="20%" align="left"><strong>Tahun Ajaran</strong></td>
                <td align="left"><strong>:</strong> {{ $selAKM[0]->tahun_ajaran.' - '.$selAKM[0]->jenis_semester }}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{ $selAKM[0]->nama_jenjang.' '.$selAKM[0]->nama_jurusan }}</td>
                <td align="left"><strong>Data Per Tanggal</strong></td>
                <td align="left"><strong>:</strong> {{ date('d F Y') }}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Status <br>Mahasiswa</th>
                <th>IPS</th>
                <th>Jumlah sks<br>Semester</th>
                <th>IPK</th>
                <th>Jumlah sks Total</th>
                <th>Biaya Kuliah</th>
            </tr>
            @php $no = 1; @endphp
            @foreach($selAKM as $sakm)
            <tr>
                <td align="center">{{ $no++ }}</td>
                <td align="center">{{ $sakm->nim }}</td>
                <td>{{ $sakm->nama }}</td>
                <td>{{ $sakm->nama_jenjang.' '.$sakm->nama_jurusan }}</td>
                <td align="center">{{ $sakm->status_mahasiswa }}</td>
                <td align="center">{{ number_format((float)$sakm->ips, 2, '.', '')  }}</td>
                <td align="center">{{ $sakm->jumlah_sks_semester }}</td>
                <td align="center">{{ number_format((float)$sakm->ipk, 2, '.', '')  }}</td>
                <td align="center">{{ $sakm->sks_total }}</td>
                <td align="center">{{ $sakm->biaya_kuliah }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>



</body>

</html>