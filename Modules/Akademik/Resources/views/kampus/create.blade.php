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
            <form action="{{ route($page.'.store') }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">

                  <div class="input-field col s12">
                    <input placeholder="kode_kampus" name="kode_kampus" id="kode_kampus" type="text" class="validate  @error('kode_kampus') is-invalid @enderror" value="{{ old('kode_kampus') }}">
                    <label for="first_name">Kode Kampus</label>

                    @error('kode_kampus')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s12">
                    <input placeholder="cabang_kampus" name="cabang_kampus" id="cabang_kampus" type="text" class="validate  @error('cabang_kampus') is-invalid @enderror" value="{{ old('cabang_kampus') }}">
                    <label for="first_name">Cabang Kampus</label>

                    @error('cabang_kampus')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s12">
                    <input placeholder="telephone" name="telephone" id="telephone" type="number" class="validate  @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                    <label for="first_name">Telephone</label>
                    @error('telephone')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="faximile" name="faximile" id="faximile" type="text" class="validate  @error('faximile') is-invalid @enderror" value="{{ old('faximile') }}">
                    <label for="first_name">Faximile</label>
                    @error('faximile')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="email" name="email" id="email" type="text" class="validate  @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    <label for="first_name">email</label>
                    @error('email')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="website" name="website" id="website" type="text" class="validate  @error('email') is-invalid @enderror" value="{{ old('website') }}">
                    <label for="first_name">website</label>
                    @error('website')
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
