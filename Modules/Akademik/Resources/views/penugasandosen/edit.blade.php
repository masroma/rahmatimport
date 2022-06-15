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
            <form action="{{ route('penugasandosen.update',$penugasandosen->id) }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">


                  <div class="input-field col s12  mt-3 mb-3">
                    <select name="kampus_id" class="select2 browser-default">
                        <option value="">Cabang Kampus</option>
                        @foreach($kampus as $row)
                            <option @if(old('kampus_id',$penugasandosen->kampus_id) == $row->id) selected @endif value="{{$row->id}}">{{ $row->nama_kampus }}-{{$row->cabang_kampus}}</option>
                        @endforeach
                      </select>
                        <label for="first_name">Cabang Kampus<span style="color:red">*</span></label>
                    @error('kampus_idy')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-field col s12  mt-3 mb-3">
                    <select name="dosen_id" class="select2 browser-default">
                        <option value="">Nama Dosen</option>
                        @foreach($dosen as $row)
                            <option @if(old('dosen_id',$penugasandosen->dosen_id) == $row->id) selected @endif value="{{$row->id}}">{{$row->nama_dosen}}</option>
                        @endforeach
                      </select>
                        <label for="first_name">Nama Dosen<span style="color:red">*</span></label>
                    @error('dosen_id')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-field col s12  mt-3 mb-3">
                    <select name="jurusan_id" class="select2 browser-default">
                        <option value="">Jurusan</option>
                        @foreach($jurusan as $row)
                            <option @if(old('jurusan_id',$penugasandosen->jurusan_id) == $row->id) selected @endif value="{{$row->id}}">{{$row->nama_jurusan}}</option>
                        @endforeach
                      </select>
                        <label for="first_name">Nama Jurusan<span style="color:red">*</span></label>
                    @error('jurusan_id')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-field col s12  mt-3 mb-3">
                    <select name="tahunajaran_id" class="select2 browser-default">
                        <option value="">Tahun Ajaran</option>
                        @foreach($tahunajaran as $row)
                            <option @if(old('tahunajaran_id',$penugasandosen->tahunajaran_id) == $row->id) selected @endif value="{{$row->id}}">{{$row->tahun_ajaran}}</option>
                        @endforeach
                      </select>
                        <label for="first_name">Tahun Ajaran<span style="color:red">*</span></label>
                    @error('tahunajaran_id')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="no surat tugas" name="no_surat_tugas" id="no_surat_tugas" type="text" class="validate  @error('no_surat_tugas') is-invalid @enderror" value="{{ old('no_surat_tugas',$penugasandosen->no_surat_tugas) }}">
                    <label for="first_name">No Surat Tugas<span style="color:red">*</span></label>

                    @error('no_surat_tugas')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="tanggal surat tugas" name="tanggal_surat_tugas" id="tanggal_surat_tugas" type="date" class="validate  @error('tanggal_surat_tugas') is-invalid @enderror" value="{{ old('tanggal_surat_tugas',$penugasandosen->tanggal_surat_tugas) }}">
                    <label for="first_name">Tanggal Surat Tugas<span style="color:red">*</span></label>

                    @error('tanggal_surat_tugas')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="tmt surat tugas" name="tmt_surat_tugas" id="tmt_surat_tugas" type="date" class="validate  @error('tmt_surat_tugas') is-invalid @enderror" value="{{ old('tmt_surat_tugas',$penugasandosen->TMT_surat_tugas) }}">
                    <label for="first_name">TMT Surat Tugas<span style="color:red">*</span></label>

                    @error('tmt_surat_tugas')
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
