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
               <li class="breadcrumb-item"><a href="#">{{$page}}</a>
              </li>
              <li class="breadcrumb-item active">edits
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
            <form action="{{ route($page.'.update',$aktivitas->id) }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <div class="row">
                    @foreach ($form as $forms)

                        @if($forms['type'] == "text")
                        <div class="input-field col {{ $forms['col'] }}">
                            <input placeholder="{{ $forms['placeholder'] }}" name="{{ $forms['name'] }}" id="{{ $forms['name'] }}" type="text" class="validate  @error('nama_fakultas') is-invalid @enderror" value="{{ old($forms['name'],$forms['data']) }}">
                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                            <?php $error = $forms['name'];?>
                            @error($error)
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                      </div>
                      @elseif($forms['type'] === "number")
                      <div class="input-field col {{ $forms['col'] }}">
                      <input placeholder="{{ $forms['placeholder'] }}" name="{{ $forms['name'] }}" id="{{ $forms['name'] }}" type="number" step="any" class="validate  @error('nama_fakultas') is-invalid @enderror" value="{{ old($forms['name'],$forms['data']) }}">
                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                            <?php $error = $forms['name'];?>
                            @error($error)
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                  </div>
                  @elseif($forms['type'] === "date")
                      <div class="input-field col {{ $forms['col'] }}">
                      <input placeholder="{{ $forms['placeholder'] }}" name="{{ $forms['name'] }}" id="{{ $forms['name'] }}" type="date" step="any" class="validate  @error('nama_fakultas') is-invalid @enderror" value="{{ old($forms['name'],$forms['data']) }}">
                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                            <?php $error = $forms['name'];?>
                            @error($error)
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                  </div>
                      @elseif($forms['type'] === "textarea")
                      <div class="input-field col {{ $forms['col'] }}">
                        <textarea placeholder="{{ $forms['placeholder'] }}" name="{{ $forms['name'] }}" id="{{ $forms['name'] }}" type="text" value={{ old($forms['name']) }}>{{ old($forms['name'],$forms['data']) }}</textarea>
                        <label for="first_name">{{ $forms['placeholder'] }}</label>
                        <?php $error = $forms['name'];?>
                        @error($error)
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                  </div>
                  @elseif($forms['type'] === "select")
                      <div class="input-field col {{ $forms['col'] }}">
                        @php $v = $forms['value']; @endphp
                        <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                            <option value="">Pilih</option>
                            @foreach ($forms['relasi'] as $p)
                            <option value="{{ $p->id }}"
                            <?php
                            if($p->id == $forms['data'])
                            {echo "selected";}else{echo "";}

                            ?> >{{ $p->$v }}</option>
                            @endforeach
                        </select>

                        <label for="first_name">{{ $forms['placeholder'] }}</label>
                        <?php $error = $forms['name'];?>
                        @error($error)
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                  </div>
                  @elseif($forms['type'] === "selectsemester")
                      <div class="input-field col {{ $forms['col'] }}">

                        <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                        <option value="">Pilih</option>
                            @foreach($jenis as $row)
                                <option <?php
                            if($row->id == $forms['data'])
                            {echo "selected";}else{echo "";}

                            ?> value="{{$row->id}}">{{ $row->Tahunajaran->tahun_ajaran }}-{{$row->jenis_semester}}</option>
                            @endforeach
                        </select>

                        <label for="first_name">{{ $forms['placeholder'] }}</label>
                        <?php $error = $forms['name'];?>
                        @error($error)
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                  </div>
                  @elseif($forms['type'] === "selectsemester")
                      <div class="input-field col {{ $forms['col'] }}">

                        <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                        <option value="">Pilih</option>
                            @foreach($jenis as $row)
                                <option
                                <?php
                            if($row->id == $forms['data'])
                            {echo "selected";}else{echo "";}

                            ?> value="{{$row->id}}">{{ $row->Tahunajaran->tahun_ajaran }}-{{$row->jenis_semester}}</option>
                            @endforeach
                        </select>

                        <label for="first_name">{{ $forms['placeholder'] }}</label>
                        <?php $error = $forms['name'];?>
                        @error($error)
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                  </div>
                  @elseif($forms['type'] === "selectprogram")
                      <div class="input-field col {{ $forms['col'] }}">

                        <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                        <option value="">Pilih</option>
                            @foreach($programstudy as $row)
                                <option
                                <?php
                            if($row->id == $forms['data'])
                            {echo "selected";}else{echo "";}

                            ?> value="{{$row->id}}">{{ $row->jurusan->nama_jurusan }}</option>
                            @endforeach
                        </select>

                        <label for="first_name">{{ $forms['placeholder'] }}</label>
                        <?php $error = $forms['name'];?>
                        @error($error)
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                  </div>
                  @elseif($forms['type'] === "selectanggota")
                      <div class="input-field col {{ $forms['col'] }}">

                        <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                            <option value="">Pilih</option>
                            <option value="personal" @if($forms['data'] == "personal") selected @endif>Personal</option>
                            <option value="kelompok" @if($forms['data'] == "kelompok") selected @endif>Kelompok</option>


                        </select>

                        <label for="first_name">{{ $forms['placeholder'] }}</label>
                        <?php $error = $forms['name'];?>
                        @error($error)
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                  </div>
                      @endif
                    @endforeach



                  <div class="input-field col s12">
                  <button type="submit" class="waves-effect waves-light btn-small"><i class="material-icons right">send</i>save</button>
                  <a href="{{ route('aktivitaskuliahmahasiswa.index') }}" class="waves-effect purple darken-1 btn-small"><i class="material-icons left">keyboard_arrow_left</i>back</a>
                  </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

{{-- listing --}}

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs tab-demo z-depth-1">
                           <li class="tab col"><a class="active" href="#test1">Peserta Aktivitas</a></li>
                           <li class="tab col"><a href="#test2">Dosen Pembimbing</a></li>
                           <li class="tab col"><a href="#test3">Dosen Penguji</a></li>
                        </ul>
                    </div>
                    <div id="test1" class="col s12 ">
                       <form class="mt-3">
                        <div class="input-field col s4">
                            <select name="mahasiswa_id" id="mahasiswa_id" class="validate select2 browser-default  @error('mahasiswa_id') is-invalid @enderror">
                                <option value="" disabled selected>Pilih Mahasiswa</option>
                                @foreach($mahasiswa as $row)
                                    <option  {{ old('mahasiswa_id') == $row->id ? 'selected' : '' }}  value="{{$row->id}}">{{$row->nama}}</option>
                                @endforeach
                            </select>
                            <label for="first_name">Mahasiswa</label>
                            @error('mahasiswa_id')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4">
                            <select name="mahasiswa_id" id="peran_id" class="validate select2 browser-default  @error('mahasiswa_id') is-invalid @enderror">
                                <option value="" disabled selected>Peran Peserta</option>
                                @if($aktivitas->jenis_anggota == "kelompok")
                                <option value="1-ketua">Ketua</option>
                                <option value="2-anggota">Anggota</option>
                                <option value="2-personal">Personal</option>
                                @elseif($aktivitas->jenis_anggota == "personal")
                                <option value="2-personal">Personal</option>
                                @endif
                            </select>
                            <label for="first_name">Mahasiswa</label>
                            @error('mahasiswa_id')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4">
                            <button type="submit" class="waves-effect waves-light btn-small"><i class="material-icons"></i>tambah</button>
                          </div>
                       </form>
                    </div>

                    <div id="test2" class="col s12 ">
                        <h3>Dosen Pembimbing</h3>
                    </div>
                    <div id="test3" class="col s12 ">
                        <h3>Dosen Penguji</h3>
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
