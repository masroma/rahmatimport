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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Tambah data {{$page}}</span></h5>
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

<!-- DataTables example -->



<!-- DataTables Row grouping -->


<!-- Page Length Options -->
<div class="row">
    <div class="col s12">
    <div class="card">
        <div class="card-content">
        {{-- <h4 class="card-title">Page Length Options</h4> --}}
        <div class="row">
                <form action="{{ route($page.'.store') }}" method="POST"
                enctype="multipart/form-data" class="col s12">
                @csrf
                <div class="col s12">
                    <ul class="tabs tab-demo z-depth-1">
                       <li class="tab col m3"><a class="active" href="#test1">Data Pribadi</a></li>
                       <li class="tab col m3"><a href="#test2">Alamat</a></li>
                       <li class="tab col m3"><a href="#test3">Keluarga</a></li>
                       <li class="tab col m3"><a href="#test4">Kebutuhan Khusus</a></li>
                    </ul>
                 </div>
                 <div class="col s12 mt-3">
                    <div id="test1" class="col s12 ">
                        <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="nama" name="NIDN" id="nidn" type="text" class="validate  @error('nidn') is-invalid @enderror" value="{{ old('nidn') }}">
                            <label for="first_name">NIDN</label>

                            @error('nidn')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                        <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="nama" name="nama" id="nama" type="text" class="validate  @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                            <label for="first_name">Nama<span style="color:red">*</span></label>

                            @error('nama')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="tempat_lahir" name="tempat_lahir" id="tempat_lahir" type="text" class="validate  @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                            <label for="first_name">Tempat Lahir<span style="color:red">*</span></label>

                            @error('tempat_lahir')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="tanggal_lahir" name="tanggal_lahir" id="tanggal_lahir" type="date" class="validate  @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                            <label for="first_name">Tanggal Lahir<span style="color:red">*</span></label>

                            @error('tanggal_lahir')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4  mt-2 mb-2">
                           <select name="jenis_kelamin" id="jenis_kelamin">
                               <option value="">jenis kelamin</option>
                               <option value="laki-laki" @if(old('jenis_kelamin') == 'laki-laki') selected @endif>Laki - Laki</option>
                               <option value="perempuan" @if(old('jenis_kelamin') == 'perempuan') selected @endif>Perempuan</option>
                           </select>
                            <label for="first_name">Jenis Kelamin<span style="color:red">*</span></label>

                            @error('tempat_lahir')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4  mt-2 mb-2">
                            <select name="agama" id="agama">
                                <option value="">Agama</option>
                                <option value="islam" @if(old('agama') == 'islam') selected @endif>Islam</option>
                                <option value="kristen" @if(old('agama') == 'kristen') selected @endif>Kristen</option>
                                <option value="katolik" @if(old('agama') == 'katolik') selected @endif>Katolik</option>
                                <option value="hindu" @if(old('agama') == 'hindu') selected @endif>Hindu</option>
                                <option value="budha" @if(old('agama') == 'budha') selected @endif>Budha</option>
                                <option value="konghucu" @if(old('agama') == 'konghucu') selected @endif>Konghucu</option>
                            </select>
                             <label for="first_name">Agama<span style="color:red">*</span></label>

                             @error('tempat_lahir')
                             <span class="red-text text-darken-2">{{ $message }}</small>
                             @enderror
                           </div>
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


</div><!-- START RIGHT SIDEBAR NAV -->

</div>
      </div>
      <div class="content-overlay"></div>
    </div>
  </div>





@endsection
