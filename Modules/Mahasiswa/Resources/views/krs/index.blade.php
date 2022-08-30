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
        </div>
@endsection
