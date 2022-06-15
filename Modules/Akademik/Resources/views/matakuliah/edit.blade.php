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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Edit data {{$title}}</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
               <li class="breadcrumb-item"><a href="{{route($page.'.index')}}">{{$title}}</a>
              </li>
              <li class="breadcrumb-item active">edit
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
            <form action="{{ route('matakuliah.update',$matakuliah->id) }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">

                    <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="kode matakuliah" name="kode_matakuliah" id="kode_matakuliah" type="text" class="validate  @error('kode_matakuliah') is-invalid @enderror" value="{{ old('kode_matakuliah',$matakuliah->kode_matakuliah) }}">
                        <label for="first_name">Kode Matakuliah<span style="color:red">*</span></label>

                        @error('kode_matakuliah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="nama matakuliah" name="nama_matakuliah" id="nama_matakuliah" type="text" class="validate  @error('nama_matakuliah') is-invalid @enderror" value="{{ old('nama_matakuliah',$matakuliah->nama_matakuliah) }}">
                        <label for="first_name">nama Matakuliah<span style="color:red">*</span></label>

                        @error('nama_matakuliah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                  <div class="input-field col s12  mt-3 mb-3">
                    <select name="programstudy_id" class="select2 browser-default">
                        <option value="">Program Study</option>
                        @foreach($programstudy as $row)
                            <option @if(old('programstudy_id',$matakuliah->programstudy_id) == $row->id) selected @endif value="{{$row->id}}">{{ $row->jenjang->nama_jenjang }}-{{$row->jurusan->nama_jurusan}}</option>
                        @endforeach
                      </select>
                        <label for="first_name">Program Study<span style="color:red">*</span></label>
                    @error('programstudy_id')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-field col s12  mt-3 mb-3">
                    <select name="jenis_mata_kuliah" class="select2 browser-default">
                        <option value="">Jenis Mata Kuliah</option>
                        <option value="1" @if(old('jenis_mata_kuliah'$matakuliah->jenis_mata_kuliah) == 1) selected @endif>Wajib Nasional</option>
                        <option value="2" @if(old('jenis_mata_kuliah'$matakuliah->jenis_mata_kuliah) == 2) selected @endif>Wajib Program Study</option>
                        <option value="3" @if(old('jenis_mata_kuliah'$matakuliah->jenis_mata_kuliah) == 3) selected @endif>Pilihan</option>
                        <option value="4" @if(old('jenis_mata_kuliah'$matakuliah->jenis_mata_kuliah) == 4) selected @endif>Peminatan</option>
                        <option value="5" @if(old('jenis_mata_kuliah'$matakuliah->jenis_mata_kuliah) == 5) selected @endif>Tugas Akhir/Skripsi/Tesis/Disertasi</option>
                      </select>
                        <label for="first_name">Jenis Mata Kuliah<span style="color:red">*</span></label>
                    @error('jenis_matakuliah')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>


                <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="bobot mata kuliah" name="bobot_mata_kuliah" id="bobot_mata_kuliah" type="text" class="validate  @error('bobot_matakuliah') is-invalid @enderror" value="{{ old('bobot_mata_kuliah', $matakuliah->bobot_mata_kuliah) }}">
                    <label for="first_name">Bobot Mata kuliah<span style="color:red">*</span></label>

                    @error('bobot_mata_kuliah')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="bobot tatap muka" name="bobot_tatap_muka" id="bobot_tatap_muka" type="text" class="validate  @error('bobot_tatap_muka') is-invalid @enderror" value="{{ old('bobot_tatap_muka',$matakuliah->bobot_tatap_muka) }}">
                    <label for="first_name">Bobot Tatap Muka<span style="color:red">*</span></label>

                    @error('bobot_tatap_muka')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="bobot pratikum" name="bobot_pratikum" id="bobot_pratikum" type="text" class="validate  @error('bobot_pratikum') is-invalid @enderror" value="{{ old('bobot_pratikum',$matakuliah->bobot_pretikum) }}">
                    <label for="first_name">Bobot Pratikum<span style="color:red">*</span></label>

                    @error('bobot_pratikum')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="bobot praktek lapangan" name="bobot_praktek_lapanagn" id="bobot_praktek_lapanagn" type="text" class="validate  @error('bobot_praktek_lapanagn') is-invalid @enderror" value="{{ old('bobot_praktek_lapanagn',$matakuliah->bobot_praktek_lapangan) }}">
                    <label for="first_name">Bobot Praktek Lapangan<span style="color:red">*</span></label>

                    @error('bobot_praktek_lapanagn')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="bobot simulasi" name="bobot_simulasi" id="bobot_simulasi" type="text" class="validate  @error('bobot_simulasi') is-invalid @enderror" value="{{ old('bobot_simulasi',$matakuliah->bobot_simulasi) }}">
                    <label for="first_name">Bobot Simulasi<span style="color:red">*</span></label>

                    @error('bobot_simulasi')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>


                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="tanggal mulai efektif " name="tanggal_mulai_efektif" id="tanggal_mulai_efektif" type="date" class="validate  @error('tanggal_mulai_efektif') is-invalid @enderror" value="{{ old('tanggal_mulai_efektif',$matakuliah->tanggal_mulai_efektif) }}">
                    <label for="first_name">Tanggal Mulai Efektif<span style="color:red">*</span></label>

                    @error('tanggal_mulai_efektif')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>


                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="tanggal akhir efektif " name="tanggal_akhir_efektif" id="tanggal_akhir_efektif" type="date" class="validate  @error('tanggal_akhir_efektif') is-invalid @enderror" value="{{ old('tanggal_akhir_efektif',$matakuliah->tanggal_akhir_efektif) }}">
                    <label for="first_name">Tanggal Akhir Efektif<span style="color:red">*</span></label>

                    @error('tanggal_akhir_efektif')
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
