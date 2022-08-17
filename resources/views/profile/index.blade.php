@extends('layouts.v1')
@section('title') Profile @endsection
@section('content')
<div class="row">
            <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
            <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Profile</span></h5>
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item active">Profile
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
                        <div class="card">
                            <div class="card-content">
                                <h5>Data Profile</h5>
                               <div class="row">
                                <div class="col s10">
                                    <table>
                                        <tr><th>Photo</th><td><image style="border-radius: 50%" src="{{ $user->photo ?? '' }}"></image></td></tr>
                                        <tr><th>NIM</th><td>{{ $mahasiswa->nim ?? '' }}</td></tr>
                                        <tr><th>Nama Lengkap</th><td>{{ $user->name }}</td></tr>
                                        <tr><th>Tempat Tanggal Lahir</th><td>{{ $mahasiswa->tempat_lahir }},{{\Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->isoFormat('D MMMM Y')}}</td></tr>
                                        <tr><th>Alamat</th><td>{{ $mahasiswa->detail->jalan }}, {{ $mahasiswa->detail->rt }}/{{ $mahasiswa->detail->rw }},{{ $mahasiswa->detail->provinsi->name }}, {{ $mahasiswa->detail->kota->name }}, {{ $mahasiswa->detail->kecamatan->name }}, {{ $mahasiswa->detail->kelurahan->name }} {{ $mahasiswa->detail->kode_pos }}</td></tr>
                                       
                                    </table>
                                </div>
                               
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
