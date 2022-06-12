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
              <li class="breadcrumb-item active">Tambah Riwayat Penelitian
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
            <form action="{{ route('dosen.storeriwayatpenelitian') }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <input type="hidden" name="dosen_id" value="{{ $id }}">
                <div class="row">
                  <div class="input-field col s12">
                    <input placeholder="judul penelitian" name="judul_penelitian" id="judul_penelitian" type="text" class="validate  @error('pangkat') is-invalid @enderror" value="{{ old('judul_penelitian') }}">
                    <label for="first_name">Judul penelitian</label>
                    @error('judul_penelitian')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="bidang ilmu" name="bidang_ilmu" id="bidang_ilmu" type="text" class="validate  @error('bidang_ilmu') is-invalid @enderror" value="{{ old('bidang_ilmu') }}">
                    <label for="first_name">Bidang Ilmu</label>
                    @error('bidang_ilmu')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="Lembaga" name="lembaga" id="lembaga" type="text" class="validate  @error('lembaga') is-invalid @enderror" value="{{ old('lembaga') }}">
                    <label for="first_name">Lembaga</label>
                    @error('lembaga')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="Tahun" name="tahun" id="tahun" type="text" class="validate  @error('tahun') is-invalid @enderror" value="{{ old('tahun') }}">
                    <label for="first_name">Tahun</label>
                    @error('tahun')
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
