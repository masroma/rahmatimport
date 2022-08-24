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
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Informasi Matakuliah ditawarkan</span></h5>
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item active">Informasi Matakuliah ditawarkan
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
                              <h5>Informasi Matakuliah Yang Ditawarkan</h5>
                              <p><b>Keterangan</b></p>
                              <p>Informasi Matakuliah Ditawarkan berisi seluruh matakuliah yang ditawarkan pada semester aktif. Dari seluruh matakuliah yang terdapat pada daftar, setiap matakuliah mempunyai aturan tersendiri bergantung pada program studi, kurikulum, dan aturan akademik lainnya. Untuk lebih jelasnya, anda dapat melihat detil kelas. </p>
                            </div>
                        </div>
                    </div><!-- START RIGHT SIDEBAR NAV -->
                </div>
                <div class="content-overlay"></div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col s12">
                       <ul class="collapsible collapsible-accordion">
                        @if($matakuliahkurikulum)
                         @foreach ($matakuliahkurikulum->matakuliahsemester as $row)
                         <li>
                           <div class="collapsible-header"><i class="material-icons">radio_button_checked</i> Semester {{ $row->semester }}</div>
                           <div class="collapsible-body">
                            <table id="page-length-option" class="display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Matakuliah</th>
                                        <th>Kelas</th>
                                        <th>Status</th>
                                        <th>SKS</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1 @endphp
                                    @foreach ($matakuliahkurikulum->matakuliah as $a)
                                   
                                    @if($a->semester == $row->semester)
                                        @foreach ($a->matakuliah->kelas as $k)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $a->matakuliah->kode_matakuliah }}</td>
                                            <td>{{ $a->matakuliah->nama_matakuliah }}</td>
                                            <td>{{ $k->nama_kelas }}{{ $k->kode }}</td>
                                            <td>{{ $a->matakuliah->jenismatakuliah->jenis_matrakuliah }}</td>
                                            <td>{{ $a->matakuliah->bobot_mata_kuliah}}</td>
                                            <td><a href="{{ route('informasimatakuliah.show',Crypt::encrypt([$k->id,'kode'=>$k->kode,'semester'=> $row->semester,"sks"=>$a->matakuliah->bobot_mata_kuliah])) }}" class="btn-floating purple darken-1 btn-small"><i class="material-icons">remove_red_eye</i></a></td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    @endforeach
                                    
                                </tbody>

                             </table>
                           </div>
                        </li>
                         @endforeach
                         @endif
                       </ul>
                    </div>
                 </div>
            </div>
        </div>
@endsection
