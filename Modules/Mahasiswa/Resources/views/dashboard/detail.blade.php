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
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Detail Info</span></h5>
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item "><a href={{ route('dashboard') }}>dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Detail Info
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
                                <div class="col s12 center">
                                    <image style="border-radius: 10px" src="{{ asset('image_informasi/'.$info->image.'') }}"/>
                                        {{-- <p>{{ Auth::user()->name }}</p> --}}
                                        <h4>{{ $info->judul }}</h4>
                                        <p class="caption mb-0">
                                           {{ $info->content }}
                                         </p>
                                </div>
                              
                              </div>
                            </div>
                        </div>
                    </div><!-- START RIGHT SIDEBAR NAV -->
                </div>
                <div class="content-overlay"></div>
            </div>

        </div>
@endsection
