@extends('layouts.v1')
@section('title') Dashboard Mahasiswa @endsection
@section('content')
<div class="row">
            <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
            <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Dashboard Mahasiswa</span></h5>
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
          
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <div class="card" >
                            <div class="card-content">
                              <div class="row">
                                <div class="col s2 center">
                                    <image width="100px" style="border-radius: 50px" src="{{ Auth::user()->photo }}"/>
                                        {{-- <p>{{ Auth::user()->name }}</p> --}}
                                        
                                </div>
                                <div class="col s10">
                                    <p class="caption mb-0">
                                        <h5>Selamat datang {{Auth::user()->name}}</h5> <p> Selamat Datang di Portal Akademik. Portal Akademik adalah sistem yang memungkinkan para civitas akademika UNIVERSITAS PARAMADINA untuk menerima informasi dengan lebih cepat melalui Internet. Sistem ini diharapkan dapat memberi kemudahan setiap civitas akademika untuk melakukan aktivitas-aktivitas akademik dan proses belajar mengajar. Selamat menggunakan fasilitas ini.
                                     </p>
                                </div>
                              
                              </div>
                            </div>
                        </div>
                    </div><!-- START RIGHT SIDEBAR NAV -->
                </div>
                <div class="content-overlay"></div>
            </div>

          <div class="container">
            <div class="row">
               @foreach($info as $row)
               <div class="col s12 m6 l4">
                <div class="card-panel border-radius-6 mt-10 card-animation-1">
                  <a href="#"><img class="responsive-img border-radius-8 z-depth-4 image-n-margin"
                      src="{{ asset('image_informasi/'.$row->image.'') }}" alt=""></a>
                  <h6 class="deep-purple-text text-darken-3 mt-5"><a href="#">{{ $row->judul }}</a></h6>
                  <span>{{ Str::limit($row->content, 50) }}</span>
                 
                </div>
              </div>
               @endforeach
            
               
              
               </div>

               <div class="row">
                <div class="col s12">
                 
                </div>
               </div>
          </div>

            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <div class="card" >
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s6 center">
                                        <h5>Alur Pengisian KRS</h5>
                                        <image src="{{ asset('alur_krs_mhs.jpg') }}"></image>
                                        <p><b>Catatan</b><br/>
                                            Apabila Anda menemukan kendala dalam proses pengisian KRS secara online, silahkan kirim email ke asikbeta@paramadina.ac.id</p>
                                    </div>
                                    <div class="col s6 center">
                                        <h5>Alur Pembayaran</h5>
                                        <image src="{{ asset('alur_pembayaran_mhs.png') }}" class="responsive-img"></image>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <div class="card" >
                            <div class="card-content">
                                <h5>Informasi Akademik</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         
        </div>
@endsection
