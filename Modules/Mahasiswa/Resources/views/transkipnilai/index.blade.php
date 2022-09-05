@extends('layouts.v1')
@section('title') Transkip Nilai @endsection
@section('content')
<div class="row">
            <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
            <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Transkip Nilai</span></h5>
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item active">Transkip Nilai 
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
                              <h5>Transkip Nilai</h5>
                              <p><b>Keterangan</b></p>
                              <p>Transkrip Nilai berisi informasi nilai hasil studi mahasiswa mulai dari semester awal sampai dengan semester terakhir mahasiswa. Transkrip ini dapat dicetak dalam bentuk transkrip satu halaman.  </p>
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
                                    
                                    <table id="page-length-option" class="display" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Semester</th>
                                                <th>Kelas</th>
                                                <th>Matakuliah</th>
                                                <th>SKS</th>
                                                <th>Nilai</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                            @php 
                                                $no = 1;
                                                $totalsks = 0;
                                            @endphp
                                            
                                            @foreach($krs as $row)
                                               
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $row->jenissemester->jenis_semester }} {{ $row->jenissemester->tahunajaran->tahun_ajaran }}</td>
                                                        <td>{{ $row->kelas->nama_kelas }}{{ $row->kelas->kode }}</td>
                                                        <td>{{ $row->matakuliah->nama_matakuliah }}</td>
                                                        <td>{{ $row->matakuliah->bobot_mata_kuliah}}</td>
                                                        <td>{{ $row->nilaikrs ? $row->nilaikrs->nilai_huruf : '-'}}</td>
                                                        <td>{{ $row->status }}</td>
                                                    </tr>
                                                    
                                              @php $totalsks += $row->matakuliah->bobot_mata_kuliah @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row mt-5">
                                        
                                        <div class="col s3 ">
                                            
                                                <p>total sks yang diambil : {{ $totalsks }}</p>
                                                <p>total IP Komulatif : {{ $semester->NilaiIps->ipk}}</p>
                                                <p>Total Matakuliah yang diambil : {{ $krs->count() }}</p>
                                           
                                        </div>
                                        <div class="col s9">
                                            <h6>Skala Nilai</h6>
                                           <table>
                                            <tr>
                                                @foreach ($skalanilai as $sk)
                                                   
                                                <td>{{ $sk->nilai_huruf }} = {{ $sk->nilai_index }}</td>
                                           
                                        @endforeach
                                            </tr>
                                              
                                           </table>
                                           
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="mt-5"></div>
                                  
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
@endsection
