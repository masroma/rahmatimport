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
        <form action="{{ route('programstudy.update',[$programstudy->id]) }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">
                  {{-- <div class="input-field col s12">
                    <input placeholder="Nama jurusan" name="nama_program_study" id="nama_program_study" type="text" class="validate  @error('nama_program_study') is-invalid @enderror" value="{{ old('nama_program_study',$programstudy->nama_program_study) }}">
                    <label for="first_name">Nama jurusan</label>
                    @error('nama_program_study')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div> --}}

                  <div class="input-field col s12  mt-3 mb-3">
                    <select name="nama_program_study" class="select2 browser-default">
                        <option value="">Program Study / Jurusan</option>
                        @foreach($jurusan as $row)
                            <option @if(old('nama_program_study', $programstudy->nama_program_study) == $row->id) selected @endif value="{{$row->id}}">{{$row->nama_jurusan}}</option>
                        @endforeach
                      </select>
                        <label for="first_name">Nama program study<span style="color:red">*</span></label>
                    @error('nama_program_study')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                </div>


                  <div class="input-field col s12">
                    <select name="jenjang_id" id="jenjang_id" class="validate @error('jenjang_id') is-invalid @enderror">
                        <option value="" disabled selected>jenjang</option>
                        <option value="none">none</option>
                        @foreach($jenjang as $key)
                            <option  {{ old('jenjang_id', $programstudy->jenjang_id) == $key->id ? 'selected' : '' }}  value="{{$key->id}}">{{$key->nama_jenjang}}</option>
                        @endforeach
                    </select>
                    <label for="first_name">jenjang</label>
                    @error('jenjang_id')
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
