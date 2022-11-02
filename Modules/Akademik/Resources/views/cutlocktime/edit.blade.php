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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Edit data {{$page}}</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
               <li class="breadcrumb-item"><a href="{{route($page.'.index')}}">{{$page}}</a>
              </li>
              <li class="breadcrumb-item active">create
              </li>
            </ol>
          </div>
          <div class="col s2 m6 l6">
              {{-- <a class="btn dropdown-settings waves-effect waves-light breadcrumbs-btn right" href="{{route('user.create')}}"  id="tombol-tambah" ><i class="material-telephones left">add_circle_outline</i>Tambah</a> --}}
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
            <form action="{{ route($page.'.update',$cutlocktime->id) }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf

                  <div class="input-field col s6">
                   <select name="key"  class="select2 browser-default">
                    <option  {{ old('key',$cutlocktime->key) == 'krs' ? 'selected' : '' }}  value="krs">KRS</option>
                    <option  {{ old('key',$cutlocktime->key) == 'input_nilai' ? 'selected' : '' }}  value="input_nilai">Input Nilai</option>
                   </select>
                    <label for="first_name">Type  <span style="color:red">*</span></label>

                    @error('cabang_kampus')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s6">
                    <select name="tahunajaran_id" class="select2 browser-default">
                        <option value="" disabled selected>Tahun Ajaran</option>
                        @foreach($tahunajaran as $row)
                            <option  {{ old('tahunajaran_id',$cutlocktime->tahunajaran_id) == $row->id ? 'selected' : '' }}  value="{{$row->id}}">{{ $row->jenis_semester .' '}} -
                            @foreach($row->tahun_ajarantest as $s)
                                {{ $s->tahun_ajaran }}
                            @endforeach

                        </option>
                        @endforeach
                    </select>
                     <label for="first_name">Semester <span style="color:red">*</span></label>

                     @error('cabang_kampus')
                     <span class="red-text text-darken-2">{{ $message }}</small>
                     @enderror
                </div>

                <div class="input-field col s6">
                    <input type="date" name="start_tanggal" class="validate  @error('start_tanggal') is-invalid @enderror"  value="{{ old('start_tanggal',$cutlocktime->start_tanggal) }}" >
                    <label for="first_name">Start Tanggal <span style="color:red">*</span></label>
                    @error('start_tanggal')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-field col s6">
                    <input type="time" name="start_time" class="validate  @error('start_time') is-invalid @enderror"   value="{{ old('start_time',$cutlocktime->start_time) }}" >
                    <label for="first_name">Start Jam <span style="color:red">*</span></label>
                    @error('start_time')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-field col s6">
                    <input type="date" name="end_tanggal" class="validate  @error('end_tanggal') is-invalid @enderror"   value="{{ old('end_tanggal',$cutlocktime->end_tanggal) }}" >
                    <label for="first_name">End Tanggal <span style="color:red">*</span></label>
                    @error('end_tanggal')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-field col s6">
                    <input type="time" name="end_time" class="validate  @error('end_time') is-invalid @enderror"  value="{{ old('end_time',$cutlocktime->end_time) }}" >
                    <label for="end_name">End Jam <span style="color:red">*</span></label>
                    @error('end_time')
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


@endsection
