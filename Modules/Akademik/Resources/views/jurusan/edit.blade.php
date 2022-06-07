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
        <form action="{{ route('jurusan.update',[$jurusan->id]) }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">
                  <div class="input-field col s12">
                    <input placeholder="Nama jurusan" name="nama_jurusan" id="nama_jurusan" type="text" class="validate  @error('nama_jurusan') is-invalid @enderror" value="{{ old('nama_jurusan',$jurusan->nama_jurusan) }}">
                    <label for="first_name">Nama jurusan</label>
                    @error('nama_jurusan')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>


                  <div class="input-field col s12">
                    <select name="fakultas_id" id="fakultas_id" class="validate @error('fakultas_id') is-invalid @enderror">
                        <option value="" disabled selected>Fakultas</option>
                        <option value="none">none</option>
                        @foreach($fakultas as $key)
                            <option  {{ old('fakultas_id', $jurusan->fakultas_id) == $key->id ? 'selected' : '' }}  value="{{$key->id}}">{{$key->nama_fakultas}}</option>
                        @endforeach
                    </select>
                    <label for="first_name">Fakultas</label>
                    @error('fakultas_id')
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
