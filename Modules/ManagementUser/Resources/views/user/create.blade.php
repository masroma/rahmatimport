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
            <form class="col s12">
                <div class="row">
                  <div class="input-field col s12">
                    <input placeholder="Placeholder" name="name" id="name" type="text" class="validate">
                    <label for="first_name">Name</label>
                  </div>
                  <div class="input-field col s12">
                    <input placeholder="Placeholder" name="email" id="email" type="text" class="validate">
                    <label for="first_name">Email</label>
                  </div>
                  <div class="input-field col s12">
                    <input placeholder="Placeholder" name="password" id="password" type="text" class="validate">
                    <label for="first_name">Password</label>
                  </div>
                  <div class="input-field col s12">
                    <input placeholder="Placeholder" name="password" id="password" type="text" class="validate">
                    <label for="first_name">Password</label>
                  </div>
                  <div class="input-field col s12">
                  <a class="waves-effect waves-light btn-small"><i class="material-icons right">send</i>save</a>
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
