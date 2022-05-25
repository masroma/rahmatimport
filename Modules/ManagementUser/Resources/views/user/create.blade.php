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
            <form action="{{ route('user.store') }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">
                  <div class="input-field col s12">
                    <input placeholder="name" name="name" id="name" type="text" class="validate  @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    <label for="first_name">Name</label>
                    @error('name')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s12">
                    <input placeholder="email" name="email" id="email" type="text" class="validate" value="{{ old('email') }}">
                    <label for="first_name">Email</label>
                    @error('email')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s12">
                    <input placeholder="password" name="password" id="password" type="password" class="validate" value="{{ old('password') }}">
                    <label for="first_name">Password</label>
                    @error('password')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s12">
                    <input id="password-confirm" type="password" class="validate" name="password_confirmation" value="{{ old('password') }}">
                    <label for="first_name">Password</label>
                    @error('password')
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
