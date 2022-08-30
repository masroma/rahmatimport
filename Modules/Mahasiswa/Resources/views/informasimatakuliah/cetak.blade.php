<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CETAK MATAKULIAH YANG DI SARAKAN UNTUK DIAMBIL</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"> --}}
  
  </head>
  <body>
    <div class="container my-5">
       <div class="row">
        <table width="100%">
            <tr>
                <td> 
                    <div class="col-9 text-center">
                    <p class="fw-bolder"><b>UNIVERSITAS PARAMADINA</b></p>
                    </div>
                </td>
                <td>
                    <div class="col-3 text-end">
                        <p class="fw-bolder"><b>RPM</b></p>
                        
                    </div>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td></td>
                <td  style="border-color: #000" align="right"><p> KRS ini harus diserahkan ke BAAK <br/>paling lambat tanggal: 28/07/2022 </p></td>
            </tr>
        </table>
       
       
       </div>

       <div class="row">
        <div class="col-7">
            <table class="table" width="100%">
                <tr>
                    <th align="left">Semester / TA</th>
                    <td>:</td>
                    <td>Semester {{ $semester->jenis_semester }} {{ $semester->tahunajaran->tahun_ajaran }}</td>
                </tr>
                <tr>
                    <th align="left">Program Study</th>
                    <td>:</td>
                    <td>{{ $mahasiswa->mahasiswa->Riwayatpendidikan->Programstudy->jenjang->nama_jenjang }}-{{ $mahasiswa->mahasiswa->Riwayatpendidikan->Programstudy->jurusan->nama_jurusan }}</td>
                </tr>
                <tr>
                    <th align="left">NPM</th>
                    <td>:</td>
                    <td>{{ $mahasiswa->mahasiswa->nim }}</td>
                </tr>

                <tr>
                    <th align="left">NAMA</th>
                    <td>:</td>
                    <td>{{ $mahasiswa->mahasiswa->nama }}</td>
                </tr>
            </table>
        </div>
       </div>

       <div class="row">
        <div class="col-12">
            <p>Beri Tanda Checklist pada kotak didepan Kode MK untuk Mata Kuliah yang diambil</p>
            <hr/>
        </div>
       </div>

       @if($matakuliahkurikulum)
       @foreach ($matakuliahkurikulum->matakuliahsemester as $row)
       <div class="row mt-3">
        <div class="col-12">
            <p class="fw-bolder"><b>Semester  {{ $row->semester }}</b></p>
        </div>
            @php $no = 1 @endphp
            @php $total_sks = 0 @endphp
            @foreach ($matakuliahkurikulum->matakuliah as $a)
                @if($a->semester == $row->semester)
                   
                        <div class="col-12">
                            <table class="table table-bordered" width="100%" border="1" style="border-color: #000">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th></th>
                                        <th>Kode MK</th>
                                        <th>Matakuliah</th>
                                        <th>SKS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td align="center">{{ $no++ }}</td>
                                        <td align="center">{{ " " }}</td>
                                        <td align="center">{{ $a->matakuliah->kode_matakuliah }}</td>
                                        <td align="center">{{ $a->matakuliah->nama_matakuliah }}</td>
                                        <td align="center">{{ $a->matakuliah->bobot_mata_kuliah}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td  colspan="4">Total SKS</td>
                                        <th >{{ $total_sks += $a->matakuliah->bobot_mata_kuliah }}</th>
                                    </tr>
                                </tfoot>
                            
                            </table>
                        </div>
                 
                @endif
            @endforeach
       </div>
       @endforeach
       @endif

       <br/>
       <br/>


       <div class="row mt-3">
        <hr/>
        <table width="100%" >
            <tr>
                <td >
                    <div class="col-6">
                        <ul>
                            <li>Lembar 1 : BAAK </li>
                            <li>Lembar 2 : Mahasiswa</li>
                            <li>Lembar 3 : Jurusan</li>
                        </ul>
                    </div>
                </td>
                <td align="center">
                    <div class="col-3 text-center">
                        <p style="margin-bottom: 70px">Dosen Wali <br/></p>
                        <p class="mt-5">Ivonne Sartika Mangula S.T.,M.Kom</p>
                    </div>
                </td>
                <td align="center">
                    <div class="col-3 text-center">
                        <p style="margin-bottom: 50px">Universitas Paramadina , {{ $mahasiswa->mahasiswa->Riwayatpendidikan->Kampus->cabang_kampus }}<br/>{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
                        <p class="mt-5">{{ $mahasiswa->mahasiswa->nama }}</p>
                    </div>
                </td>
            </tr>
        </table>
       
       
      
       </div>
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script> --}}
  </body>
</html>
