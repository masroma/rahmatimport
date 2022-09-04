@extends('layouts.v1')
@section('title') Informasi Matakuliah ditawarkan @endsection
@section('content')
<div class="row">
            <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
            <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Kartu Hasil Study</span></h5>
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item active">Kartu Hasil Study
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
                              <h5>Kartu Hasil Study</h5>
                              <p><b>Keterangan</b></p>
                              <p>Kartu Hasil Studi merupakan fasilitas yang dapat digunakan untuk melihat hasil studi mahasiswa persemester. Selain dapat dilihat secara online, hasil studi ini juga dapat dicetak.  </p>
                            </div>
                        </div>
                    </div><!-- START RIGHT SIDEBAR NAV -->
                </div>
                <div class="content-overlay"></div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="section">
                            <div class="card" >
                                <div class="card-content">
                                    <table style="width:50%">
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
                                      
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="section">
                            <div class="card">
                                <div class="card-content">
                                    @foreach ($semester as $s)
                                    <h6>Semester {{ ucfirst($s->jenissemester->jenis_semester) }} {{ $s->jenissemester->tahunajaran->tahun_ajaran }} </h6>
                                    <table id="page-length-option" class="display" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kelas</th>
                                                <th>Matakuliah</th>
                                                <th>SKS</th>
                                                <th>Nilai</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                                $totalsks = 0; 
                                                $totalips = 0;
                                                $totalindex=0;

                                            @endphp
                                            @php $no = 1; @endphp
                                            @foreach($krs as $row)
                                                @if($s->jenissemester_id == $row->jenissemester_id)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $row->kelas->nama_kelas }}{{ $row->kelas->kode }}</td>
                                                        <td>{{ $row->matakuliah->nama_matakuliah }}</td>
                                                        <td>{{ $row->matakuliah->bobot_mata_kuliah}}</td>
                                                        <td>{{ $row->nilaikrs ? $row->nilaikrs->nilai_huruf : '-'}}</td>
                                                        <td>{{ $row->status }}</td>
                                                    </tr>
                                                    
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <p>Total SKS : {{ $s->NilaiIps->total_sks }}</p>
                                    <p>Nilai IPS :{{ $s->NilaiIps->ips}} </p>
                                    <div class="mt-5"></div>
                                    @endforeach
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
@endsection
