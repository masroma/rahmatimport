<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Mahasiswa</title>
</head>

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
                        <strong>DAFTAR MAHASISWA PER SEMESTER
                        </strong>
                    </font>
                    <br><br>
                </td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>Perguruan Tinggi</strong></td>
                <td width="30%" align="left"><strong>:</strong> 031041 - Universitas Paramadina</td>
                <td width="20%" align="left"><strong>Semester</strong></td>
                <td align="left"><strong>:</strong> {{ $selMH[0]->tahun_ajaran.' - '.$selMH[0]->jenis_semester}}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong> {{  $selMH[0]->nama_jenjang.' '.$selMH[0]->nama_jurusan }}</td>
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
                <th>NIK</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Tanggal Masuk</th>
                <th>Status <br>Mahasiswa</th>
                <th>Jenis <br>Pendaftaran</th>
                <th>Biaya Masuk</th>
                <th>Jenis<br>Kelamin</th>
                <th>Tempat,Tanggal Lahir</th>
                <th>Agama</th>
                <th>Alamat</th>
            </tr>
            @php $no = 1; @endphp
            @foreach($selMH as $sm)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $sm->nim }}</td>
                <td>{{ (string)$sm->ktp }}</td>
                <td>{{ $sm->nama }}</td>
                <td>{{ $sm->nama_jurusan }}</td>
                <td align="center">{{ date('d F Y', strtotime($sm->tanggal_masuk)) }}</td>
                <td align="center">{{ $sm->status_mahasiswa }}</td>
                <td align="center">{{ $sm->jenis_pendaftaran }}</td>
                <td align="center">{{ $sm->pembiayaan_awal }}</td>
                <td align="center">{{ ($sm->jenis_kelamin == 'laki-laki' ? 'L' : 'P') }}</td>
                <td align="center"> <span style="text-transform:capitalize;">{{ $sm->tempat_lahir }},</span> {{ date('d F Y', strtotime($sm->tanggal_lahir)) }} </td>
                <td align="center">{{ $sm->agama }}</td>
                <td align="center" style="text-transform:capitalize;">{{ $sm->jalan }}</td>
            </tr>
            @endforeach            
        </tbody>
    </table>
</body>

</html>