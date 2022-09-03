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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Edit data {{$page}}</span></h5>
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
            <form action="{{ route($page.'.update',$unlockkrs->id) }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
            <div class="input-field col s6">
              <select name="mahasiswa_id"  class="select2 browser-default">
               <option value="" disabled selected>Mahasiswa</option>
               @foreach ($mahasiswa as $row)
                 <option value="{{ $row->id }}"  {{ old('mahasiswa_id', $unlockkrs->mahasiswa_id) == $row->id ? 'selected' : '' }} >{{ $row->nim }}{{ " " }} {{ $row->nama }}</option>
               @endforeach
              </select>
               <label for="first_name">Mahasiswa <span style="color:red">*</span></label>

               @error('mahasiswa_id')
               <span class="red-text text-darken-2">{{ $message }}</small>
               @enderror
             </div>

             <div class="input-field col s6">
               <select name="jenissemester_id" class="select2 browser-default">
                   <option value="" disabled selected>Tahun Ajaran</option>
                   @foreach($jenissemester as $row)
                       <option  {{ old('jenissemeter_id', $unlockkrs->jenissemester_id) == $row->id ? 'selected' : '' }}  value="{{$row->id}}">{{ $row->jenis_semester .' '. $row->tahunajaran->tahun_ajaran }}</option>
                   @endforeach
               </select>
                <label for="first_name">Semester <span style="color:red">*</span></label>

                @error('jenissemeter_id')
                <span class="red-text text-darken-2">{{ $message }}</small>
                @enderror
           </div>

           <div class="input-field col s6">
               <input type="number" name="totalkrs" class="validate  @error('totalkrs') is-invalid @enderror"  value="{{ old('totalkrs',$unlockkrs->totalkrs) }}" >
               <label for="first_name">Total KRS <span style="color:red">*</span></label>
               @error('totalkrs')
               <span class="red-text text-darken-2">{{ $message }}</small>
               @enderror
           </div>

           <div class="input-field col s6">
               <textarea class="validate" name="keterangan"> {{ old('keterangan',$unlockkrs->keterangan) }}</textarea>
               <label for="first_name">Start Jam <span style="color:red">*</span></label>
               @error('start_time')
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