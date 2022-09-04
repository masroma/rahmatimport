<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CETAK KARTU RENCANA STUDY DIAMBIL</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"> --}}
  
  </head>
  <body>

    <div class="container" align="center" >
        <img src="{{ public_path('baru-logo-upm.png') }}" alt="logo paramadina" width="200px">
        <h2>Kartu Rencana Study</h2>
         <p><b>Semester {{ $semester->jenis_semester }} , Tahun Ajaran  {{ $semester->tahunajaran->tahun_ajaran }}</b></p>

         <table  width="80%" >
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{ $mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Program Study</td>
                <td>:</td>
                <td>{{ $mahasiswa->Riwayatpendidikan->programstudy->jurusan->nama_jurusan }}</td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>:</td>
                <td>{{ $semester->jenis_semester }} {{ $semester->tahunajaran->tahun_ajaran }}</td>
            </tr>
           
        </table> 

       <div style="margin-bottom: 50px"></div>
         <table id="page-length-options" class="display" width="100%" border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Matakuliah</th>
                    <th>Jadwal</th>
                    <th>SKS</th>
                  
                   
                </tr>
            </thead>
            <tbody>
                @php $totalsks = 0 @endphp
                @php $no = 1; @endphp
                @foreach($krs as $row)
                <tr>
                    <td align="center">{{ $no++ }}</td>
                    <td align="center">{{ $row->kelas->nama_kelas }}{{ $row->kelas->kode }}</td>
                    <td align="center">{{ $row->matakuliah->nama_matakuliah }}</td>
                    <td align="center">
                        @if($row->kelas->jadwal)
                        {{ ucwords($row->kelas->jadwal->hari) }}, {{\Carbon\Carbon::parse($row->kelas->jadwal->jam_awal)->format('H:i') }} - {{\Carbon\Carbon::parse($row->kelas->jadwal->jam_akhir)->format('H:i') }}
                        @else
                        -
                        @endif
                    </td>
                    <td align="center">{{ number_format($row->matakuliah->bobot_mata_kuliah)}}</td>
                   
                   
                </tr>

                @php 
                $totalsks +=  $row->matakuliah->bobot_mata_kuliah;
            @endphp
         
                @endforeach
                <tr>
                    <th colspan="4" align="right">Jumlah SKS yang diambil &nbsp;</th>
                    <th colspan="1" align="center">{{ $totalsks }}</th>
                </tr>
            </tbody>
        </table> 

        <div style="margin-bottom: 50px"></div>
        <table width="100%">
            <tr>
               
                <td align="center" width="50%">
                    <div class="col-3 text-center">
                        <p style="margin-bottom: 70px">Nama Mahasiswa <br/></p>
                        <p class="mt-5">{{ $mahasiswa->nama }}</p>
                    </div>
                </td>
                <td align="center">
                    <div class="col-3 text-center">
                        <p style="margin-bottom: 50px">Universitas Paramadina , {{ $mahasiswa->Riwayatpendidikan->Kampus->cabang_kampus }}<br/>{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
                        <p class="mt-5">Ketua Program Study</p>
                    </div>
                </td>
            </tr>
        </table> 
    </div>

   
   
  </body>
</html>
