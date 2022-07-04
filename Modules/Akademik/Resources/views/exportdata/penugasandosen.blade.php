<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Penugasan Dosen</title>
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
                        <strong>DAFTAR PENUGASAN DOSEN PER PERIODE</strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>Perguruan Tinggi</strong></td>
                <td width="30%" align="left"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td width="20%" align="left"><strong>Tahun Ajaran</strong></td>
                <td align="left"><strong>:</strong> {{  $selDSN[0]->tahun_ajaran.' - '.$selDSN[0]->jenis_semester }}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{ $selDSN[0]->nama_jenjang.' '.$selDSN[0]->nama_jurusan }}</td>
                <td align="left"><strong>Data Per Tanggal</strong></td>
                <td align="left"><strong>:</strong> {{ date('d F Y') }}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <th>No</th>
                <th>NIDN</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>L/P</th>
                <th>Tempat,Tanggal Lahir</th>
                <th>Agama</th>
            </tr>
            @php $no = 1; @endphp
            @foreach($selDSN as $sd)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $sd->nidn }}</td>
                <td>{{ $sd->nama_dosen }}</td>
                <td>{{ $sd->nama_jenjang.' '.$sd->nama_jurusan }}</td>
                <td align="center">{{ ($sd->jenis_kelamin == 'laki-laki' ? 'L' : 'P') }}</td>
                <td align="center"> <span style="text-transform:capitalize;">{{ $sd->tempat_lahir }},</span> {{ date('d F Y', strtotime($sd->tanggal_lahir)) }} </td>
                <td align="center">{{ $sd->agama }}</td>
            </tr>
            @endforeach    
        </tbody>
    </table>



</body>

</html>