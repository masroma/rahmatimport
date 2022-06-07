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
            <h4 class="card-title">{{$kampus->nama_kampus}} - {{$kampus->cabang_kampus}}</h4>

         </div>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
           <div class="row" id="main-view">
              <div class="col s12">
                 <ul class="tabs tab-demo z-depth-1">
                    <li class="tab col m3"><a class="active" href="#test1">Profile </a></li>
                    <li class="tab col m3"><a href="#test2">Alamat Kampus</a></li>
                    <li class="tab col m3"><a href="#test3">Informasi </a></li>
                    <li class="tab col m3"><a href="#test4">Akta Pendirian</a></li>
                 </ul>
              </div>
              <div class="col s12">
                 <div id="test1" class="col s6">
                    <table>

                        <tr>
                            <td >Kode Kampus</td>
                            <td >{{$kampus->kode_kampus}}</td>
                        </tr>
                        <tr>
                            <td >Cabang Kampus</td>
                            <td >{{$kampus->cabang_kampus}}</td>
                        </tr>
                        <tr>
                            <td >Telephone</td>
                            <td >{{$kampus->telephone}}</td>
                        </tr>
                        <tr>
                            <td >Email</td>
                            <td >{{$kampus->email}}</td>
                        </tr>
                        <tr>
                            <td >Faximile</td>
                            <td >{{$kampus->faximile}}</td>
                        </tr>
                        <tr>
                            <td >Website</td>
                            <td >{{$kampus->website}}</td>
                        </tr>
                    </table>
                 </div>
                 <div id="test2" class="col s6">
                    <table>

                        <tr>
                            <td >Nama Jalan</td>
                            <td >{{$kampus->Address->jalan}}</td>
                        </tr>
                        <tr>
                            <td >Provinsi</td>
                            <td >@if($kampus->Address->Provinsi){{ $kampus->Address->Provinsi->name }}@endif</td>
                        </tr>
                        <tr>
                            <td >Kota</td>
                            <td >@if($kampus->Address->Kota){{ $kampus->Address->Kota->name }}@endif</td>
                        </tr>
                        <tr>
                            <td >Kecamatan</td>
                            <td >@if($kampus->Address->Kecamatan){{ $kampus->Address->Kecamatan->name }}@endif</td>
                        </tr>
                        <tr>
                            <td >Kelurahan</td>
                            <td >@if($kampus->Address->Kecamatan){{ $kampus->Address->Kelurahan->name }}@endif</td>
                        </tr>
                        <tr>
                            <td >Kode Pos</td>
                            <td >{{$kampus->Address->kode_pos}}</td>
                        </tr>
                        <tr>
                            <td >RT</td>
                            <td >{{$kampus->Address->rt}}</td>
                        </tr>
                        <tr>
                            <td >RW</td>
                            <td >{{$kampus->Address->rw}}</td>
                        </tr>
                        <tr>
                            <td >Longitude</td>
                            <td >{{$kampus->Address->longitude}}</td>
                        </tr>
                        <tr>
                            <td >Latitude</td>
                            <td >{{$kampus->Address->latitude}}</td>
                        </tr>
                        <tr>
                            <td >Google Map</td>
                            <td >{{$kampus->Address->google_map}}</td>
                        </tr>

                    </table>
                 </div>
                 <div id="test3" class="col s6">
                    <table>

                        <tr>
                            <td >Bank</td>
                            <td >{{$kampus->Detail->bank}}</td>
                        </tr>
                        <tr>
                            <td >Unit Cabang</td>
                            <td >{{$kampus->Detail->unit_cabang}}</td>
                        </tr>
                        <tr>
                            <td >No Rekening</td>
                            <td >{{$kampus->Detail->no_rekening}}</td>
                        </tr>
                        <tr>
                            <td >MBS</td>
                            <td >{{$kampus->Detail->mbs}}</td>
                        </tr>
                        <tr>
                            <td >Luas Tanah Milik</td>
                            <td >{{$kampus->Detail->luas_tanah_milik}} m</td>
                        </tr>
                        <tr>
                            <td >Luas Tanah Bukan Milik</td>
                            <td >{{$kampus->Detail->luas_tanah_bukan_milik}} m</td>
                        </tr>
                    </table>
                 </div>
                 <div id="test4" class="col s6">
                    <table>

                        <tr>
                            <td >No SK Pendirian</td>
                            <td >{{$kampus->Akta->no_sk_pendirian}}</td>
                        </tr>
                        <tr>
                            <td >Tanggal SK Pendirian</td>
                            <td >{{\Carbon\Carbon::parse($kampus->Akta->tanggal_sk_pendirian)->isoFormat('dddd, D MMMM Y')}}</td>
                        </tr>
                        <tr>
                            <td >Status Kepemilikan</td>
                            <td >{{$kampus->Akta->status_kepemilikan}}</td>
                        </tr>
                        <tr>
                            <td >Status Perguruan Tinggi</td>
                            <td >{{$kampus->Akta->status_kepemilikan}}</td>
                        </tr>
                        <tr>
                            <td >SK Izin Operasional</td>
                            <td >{{$kampus->Akta->sk_izin_operasional}}</td>
                        </tr>
                        <tr>
                            <td >Tanggal Izin Operasional</td>
                            <td >{{\Carbon\Carbon::parse($kampus->Akta->tanggal_izin_operasional)->isoFormat('dddd, D MMMM Y')}}</td>
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
