<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Mahasiswa Lulus  / DO</title>
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
                        <strong>DAFTAR MAHASISWA LULUS / DO PER PERIODE

                        </strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>Perguruan Tinggi</strong></td>
                <td width="30%" align="left"><strong>:</strong> 031041 - Universitas Paramadina</td>

                <td width="20%" align="left"><strong>Tahun Ajaran</strong></td>
                <td align="left"><strong>:</strong> {{ $selMHLD[0]->tahun_ajaran.' - '.$selMHLD[0]->jenis_semester }}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{ $selMHLD[0]->nama_jenjang.' '.$selMHLD[0]->nama_jurusan }}</td>

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
                <th>L/P</th>
                <th>Status</th>
                <th>Tanggal Keluar</th>
                <th>Nomor Ijazah</th>
                <th>Keterangan</th>                
            </tr>
            @php $no = 1; @endphp
            @foreach($selMHLD as $smld)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $smld->nim }}</td>                
                <td>{{ $smld->nama }}</td>
                <td>{{ $smld->nama_jenjang.' '.$smld->nama_jurusan }}</td>
                <td align="center">{{ ($smld->jenis_kelamin == 'laki-laki' ? 'L' : 'P') }}</td>
                <td align="center">{{ ( $smld->jeniskeluar_id == 1 ? 'Lulus': 'Dikeluarkan' ) }}</td>
                <td align="center">{{ date('d F Y', strtotime($smld->tanggal_keluat)) }}</td>
                <td align="center">{{ $smld->no_ijazah }}</td>
                <td align="center">{{ $smld->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>