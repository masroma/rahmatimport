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
              <li class="breadcrumb-item active">Tambah Riwayat Sertifikasi
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
            <form action="{{ route('dosen.storeriwayatsertifikasi') }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <input type="hidden" name="dosen_id" value="{{ $id }}">
                <div class="row">
                  <div class="input-field col s12">
                    <input placeholder="no peserta" name="no_pesertan" id="no_peserta" type="text" class="validate  @error('pangkat') is-invalid @enderror" value="{{ old('no_peserta') }}">
                    <label for="first_name">No Peserta</label>
                    @error('no_peserta')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="bidang study" name="bidang_study" id="bidang_study" type="text" class="validate  @error('bidang_study') is-invalid @enderror" value="{{ old('bidang_study') }}">
                    <label for="first_name">Bidang Study</label>
                    @error('bidang_study')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="Jenis Sertifikasi" name="jenis_sertifikasi" id="jenis_sertifikasi" type="text" class="validate  @error('jenis_sertifikasi') is-invalid @enderror" value="{{ old('jenis_sertifikasi') }}">
                    <label for="first_name">Jenis Sertifikasi</label>
                    @error('jenis_sertifikasi')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="Tahun sertifikasi" name="tahun_sertifikasi" id="tahun_sertifikasi" type="text" class="validate  @error('tahun_sertifikasi') is-invalid @enderror" value="{{ old('tahun_sertifikasi') }}">
                    <label for="first_name">Tahun</label>
                    @error('tahun_sertifikasi')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="No SK sertifikasi" name="no_sk_sertifikasi" id="no_sk_sertifikasi" type="text" class="validate  @error('no_sk_sertifikasi') is-invalid @enderror" value="{{ old('no_sk_sertifikasi') }}">
                    <label for="first_name">Tahun</label>
                    @error('no_sk_sertifikasi')
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
