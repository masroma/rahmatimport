@extends('layouts.v1')
@section('title') {{$page}} @endsection
@section('content')
<div class="row">
    <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
      <!-- Search for small screen-->
      <div class="container">
        <div class="row">
          <div class="col s10 m6 l6">
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Detail data {{$page}}</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
               <li class="breadcrumb-item"><a href="{{route($page.'.index')}}">{{$page}}</a>
              </li>
              <li class="breadcrumb-item active">detail
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
        <div class="section section-data-tables">
<div class="card">

</div>
<!-- DataTables example -->



<!-- DataTables Row grouping -->


<!-- Page Length Options -->
<div class="row">
<div class="col s12">
  <div class="card">
    <div class="card-content">
      {{-- <h4 class="card-title">Page Length Options</h4> --}}
      <div class="row">
        <div class="col s12 m6 l10">
            <h4 class="card-title">{{$mahasiswa->nama_mahasiswa}} - {{$mahasiswa->cabang_mahasiswa}}</h4>

         </div>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
           <div class="row" id="main-view">
              <div class="col s12">
                 <ul class="tabs tab-demo z-depth-1">
                    <li class="tab col m3"><a class="active" href="#test1">Data Pribadi</a></li>
                    <li class="tab col "><a href="#test2">Alamat</a></li>
                    <li class="tab col m3"><a href="#test3">Orang Tua</a></li>
                    <li class="tab col "><a href="#test4">Wali</a></li>
                    <li class="tab col m3"><a href="#test5">Kebutuhan Khusus</a></li>
                 </ul>
              </div>
              <div class="col s12">
                 <div id="test1" class="col s6">
                    <table>

                        <tr>
                            <td >Nama</td>
                            <td >{{$mahasiswa->nama}}</td>
                        </tr>
                        <tr>
                            <td >Tempat Lahir</td>
                            <td >{{$mahasiswa->tempat_lahir}}</td>
                        </tr>
                        <tr>
                            <td >Tanggal Lahir</td>
                            <td >{{\Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->isoFormat('dddd, D MMMM Y')}}</td>
                        </tr>
                        <tr>
                            <td >Jenis Kelamin</td>
                            <td >{{$mahasiswa->jenis_kelamin}}</td>
                        </tr>
                        <tr>
                            <td >Nama Ibu</td>
                            <td >{{$mahasiswa->ibu_kandung}}</td>
                        </tr>
                        <tr>
                            <td >Agama</td>
                            <td >{{$mahasiswa->agam}}</td>
                        </tr>
                    </table>
                 </div>
                 <div id="test2" class="col s6">
                    <table>

                        <tr>
                            <td>Kewarganegaraan</td>
                            <td>{{ $mahasiswa->Detail->Kewarganegaraan->country_name }}</td>
                        </tr>
                        <tr>
                            <td >Nama Jalan</td>
                            <td >{{$mahasiswa->Detail->jalan}}</td>
                        </tr>
                        <tr>
                            <td >Provinsi</td>
                            <td >@if($mahasiswa->Detail->Provinsi){{ $mahasiswa->Detail->Provinsi->name }}@endif</td>
                        </tr>
                        <tr>
                            <td >Kota</td>
                            <td >@if($mahasiswa->Detail->Kota){{ $mahasiswa->Detail->Kota->name }}@endif</td>
                        </tr>
                        <tr>
                            <td >Kecamatan</td>
                            <td >@if($mahasiswa->Detail->Kecamatan){{ $mahasiswa->Detail->Kecamatan->name }}@endif</td>
                        </tr>
                        <tr>
                            <td >Kelurahan</td>
                            <td >@if($mahasiswa->Detail->Kecamatan){{ $mahasiswa->Detail->Kelurahan->name }}@endif</td>
                        </tr>

                        <tr>
                            <td >RT</td>
                            <td >{{$mahasiswa->Detail->rt}}</td>
                        </tr>
                        <tr>
                            <td >RW</td>
                            <td >{{$mahasiswa->Detail->rw}}</td>
                        </tr>


                    </table>
                 </div>
                 <div id="test3" class="col s12">
                    <div class="col s6">
                        <table>
                            <tr>
                                <td colspan="2"><p>Data Ayah</p></td>
                            </tr>
                            <tr>
                                <td >Nama </td>
                                <td >{{$mahasiswa->OrangTua->nama_ayah}}</td>
                            </tr>
                            <tr>
                                <td >NIK </td>
                                <td >{{$mahasiswa->OrangTua->nik_ayah}}</td>
                            </tr>
                            <tr>
                                <td >Tanggal Lahir </td>
                                <td >{{\Carbon\Carbon::parse($mahasiswa->OrangTua->tanggal_lahir_ayah)->isoFormat('dddd, D MMMM Y')}}</td>
                            </tr>
                            <tr>
                                <td >Pendidikan</td>
                                <td >{{$mahasiswa->OrangTua->pendidikan_ayah}}</td>
                            </tr>
                            <tr>
                                <td >Pekerjaan</td>
                                <td >{{$mahasiswa->OrangTua->pekerjaan_ayah}} </td>
                            </tr>
                            <tr>
                                <td >Penghasilan</td>
                                <td >{{$mahasiswa->OrangTua->penghasilan_ayah}} </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col s6">
                        <table>
                            <tr>
                                <td colspan="2"><p>Data Ibu</p></td>
                            </tr>
                            <tr>
                                <td >Nama </td>
                                <td >{{$mahasiswa->OrangTua->nama_ibu}}</td>
                            </tr>
                            <tr>
                                <td >NIK </td>
                                <td >{{$mahasiswa->OrangTua->nik_ibu}}</td>
                            </tr>
                            <tr>
                                <td >Tanggal Lahir </td>
                                <td >{{\Carbon\Carbon::parse($mahasiswa->OrangTua->tanggal_lahir_ibu)->isoFormat('dddd, D MMMM Y')}}</td>
                            </tr>
                            <tr>
                                <td >Pendidikan</td>
                                <td >{{$mahasiswa->OrangTua->pendidikan_ibu}}</td>
                            </tr>
                            <tr>
                                <td >Pekerjaan</td>
                                <td >{{$mahasiswa->OrangTua->pekerjaan_ibu}} </td>
                            </tr>
                            <tr>
                                <td >Penghasilan</td>
                                <td >{{$mahasiswa->OrangTua->penghasilan_ibu}} </td>
                            </tr>
                        </table>
                    </div>
                 </div>
                 <div id="test4" class="col s6">
                    <table>

                        <tr>
                            <td >Nama </td>
                            <td >{{$mahasiswa->Wali->nama_wali}}</td>
                        </tr>
                        <tr>
                            <td >Tanggal Lahir </td>
                            <td >{{\Carbon\Carbon::parse($mahasiswa->Wali->tanggal_lahir_wali)->isoFormat('dddd, D MMMM Y')}}</td>
                        </tr>
                        <tr>
                            <td >Pendidikan</td>
                            <td >{{$mahasiswa->Wali->pendidikan_wali}}</td>
                        </tr>
                        <tr>
                            <td >Pekerjaan</td>
                            <td >{{$mahasiswa->Wali->pekerjaan_wali}} </td>
                        </tr>
                        <tr>
                            <td >Penghasilan</td>
                            <td >{{$mahasiswa->Wali->penghasilan_wali}} </td>
                        </tr>
                    </table>
                 </div>
                 <div id="test5" class="col s6">
                    <table>

                        <tr>
                            <td >Kebutuhan Khusus </td>
                            <td >@if($mahasiswa->KebutuhanKhusus->kebutuhan_khusus == "y") Iya @else Tidak @endif</td>
                        </tr>
                    </table>
                 </div>
              </div>
           </div>
        </div>
     </div>
    </div>
  </div>
</div>
</div>



</div><!-- START RIGHT SIDEBAR NAV -->

</div>
      </div>
      <div class="content-overlay"></div>
    </div>
  </div>



  @stop
  @section('script')
  <script>


    </script>

@endsection
