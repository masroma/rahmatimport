@extends('layouts.v1')
@section('title') Dashboard @endsection
@section('content')
<div class="row">
            <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
            <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Dashboard</span></h5>
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item active">Dashboard
                                </li>
                            </ol>
                        </div>
                        <div class="col s2 m6 l6">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col s3">
                <div class="container">
                    <div class="section">
                        <div class="card">
                            <div class="card-content center">
                                <image width="100px" style="border-radius: 50px" src="{{ Auth::user()->photo }}"/>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s9">
                <div class="container">
                    <div class="section">
                        <div class="card" >
                            <div class="card-content">
                                <p class="caption mb-0">
                                    <h5>Selamat datang {{Auth::user()->name}}</h5> <p> Selamat Datang di Portal Akademik. Portal Akademik adalah sistem yang memungkinkan para civitas akademika UNIVERSITAS PARAMADINA untuk menerima informasi dengan lebih cepat melalui Internet. Sistem ini diharapkan dapat memberi kemudahan setiap civitas akademika untuk melakukan aktivitas-aktivitas akademik dan proses belajar mengajar. Selamat menggunakan fasilitas ini.
                                 </p>
                            </div>
                        </div>
                    </div><!-- START RIGHT SIDEBAR NAV -->
                </div>
                <div class="content-overlay"></div>
            </div>
            <div class="col s12">
                <div class="container">
                    <div class="card">
                        <div class="card-content">
                            <h5>Mahasiswa Universitas Paramadina</h5>
                            <table id="page-length-option" class="display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Cabang</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Target </th>
                                        <th>Realisasi </th>
                                    </tr>
                                </thead>
                              </table>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
@endsection
