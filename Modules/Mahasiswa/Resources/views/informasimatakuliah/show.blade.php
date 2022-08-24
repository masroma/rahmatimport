@extends('layouts.v1')
@section('title') Detil Kelas @endsection
@section('content')
<div class="row">
            <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
            <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Detil Kelas</span></h5>
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item active">Detil Kelas
                                </li>
                            </ol>
                        </div>
                        <div class="col s2 m6 l6">

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <div class="card" >
                            <div class="card-content">
                              <h5>Detil Kelas</h5>
                              <p><b>Keterangan</b></p>
                              <p>Detil Kelas merupakan informasi detil mengenai kelas-kelas yang ditawarkan untuk matakuliah tertentu. Pembagian kelas ini diatur berdasarkan program studi, kurikulum, serta aturan-aturan akademis lainnya. </p>
                            </div>
                        </div>
                    </div><!-- START RIGHT SIDEBAR NAV -->
                </div>

                <div class="container">
                    <div class="section">
                        <div class="card" >
                            <div class="card-content">
                                <h5>Kelas : {{ $perkuliahan->kelasperkuliahan->nama_kelas }}{{ $perkuliahan->kelasperkuliahan->kode }}</h5>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                            <th>Ruang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Perkuliahan</td>
                                            <td>{{ $perkuliahan->hari }}</td>
                                            <td>{{ $perkuliahan->jam_awal }} - {{ $perkuliahan->jam_akhir }} </td>
                                            <td>{{ $perkuliahan->ruang->kode_ruang }}-{{ $perkuliahan->ruang->nama_ruang }} cabang {{ $perkuliahan->ruang->listkampus->cabang_kampus }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if($uts)
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Tanggal</th>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                            <th>Ruang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    uts
                                            <td>UTS</td>
                                            <td>{{ $uts->hari }}</td>
                                            <td>-</td>
                                            <td>{{ $uts->jam_awal }} - {{ $uts->jam_akhir }} </td>
                                            <td>{{ $uts->ruang->kode_ruang }}-{{ $uts->ruang->nama_ruang }} cabang {{ $uts->ruang->listkampus->cabang_kampus }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @endif

                                @if($uas)
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Tanggal</th>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                            <th>Ruang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        uts
                                            <td>UAS</td>
                                            <td>{{ $uas->hari }}</td>
                                            <td>-</td>
                                            <td>{{ $uas->jam_awal }} - {{ $uas->jam_akhir }} </td>
                                            <td>{{ $uas->ruang->kode_ruang }}-{{ $uas->ruang->nama_ruang }} cabang {{ $uas->ruang->listkampus->cabang_kampus }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="section">
                        <div class="card">
                            <div class="card-content">
                                <h5>Detil Kelas Berdasarkan Program Study</h5>
                                <table border="1">
                                    <tbody>
                                     <tr>
                                         <th>Program Study</th>
                                         <td>{{ $perkuliahan->kelasperkuliahan->programstudy->jurusan->nama_jurusan }}</td>
                                     </tr>
                                     <tr>
                                        <th>Kode Matakuliah</th>
                                        <td>{{ $perkuliahan->kelasperkuliahan->matakuliah->kode_matakuliah }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Matakuliah</th>
                                        <td>{{ $perkuliahan->kelasperkuliahan->matakuliah->nama_matakuliah }}</td>
                                    </tr>
                                    <tr>
                                        <th>Semester</th>
                                        <td>{{ $data['semester'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bobot SKS</th>
                                        <td>{{ $data['sks'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nilai Minimum Kelulusan</th>
                                        <td>{{ $perkuliahan->kelasperkuliahan->matakuliah->nama_matakuliah }}</td>
                                    </tr>
                                    <tr>
                                        <th>Persyaratan</th>
                                        <td>{{ $perkuliahan->kelasperkuliahan->matakuliah->nama_matakuliah }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sifat Matakuliah</th>
                                        <td>{{ $perkuliahan->kelasperkuliahan->matakuliah->nama_matakuliah }}</td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>{{ $perkuliahan->kelasperkuliahan->matakuliah->nama_matakuliah }}</td>
                                    </tr>
                                    </tbody>
                                 </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-overlay"></div>
            </div>

         
        </div>
@endsection
