@extends('layouts.v1')
@section('title') {{$page}} @endsection
@section('content')

<?php
use App\Models\Menu;
?>
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
            <form action="{{ route('role.store') }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">
                  <div class="input-field col s12">
                    <input placeholder="Name" name="name" id="name" type="text" class="validate  @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    <label for="first_name">Name</label>
                    @error('name')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="col s12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2">Menu Name</th>
                                    <th colspan="4"  class="text-center">Permission</th>
                                </tr>
                                <tr>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($menus as $menuAdmin)
                                {
                                    $menu_admin_id = $menuAdmin->id;
                                    $link = $menuAdmin->link;

                                    if($link != '#')
                                    {
                                        ?>
                                        <tr>
                                            <td>{{ $menuAdmin->name }}</td>
                                            @foreach (json_decode($menuAdmin->action) as $act)
                                            <td class="text-center">
                                                <label>
                                                <input type="checkbox" name="permission[]"  value="{{$act}}" data-valuetwo="1"/>
                                                <span></span>
                                              </label></td>
                                        @endforeach
                                        </tr>
                                        <?php
                                    }
                                    else
                                    {
                                        $dataMenuAdminChild = Menu::where('parent_id', $menu_admin_id)->orderBy('order', 'asc')->get();
                                        {
                                            foreach($dataMenuAdminChild as $menuAdminChild)
                                            {
                                                ?>
                                                <tr>
                                                    <td>{{ $menuAdminChild->name }}</td>
                                                    @foreach (json_decode($menuAdminChild->action) as $act)

                                                        <td class="text-center">
                                                            <label>
                                                            <input type="checkbox" name="permission[]"  value="{{$menuAdminChild->id}}-{{$menuAdminChild->name}}-{{$act}}" />

                                                            <span>{{$act}}</span>
                                                          </label></td>
                                                    @endforeach
                                                    {{-- <td class="text-center">@if(in_array("create", json_decode($menuAdminChild->action))) <input type="checkbox" name="action[]" value="create" /> @endif </td> --}}
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
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
