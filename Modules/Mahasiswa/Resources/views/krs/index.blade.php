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
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Kartu Rencana Study</span></h5>
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item active">Kartu Rencana Study
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
                              <h5>Kartu Rencana Study</h5>
                              <p><b>Keterangan</b></p>
                              <p>Kartu Rencana Studi merupakan fasilitas pengisian KRS secara online. Fasilitas KRS Online ini hanya dapat digunakan pada saat masa KRS atau masa revisi KRS. Mahasiswa dapat memilih matakuliah yang ingin diambil bersesuaian dengan jatah sks yang dimiliki dan matakuliah yang ditawarkan. Setelah melakukan pengisian KRS mahasiswa dapat mencetak KRS tersebut agar dapat ditandatangani oleh dosen pembimbingnya masing-masing.  </p>
                            </div>
                        </div>
                    </div><!-- START RIGHT SIDEBAR NAV -->
                </div>
                <div class="content-overlay"></div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <a class="btn waves-effect waves-light breadcrumbs-btn left mb-1"  href="{{ route('informasimatakuliah.cetak') }}"   id="tombol-tambah" ><i class="material-icons left">local_printshop</i>Cetak</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                     
                    </div>
                 </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="section">
                            <div class="card" >
                                <div class="card-content">
                        <table>
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
                            <tr>
                                <td>Maksimum SKS</td>
                                <td>:</td>
                                <td> IPS anda {{ $ips }} , jatah SKS semester ini adalah {{ $sks }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

           @if(($date >= $cutoff->start_tanggal) && ($date <= $cutoff->end_tanggal))
                @if(($date >= $cutoff->start_time) && ($date <= $cutoff->end_time))
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="section">
                                    <div class="card">
                                        <div class="card-content">
                                            <p>halo bener tanggal di antara 2 tanggal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="section">
                                <div class="card">
                                    <div class="card-content">
                                        <p>Mohon maaf waktu pengisian KRS telah ditutup, silahkan hubungi akademik untuk info lebih lanjut</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
           @else
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="section">
                                <div class="card">
                                    <div class="card-content">
                                        <p>halo tanggal tidak ada</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           @endif
{{-- 
                        <table>
                           <thead>
                            <tr>
                                <th>No</th>
                                <th>Matakuliah</th>
                                <th>SKS</th>
                                <th>Nilai Bobot</th>
                                <th>Huruf bobot</th>
                                <th>total</th>
                            </tr>
                           </thead>
                           <tbody>
                            @php 
                            $no = 1; 
                            $totalsks = 0;
                            $totalip = 0;
                            $totalnilaiindex = 0;
                             @endphp

                            @foreach($krssemesterkemarin as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->matakuliah->nama_matakuliah }}</td>
                                    <td>{{ $row->matakuliah->bobot_mata_kuliah }}</td>
                                    
                                    <td>@foreach ($row->Mahasiswa->Riwayatpendidikan->ProgramStudy->jurusan->SkalaNilai as $sn)
                                        @if($sn->nilai_huruf == $row->NilaiKrs->nilai_huruf)
                                            {{ $sn->nilai_index }}
                                        @endif
                                    @endforeach</td>
                                    <td>{{ $row->NilaiKrs->nilai_huruf }}</td>
                                    <td>@foreach ($row->Mahasiswa->Riwayatpendidikan->ProgramStudy->jurusan->SkalaNilai as $sn)
                                        @if($sn->nilai_huruf == $row->NilaiKrs->nilai_huruf)
                                            {{ $sn->nilai_index * $row->matakuliah->bobot_mata_kuliah }}
                                        @endif
                                    @endforeach</td>
                                </tr>
                                @php $totalsks += $row->matakuliah->bobot_mata_kuliah @endphp
                                @foreach ($row->Mahasiswa->Riwayatpendidikan->ProgramStudy->jurusan->SkalaNilai as $sn)
                                        @if($sn->nilai_huruf == $row->NilaiKrs->nilai_huruf)
                                           @php $totalnilaiindex += $sn->nilai_index * $row->matakuliah->bobot_mata_kuliah @endphp
                                        @endif
                                    @endforeach
                              
                            @endforeach

                            <tr>
                                <td colspan="2">Total SKS</td>
                                <td >{{ $totalsks }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Total Nilai index</td>
                                <td >{{  $totalnilaiindex }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">IPS</td>
                                <td>{{ number_format($totalnilaiindex / $totalsks, 2) }}</td>
                            </tr>
                           
                           </tbody>
                        </table> --}}
                    </div>
                </div>
            </div>
        </div>
@endsection
