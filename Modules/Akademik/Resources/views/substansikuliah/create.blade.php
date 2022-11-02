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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Tambah data {{$title}}</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
               <li class="breadcrumb-item"><a href="{{route($page.'.index')}}">{{$title}}</a>
              </li>
              <li class="breadcrumb-item active">create
              </li>
            </ol>
          </div>
          <div class="col s2 m6 l6">
              {{-- <a class="btn dropdown-settings waves-effect waves-light breadcrumbs-btn right" href="{{route('user.create')}}"  id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a> --}}
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
            <form action="{{ route('substansikuliah.store') }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">

                    <div class="input-field col s4 ">
                        <input placeholder="Nama Substansi" name="nama_substansi" id="nama_sunstansi" type="text" class="validate m-0" value="{{ old('nama_substansi') }}">
                        <label for="first_name">Nama Substansi<span style="color:red">*</span></label>

                        @error('nama_substansi')
                        <small class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>



                  <div class="input-field col s4 ">
                    <select name="programstudy_id" class="select2 browser-default">
                        <option value="">Program Study</option>
                        @foreach($programstudy as $row)
                            @foreach($row->jurusans as $r)
                                <option @if(old('programstudy_id') == $row->id) selected @endif value="{{$row->id}}">
                                @foreach ($row->jenjangs as $j)
                                    {{ $j->nama_jenjang }}-{{$r->nama_jurusan}}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                      </select>
                        <label for="first_name">Program Study<span style="color:red">*</span></label>
                    @error('programstudy_id')
                    <small class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>



                <div class="input-field col s4 ">
                    <input placeholder="bobot mata kuliah" name="bobot_mata_kuliah" id="bobot_mata_kuliah" type="text" class="validate  @error('bobot_matakuliah') is-invalid @enderror" value="{{ old('bobot_mata_kuliah') }}">
                    <label for="first_name">Bobot Mata kuliah</label>

                    @error('bobot_mata_kuliah')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s6 ">
                    <input placeholder="bobot tatap muka" name="bobot_tatap_muka" id="bobot_tatap_muka" type="text" class="validate  @error('bobot_tatap_muka') is-invalid @enderror" value="{{ old('bobot_tatap_muka') }}">
                    <label for="first_name">Bobot Tatap Muka</label>

                    @error('bobot_tatap_muka')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s6  ">
                    <input placeholder="bobot pratikum" name="bobot_pratikum" id="bobot_pratikum" type="text" class="validate  @error('bobot_pratikum') is-invalid @enderror" value="{{ old('bobot_pratikum') }}">
                    <label for="first_name">Bobot Pratikum</label>

                    @error('bobot_pratikum')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s6  ">
                    <input placeholder="bobot praktek lapangan" name="bobot_praktek_lapanagn" id="bobot_praktek_lapanagn" type="text" class="validate  @error('bobot_praktek_lapanagn') is-invalid @enderror" value="{{ old('bobot_praktek_lapanagn') }}">
                    <label for="first_name">Bobot Praktek Lapangan</label>

                    @error('bobot_praktek_lapanagn')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s6  ">
                    <input placeholder="bobot simulasi" name="bobot_simulasi" id="bobot_simulasi" type="text" class="validate  @error('bobot_simulasi') is-invalid @enderror" value="{{ old('bobot_simulasi') }}">
                    <label for="first_name">Bobot Simulasi</label>

                    @error('bobot_simulasi')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>




                  <div class="input-field col s12">
                  <button type="submit" class="waves-effect waves-light btn-small"><i class="material-icons right">send</i>save</button>
                  <a href={{route($page.'.index')}} class="waves-effect purple darken-1 btn-small"><i class="material-icons left">keyboard_arrow_left</i>back</a>
                  </div>
                </div>
            </form>
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
