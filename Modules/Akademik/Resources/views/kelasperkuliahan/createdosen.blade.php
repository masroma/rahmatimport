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
            <form action="{{ route('kelasperkuliahan.storeDosenPerkuliahan') }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">
                <div class="row">
                    <input type="hidden" name="kelasperkuliahan_id" value="{{ $id }}">
                    <div class="input-field col s6 ">
                        <select name="dosen_id" class="select2 browser-default">
                            <option value="">Dosen</option>
                            @foreach($dosen as $row)
                                <option @if(old('dosen_id') == $row->id) selected @endif value="{{$row->id}}">{{ $row->nama_dosen }}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Dosen<span style="color:red">*</span></label>
                        @error('dosen_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="input-field col s6">
                        <select name="substansi_id" class="select2 browser-default">
                            <option value="">Substansi Kuliah</option>
                            @foreach($substansi as $row)
                                <option @if(old('substansi_id') == $row->id) selected @endif value="{{$row->id}}">{{ $row->nama_sunstansi }}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Substansi kuliah</label>
                        @error('substansi_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">

                    <div class="input-field col s6">
                        <input placeholder="bobot sks" name="bobot_sks" id="bobot_sks" type="text" class="validate  @error('bobot_sks') is-invalid @enderror" value="{{ old('bobot_sks') }}">
                        <label for="first_name">Bobot SKS <span style="color:red">*</span></label>

                        @error('bobot_sks')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                    <div class="input-field col s6">
                        <input placeholder="jumlah rencana pertemuan " name="jumlah_rencana_pertemuan" id="jumlah_rencana_pertemuan" type="text" class="validate  @error('jumlah_rencana_pertemuan') is-invalid @enderror" value="{{ old('jumlah_rencana_pertemuan') }}">
                        <label for="first_name">Jumlah Rencana Pertemuan <span style="color:red">*</span></label>

                        @error('jumlah_rencana_pertemuan')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                </div>

                <div class="row">
                    <div class="input-field col s6">
                        <input placeholder="jumlah realisasi pertemuan " name="jumlah_realisasi_pertemuan" id="jumlah_realisasi_pertemuan" type="text" class="validate  @error('jumlah_realisasi_pertemuan') is-invalid @enderror" value="{{ old('jumlah_realisasi_pertemuan') }}">
                        <label for="first_name">Jumlah Realiasai Pertemuan </label>

                        @error('jumlah_realisasi_pertemuan')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>



                    <div class="input-field col s6">
                        <select name="jenis_evaluasi" class="select2 browser-default">
                            <option value="">jenis evaluasi</option>
                            <option value="kognitif/pengetahuan" @if(old('jenis_evaluasi') == 'kognitif/pengetahuan') selected @endif>Kognitif / Pengetahuan</option>
                            <option value="hasil proyek"  @if(old('jenisevaluasin') == 'hasil proyek') selected @endif>Hasil Proyek</option>
                            <option value="aktivitas partisipatif"  @if(old('jenis_evaluasi') == 'aktivitas partisipatif') selected @endif>Aktivitas Partisipatif</option>
                            <option value="evaluasi akademik"  @if(old('jenis_evaluasi') == 'evaluasi akademik') selected @endif>Evaluasi Akademik</option>
                        </select>
                            <label for="first_name">Jenis evaluas <span style="color:red">*</span>i</label>
                        @error('jenis_evaluasi')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>




                  <div class="input-field col s12">
                  <button type="submit" class="waves-effect waves-light btn-small"><i class="material-icons right">send</i>save</button>
                  <a href={{route('kelasperkuliahan.edit', $id)}} class="waves-effect purple darken-1 btn-small"><i class="material-icons left">keyboard_arrow_left</i>back</a>
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
