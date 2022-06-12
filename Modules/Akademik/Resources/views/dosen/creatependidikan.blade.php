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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Tambah {{$title}} Dosen</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
               <li class="breadcrumb-item"><a href="{{route('dosen.show',$id)}}">Show Dosen</a>
              </li>
              <li class="breadcrumb-item active">Tambah Riwayat Pendidikan
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
            <form action="{{ route('dosen.storeriwayatpendidikan') }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <input type="hidden" name="dosen_id" value="{{ $id }}">
                <div class="row">
                  <div class="input-field col s12">
                    <input placeholder="bidang_study" name="bidang_study" id="bidang_study" type="text" class="validate  @error('bidang_study') is-invalid @enderror" value="{{ old('bidang_study') }}">
                    <label for="first_name">Bidang study</label>
                    @error('bidang_study')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="jenjang" name="jenjang" id="jenjang" type="text" class="validate  @error('jenjang') is-invalid @enderror" value="{{ old('jenjang') }}">
                    <label for="first_name">Jenjang</label>
                    @error('jenjang')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="Gelar" name="gelar" id="gelar" type="text" class="validate  @error('gelar') is-invalid @enderror" value="{{ old('gelar') }}">
                    <label for="first_name">Gelar</label>
                    @error('gelar')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="perguruan_tinggi" name="perguruan_tinggi" id="perguruan_tinggi" type="text" class="validate  @error('perguruan_tinggi') is-invalid @enderror" value="{{ old('perguruan_tinggi') }}">
                    <label for="first_name">perguruan_tinggi</label>
                    @error('perguruan_tinggi')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="fakultas" name="fakultas" id="fakultas" type="text" class="validate  @error('fakultas') is-invalid @enderror" value="{{ old('fakultas') }}">
                    <label for="first_name">Fakultas</label>
                    @error('fakultas')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="SKS" name="sks" id="sks" type="text" class="validate  @error('sks') is-invalid @enderror" value="{{ old('sks') }}">
                    <label for="first_name">SKS</label>
                    @error('sks')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="Tahun lulus" name="tahun_lulus" id="tahun_lulus" type="text" class="validate  @error('tahun_lulus') is-invalid @enderror" value="{{ old('tahun_lulus') }}">
                    <label for="first_name">Tahun lulus</label>
                    @error('tahun_lulus')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="IPK" name="ipk" id="ipk" type="text" class="validate  @error('ipk') is-invalid @enderror" value="{{ old('sks') }}">
                    <label for="first_name">IPK</label>
                    @error('ipk')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                  <button type="submit" class="waves-effect waves-light btn-small"><i class="material-icons right">send</i>save</button>
                  <a href="{{route('dosen.show',$id)}}"class="waves-effect purple darken-1 btn-small"><i class="material-icons left">keyboard_arrow_left</i>back</a>
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
