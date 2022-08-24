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
            <form action="{{ route('kelasperkuliahan.store') }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">
                <div class="row">
                    <div class="input-field col s6 ">
                        <select name="programstudy_id" class="select2 browser-default">
                            <option value="">Program Study</option>
                            @foreach($programstudy as $row)
                                <option @if(old('programstudy_id') == $row->id) selected @endif value="{{$row->id}}">{{ $row->jenjang->nama_jenjang }}-{{$row->jurusan->nama_jurusan}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Program Study<span style="color:red">*</span></label>
                        @error('programstudy_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="input-field col s6">
                        <select name="semester_id" class="select2 browser-default">
                            <option value="">Semester</option>
                            @foreach($jenissemester as $row)
                                <option @if(old('semester_id') == $row->id) selected @endif value="{{$row->id}}">{{ $row->Tahunajaran->tahun_ajaran }}-{{$row->jenis_semester}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Semester<span style="color:red">*</span></label>
                        @error('semester_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s6">
                        <select name="matakuliah_id" class="select2 browser-default">
                            <option value="">Mata Kuliah</option>
                            @foreach($matakuliah as $row)
                                <option @if(old('matakuliah_id') == $row->id) selected @endif value="{{$row->id}}">{{ $row->kode_matakuliah }}-{{$row->nama_matakuliah}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Matakuliah<span style="color:red">*</span></label>
                        @error('matakuliah_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="input-field col s6">
                        <input placeholder="nama kelas " name="nama_kelas" id="nama_kelas" type="text" class="validate  @error('nama_kelas') is-invalid @enderror" value="{{ old('nama_kelas') }}">
                        <label for="first_name">Nama Kelas</label>

                        @error('nama_kelas')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                </div>

                <div class="row">
                    <div class="input-field col s6">
                        <select name="lingkup" class="select2 browser-default">
                            <option value="">lingkup</option>
                            <option value="internal" @if(old('lingkup') == 'internal') selected @endif>Internal</option>
                            <option value="external"  @if(old('lingkup') == 'external') selected @endif>External</option>
                            <option value="campuran"  @if(old('lingkup') == 'campuran') selected @endif>Campuran</option>
                          </select>
                            <label for="first_name">Lingkup</label>
                        @error('lingkup')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="input-field col s6">
                        <select name="mode_kuliah" class="select2 browser-default">
                            <option value="">Mode Kuliah</option>
                            <option value="online" @if(old('mode_kuliah') == 'online') selected @endif>Online</option>
                            <option value="offline"  @if(old('mode_kuliah') == 'offline') selected @endif>Offline</option>
                            <option value="campuran"  @if(old('mode_kuliah') == 'campuran') selected @endif>Campuran</option>
                          </select>
                            <label for="first_name">Mode Kuliah</label>
                        @error('mode_kuliah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="row">
                  <div class="input-field col s4">
                    <input placeholder="tanggal mulai efektif " name="tanggal_mulai_kuliah" id="tanggal_mulai_kuliah" type="date" class="validate  @error('tanggal_mulai_kuliah') is-invalid @enderror" value="{{ old('tanggal_mulai_kuliah') }}">
                    <label for="first_name">Tanggal Mulai kuliah</label>

                    @error('tanggal_mulai_efektif')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s4 ">
                    <input placeholder="tanggal akhir kuliah " name="tanggal_akhir_kuliah" id="tanggal_akhir_kuliah" type="date" class="validate  @error('tanggal_akhir_efektif') is-invalid @enderror" value="{{ old('tanggal_akhir_kuliah') }}">
                    <label for="first_name">Tanggal Akhir kuliah</label>

                    @error('tanggal_akhir_kuliah')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s4 my-5">

                    <div class="d-flex">
                     <label for="first_name">Type Mahasiswa Yang Bisa mengikuti Kelas ini selain reguler</label>
                     @foreach($typemahasiswa as $m)
                        <p>
                         <label>
                             <input type="checkbox" name="type_mahasiswa[]"  value="{{ old('type_mahasiswa',$m->type_mahasiswa) }}"/>
                             <span>kelas {{ $m->type_mahasiswa }}</span>
                           </label>
                        </p>
                        @endforeach
                    </div>

                     @error('type_mahasiswa')
                     <span class="red-text text-darken-2">{{ $message }}</small>
                     @enderror
                </div>


                </div>

                <div class="row">
                   

                    <div class="input-field col s6">
                        <select name="jenis_kelas" class="select2 browser-default">
                            <option value="">jenis_kelas</option>
                            <option value="reguler" @if(old('jenis_kelas') == 'reguler') selected @endif>Reguler</option>
                            <option value="paralel"  @if(old('jenis_kelas') == 'paralel') selected @endif>Paralel</option>

                          </select>
                            <label for="first_name">Jenis Kelas</label>
                        @error('jenis_kelas')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                        <div class="input-field col s6">
                            <input placeholder="Generate Kelas" name="jumlah_generate_kelas" id="jumlah_generate_kelas" type="number" class="validate  @error('nama_kelas') is-invalid @enderror" value="{{ old('jumlah_generate_kelas') }}">
                            <label for="first_name">Jumlah Generate Kelas</label>

                            @error('jumlah_generate_kelas')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>

                </div>

                <div class="row">
                  <div class="input-field col s6">
                    <input placeholder="min peserta kelas" name="min_peserta" id=""min_peserta" type="number" class="validate  @error('min_peserta') is-invalid @enderror" value="{{ old('min_peserta') }}">
                    <label for="first_name">Minimal Peserta Kelas</label>

                    @error('min_peserta')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s6">
                    <input placeholder="max peserta kelas" name="max_peserta" id=""max_peserta" type="number" class="validate  @error('max_peserta') is-invalid @enderror" value="{{ old('max_peserta') }}">
                    <label for="first_name">Max Peserta Kelas</label>

                    @error('min_peserta')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
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
