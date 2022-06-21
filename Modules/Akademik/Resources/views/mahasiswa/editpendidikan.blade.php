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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Edit {{$title}} Mahasiswa</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
               <li class="breadcrumb-item"><a href="{{route('mahasiswa.edit',$pendidikan->mahasiswa_id)}}">Edit Mahasiswa</a>
              </li>
              <li class="breadcrumb-item active">Edit Riwayat Pendidikan
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
            <form action="{{ route('mahasiswa.updatependidikan',$pendidikan->id) }}" method="POST"
            enctype="multipart/form-data" class="col s12">
            @csrf
                <input type="hidden" name="mahasiswa_id" value="{{ $pendidikan->mahasiswa_id }}">
                <div class="row">

                   <div class="row">
                    <div class="input-field col s12">
                        <input placeholder="nim" name="nim" id="nim" type="text" class="validate  @error('nim') is-invalid @enderror" value="{{ old('nim',$pendidikan->nim) }}">
                        <label for="first_name">NIM</label>
                        @error('nim')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                   </div>
                 <div class="row">
                    <div class="input-field col s4 ">
                        <select name="jenis_pendaftaran" class="select2 browser-default">
                            <option value="">Jenis Pendaftaran</option>
                            @foreach($jenispendaftaran as $row)
                                <option @if(old('jenis_pendaftaran', $pendidikan->jenis_pendaftaran) == $row->id) selected @endif value="{{$row->id}}">{{$row->jenis_pendaftaran}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Jenis Pendaftaran<span style="color:red">*</span></label>
                        @error('jenis_pendaftaran')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="input-field col s4 ">
                        <select name="jalur_pendaftaran" class="select2 browser-default">
                            <option value="">Jalur Pendaftaran</option>
                            @foreach($jalurpendaftaran as $row)
                                <option @if(old('jalur_pendaftaran',$pendidikan->jalur_pendaftaran) == $row->id) selected @endif value="{{$row->id}}">{{$row->jalur_pendaftaran}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Jalur Pendaftaran<span style="color:red">*</span></label>
                        @error('jalur_pendaftaran')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="input-field col s4 ">
                        <select name="typemahasiswa_id" class="select2 browser-default">
                            <option value="">Type Mahasiswa</option>
                            @foreach($TypeMahasiswa as $row)
                                <option @if(old('typemahasiswa_id',$pendidikan->typemahasiswa_id) == $row->id) selected @endif value="{{$row->id}}">{{$row->type_mahasiswa}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Type Mahasiswa<span style="color:red">*</span></label>
                        @error('typemahasiswa_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                 </div>

                 <div class="row">
                    <div class="input-field col s4 ">
                        <select name="jalurmasukinternal_id" class="select2 browser-default">
                            <option value="">Jalur Masuk</option>
                            @if($JalurMasuk)
                            @foreach($JalurMasuk as $row)
                                <option @if(old('jalurmasukinternal_id',$pendidikan->jalurmasukinternal_id) == $row->id) selected @endif value="{{$row->id}}">{{$row->nama_jalur}}</option>
                            @endforeach
                            @endif
                          </select>
                            <label for="first_name">Jalur Masuk Internal<span style="color:red">*</span></label>
                        @error('jalurmasukinternal_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="input-field col s4 ">
                        <select name="periode_pendaftaran" class="select2 browser-default">
                            <option value="">Periode Pendaftaran</option>
                            @foreach($periodependaftaran as $row)
                                <option @if(old('periode_pendaftaran',$pendidikan->periode_pendaftaran) == $row->id) selected @endif value="{{$row->id}}">{{$row->Tahunajaran->tahun_ajaran}}-{{ $row->jenis_semester }}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Periode Pendaftaran<span style="color:red">*</span></label>
                        @error('periode_pendaftaran')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="input-field col s4">
                        <input placeholder="tanggal_masuk" name="tanggal_masuk" id="tanggal_masuk" type="date" class="validate  @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk',$pendidikan->tanggal_masuk) }}">
                        <label for="first_name">Tanggal Masuk<span style="color:red">*</span></label>
                        @error('tanggal_masuk')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                 </div>

                <div class="row">
                    <div class="input-field col s4 ">
                        <select name="pembiayaan_awal" class="select2 browser-default">
                            <option value="">Pembiayaan Awal</option>
                            @foreach($pembiayaanawal as $row)
                                <option @if(old('pembiayaan_awal',$pendidikan->pembiayaan_awal) == $row->id) selected @endif value="{{$row->id}}">{{$row->pembiayaan_awal}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Pembiayaan Awal<span style="color:red">*</span></label>
                        @error('pembiayaan_awal')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="input-field col s4">
                        <input placeholder="biaya_masuk" name="biaya_masuk" id="biaya_masuk" type="number" class="validate  @error('biaya_masuk') is-invalid @enderror" value="{{ old('biaya_masuk',$pendidikan->biaya_masuk) }}">
                        <label for="first_name">Biaya Masuk<span style="color:red">*</span></label>
                        @error('biaya_masuk')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="input-field col s4 ">
                        <select name="kampus_id" class="select2 browser-default">
                            <option value="">Kampus</option>
                            @foreach($kampus as $row)
                                <option @if(old('kampus_id',$pendidikan->kampus_id) == $row->id) selected @endif value="{{$row->id}}">{{$row->nama_kampus}}-{{ $row->cabang_kampus }}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Kampus<span style="color:red">*</span></label>
                        @error('kampus_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                  <div class="row">
                    <div class="input-field col s4 ">
                        <select name="programstudy_id" class="select2 browser-default">
                            <option value="">Program Study</option>
                            @foreach($programstudy as $row)
                                <option @if(old('programstudy_id',$pendidikan->programstudy_id) == $row->id) selected @endif value="{{$row->id}}">{{$row->Jurusan->nama_jurusan}}-{{ $row->Jenjang->nama_jenjang }}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Program Study<span style="color:red">*</span></label>
                        @error('programstudy_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="input-field col s4 ">
                        <select name="peminatan_id" class="select2 browser-default">
                            <option value="">Peminatan</option>
                            @foreach($programstudy as $row)
                                <option @if(old('peminatan_id',$pendidikan->peminatan_id) == $row->id) selected @endif value="{{$row->id}}">{{$row->nama_peminatan}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Peminatan<span style="color:red">*</span></label>
                        @error('peminatan_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                  </div>


                  <div class="input-field col s12">
                  <button type="submit" class="waves-effect waves-light btn-small"><i class="material-icons right">send</i>save</button>
                  <a href="{{route('mahasiswa.show',$pendidikan->mahasiswa_id)}}"class="waves-effect purple darken-1 btn-small"><i class="material-icons left">keyboard_arrow_left</i>back</a>
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
