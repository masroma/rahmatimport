<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Jadwal Perkuliahan</title>
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
                        <strong>JADWAL PERKULIAHAN PER PERIODE</strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>Perguruan Tinggi</strong></td>
                <td width="30%" align="left"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td width="20%" align="left"><strong>Tahun Ajaran</strong></td>
                <td align="left"><strong>:</strong> {{ $selKP[0]->tahun_ajaran.' - '.$selKP[0]->jenis_semester }}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{ $selKP[0]->nama_jenjang.' '.$selKP[0]->nama_jurusan }}</td>
                <td align="left"><strong>Data Per Tanggal</strong></td>
                <td align="left"><strong>:</strong> {{ date('d F Y') }}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <th>No</th>
                <th>Program Study</th>
                <th>Kode MataKuliah</th>
                <th>Nama MataKuliah</th>
                <th>Nama Kelas</th>
                <th>Bobot sks Kelas</th>
                <th>Bobot sks Dosen</th>
                <th>Keterangan</th>
                <th>Periode</th>
            </tr>
            @php $no = 1; @endphp
            @foreach($selKP as $skp)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $skp->nama_jenjang.' '.$skp->nama_jurusan }}</td>
                <td align="center">{{ $skp->kode_matakuliah }}</td>
                <td>{{ $skp->nama_matakuliah }}</td>
                <td align="center">{{ $skp->nama_kelas }}</td>
                <td align="right">{{  number_format((float)$skp->bobot_mata_kuliah, 2, '.', '')  }}</td>
                <td align="right">{{  number_format((float)$skp->bobot_sks, 2, '.', '')  }}</td>            
                <td align="right"></td>
                <td align="center">{{ $skp->tahun_ajaran.' - '.$skp->jenis_semester }}</td>                
            </tr>
            @endforeach
        </tbody>
    </table>



</body>

</html>