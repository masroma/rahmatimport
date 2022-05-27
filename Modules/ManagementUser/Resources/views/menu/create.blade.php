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
            <form action="{{ route($page.'.store') }}" method="POST"
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
                    <input placeholder="link" name="link" id="link" type="text" class="validate  @error('link') is-invalid @enderror" value="{{ old('link') }}">
                    <label for="first_name">Link</label>

                    @error('link')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s12">
                    <input placeholder="icon" name="icon" id="icon" type="text" class="validate  @error('icon') is-invalid @enderror" value="{{ old('icon') }}">
                    <label for="first_name">Icon</label>
                    {{-- <span><a href="" class="text-darken-2">klik untuk melihat list icon</a></span> --}}
                    @error('icon')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s12">
                    <select name="position">
                        <option value="" disabled selected>Position</option>
                        <option {{ old('position') == 'none' ? 'selected' : '' }} value="none">single menu</option>
                        <option  {{ old('position') == 'parent' ? 'selected' : '' }}  value="parent">parent menu</option>
                        <option  {{ old('position') == 'children' ? 'selected' : '' }}  value="children">children menu</option>
                      </select>

                    <label for="first_name">Position</label>
                    @error('position')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <select name="parent_id">
                        <option value="" disabled selected>Parent</option>
                        <option value="0">none</option>
                        @foreach($parentmenu as $menuparent)
                            <option  {{ old('parent_id') == $menuparent->id ? 'selected' : '' }}  value="{{$menuparent->id}}">{{$menuparent->name}}</option>
                        @endforeach
                      </select>
                        <label for="first_name">Parent</label>
                    @error('parent_id')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <select name="key_permission">
                        <option value="" disabled selected>Permission Key</option>
                        <option value="none">none</option>
                        @foreach($keypermission as $key)
                            <option  {{ old('parent_id') == $key->key ? 'selected' : '' }}  value="{{$key->key}}">{{$key->key}}</option>
                        @endforeach
                      </select>
                        <label for="first_name">Permission</label>
                    @error('key_permission')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12 my-5">

                   <div class="d-flex">
                    <label for="first_name">Action</label>
                       <p>
                        <label>
                            <input type="checkbox" name="action[]" value="create" value="create"/>
                            <span>Create</span>
                          </label>
                       </p>

                       <p>
                        <label>
                            <input type="checkbox" name="action[]" value="edit" />
                            <span>Edit</span>
                          </label>
                       </p>
                       <p>
                        <label>
                            <input type="checkbox" name="action[]" value="view" />
                            <span>View</span>
                          </label>
                       </p>
                       <p>
                        <label>
                            <input type="checkbox" name="action[]" value="delete"/>
                            <span>Delete</span>
                          </label>
                       </p>
                   </div>

                    @error('action')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <input placeholder="order" name="order" id="order" type="number" class="validate  @error('order') is-invalid @enderror" value="{{ old('order') }}">
                    <label for="first_name">Order</label>
                    @error('order')
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
