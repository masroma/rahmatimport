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
            <form action="{{ route('kurikulum.store') }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">
                    <div class="input-field col s6  mt-2 mb-2">
                        <input placeholder="Nama Kurikulum" name="nama_kurikulum" id="nama_kurikulum" type="text" class="validate  @error('nama_kurikulum') is-invalid @enderror" value="{{ old('nama_kurikulum') }}">
                        <label for="first_name">Nama Kurikulum<span style="color:red">*</span></label>
                        @error('nama_kurikulum')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                  <div class="input-field col s6  mt-2 mb-2">
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
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>
                </div>
                <div class="row">
                    <div class="input-field col s6 mt-2 mb-2">
                        <input placeholder="jumlah bobot mata kuliah pilihan" name="jumlah_bobot_mata_kuliah_pilihan" id="jumlah_bobot_mata_kuliah_pilihan" type="text" class="validate  @error('jumlah_bobot_mata_kuliah_pilihan') is-invalid @enderror" value="{{ old('jumlah_bobot_mata_kuliah_pilihan') }}">
                        <label for="first_name">Jumlah bobot mata kuliah pilihan<span style="color:red">*</span></label>

                        @error('jumlah_bobot_mata_kuliah_pilihan')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="input-field col s6  mt-2 mb-2">
                        <select name="masa_berlaku" class="select2 browser-default">
                            <option value="">Mulai Berlaku</option>
                            @foreach($jenissemester as $row)
                                <option @if(old('masa_berlaku') == $row->id) selected @endif value="{{$row->id}}">

                                @foreach($row->tahun_ajarans as $ta)
                                  {{ $ta->tahun_ajaran }}

                                @endforeach


                                    -
                              {{$row->jenis_semester}}
                                </option>
                            @endforeach
                          </select>
                            <label for="first_name">Mulai Berlaku<span style="color:red">*</span></label>
                        @error('masa_berlakud')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="input-field col s6  mt-2 mb-2">
                        <input placeholder="jumlah_sks" name="jumlah_sks" id="jumlah_sks" type="number" class="validate  @error('jumlah_sks') is-invalid @enderror" value="{{ old('jumlah_sks') }}" disabled>
                        <label for="first_name">jumlah sks<span style="color:red">*</span></label>

                        @error('jumlah_sks')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div> --}}

                    <div class="input-field col s6  mt-2 mb-2">
                        <input placeholder="jumlah bobot mata kuliah wajib" name="jumlah_bobot_mata_kuliah_wajib" id="jumlah_bobot_mata_kuliah_wajib" type="number" class="validate  @error('jumlah_bobot_mata_kuliah_wajib') is-invalid @enderror" value="{{ old('jumlah_bobot_mata_kuliah_wajib') }}">
                        <label for="first_name">Jumlah bobot mata kuliah wajib<span style="color:red">*</span></label>

                        @error('jumlah_bobot_mata_kuliah_wajib')
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
