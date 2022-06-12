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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Edit {{$title}} Dosen</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
               <li class="breadcrumb-item"><a href="{{route('dosen.show',$pangkat->id)}}">Show Dosen</a>
              </li>
              <li class="breadcrumb-item active">Edit Riwayat Pangkat
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
            <form action="{{ route('dosen.updatepangkat',$pangkat->id) }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <input type="hidden" name="dosen_id" value="{{ $pangkat->dosen_id }}">
                <div class="row">
                  <div class="input-field col s12">
                    <input placeholder="pangkat" name="pangkat" id="pangkat" type="text" class="validate  @error('pangkat') is-invalid @enderror" value="{{ old('pangkat',$pangkat->pangkat) }}">
                    <label for="first_name">pangkat</label>
                    @error('pangkat')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="SK pangkat" name="sk_pangkat" id="sk_pangkat" type="text" class="validate  @error('sk_pangkat') is-invalid @enderror" value="{{ old('sk_pangkat',$pangkat->sk_pangkat) }}">
                    <label for="first_name">SK pangkat</label>
                    @error('sk_pangkat')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="Tanggal SK pangkat" name="tanggal_sk_pangkat" id="tanggal_sk_pangkat" type="date" class="validate  @error('tanggal_sk_pangkat') is-invalid @enderror" value="{{ old('tanggal_sk_pangkat',$pangkat->tanggal_sk_pangkat) }}">
                    <label for="first_name">Tanggal SK pangkat</label>
                    @error('tanggal_sk_pangkat')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="TMT pangkat" name="tmt_pangkat" id="tmt_pangkat" type="text" class="validate  @error('sk_pangkat') is-invalid @enderror" value="{{ old('tmt_pangkat', $pangkat->TMT_pangkat) }}">
                    <label for="first_name">TMT pangkat</label>
                    @error('tmt_pangkat')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="masa kerja" name="masa_kerja" id="masa_kerja" type="text" class="validate  @error('masa_kerja') is-invalid @enderror" value="{{ old('masa_kerja',$pangkat->masa_kerja) }}">
                    <label for="first_name">Masa Kerja</label>
                    @error('masa_kerja')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                  <button type="submit" class="waves-effect waves-light btn-small"><i class="material-icons right">send</i>save</button>
                  <a href="{{route('dosen.show',$pangkat->dosen_id)}}"class="waves-effect purple darken-1 btn-small"><i class="material-icons left">keyboard_arrow_left</i>back</a>
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
