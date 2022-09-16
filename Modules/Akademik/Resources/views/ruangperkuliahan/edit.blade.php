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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Data {{$title}}</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
              {{-- <li class="breadcrumb-item"><a href="#">Table</a>
              </li> --}}
              <li class="breadcrumb-item active">{{$title}}
              </li>
            </ol>
          </div>
          <div class="col s2 m6 l6">

          </div>
        </div>
      </div>
    </div>
    <div class="col s12">
      <div class="container">
        <div class="section section-data-tables">
<div class="card">

</div>
<form action="{{ route('ruangperkuliahan.update',$old->id) }}" method="POST"
enctype="multipart/form-data" class="col s12">
@csrf
<!-- Page Length Options -->
<div class="row">
<div class="col s12">
    <div class="card">
        <div class="card-content">
              <div class="input-field">
                <input placeholder="Ruang id" name="ruang_id" id="ruang_id" type="hidden" class="validate  @error('ruang_id') is-invalid @enderror" value="{{ $old->ruang_id }}">
              </div>
              <div class="input-field">
                <select name="jenissemester_id" class="select2 browser-default" disabled>
                    {{-- <option value="" >Tahun Ajaran</option> --}}
                    @foreach($semester as $r)
                        <option @if(old('jenissemester_id', $old->jenissemester_id) == $r->id) selected @endif value="{{$r->id}}">{{$r->jenis_semester}}-{{ $r->tahunajaran->tahun_ajaran }} </option>
                    @endforeach
                </select>
                    <label for="first_name">Tahun Ajaran</label>
                @error('jenissemester_id')
                <span class="red-text text-darken-2">{{ $message }}</small>
                @enderror
                <small>kosongkan jika ingin di pakai setiap semester</small>
            </div>
              <div class="input-field">
                <select name="kelasperkuliahan_id" class="select2 browser-default" readonly>
                    <option value="">Kelas Perkuliahan</option>
                    @foreach($kelasperkuliahan as $row)
                        <option @if(old('kelasperkuliahan_id',$old->kelasperkuliahan_id) == $row->id) selected @endif value="{{$row->id}}">{{$row->nama_kelas}}{{ $row->kode }} - {{ $row->matakuliah->nama_matakuliah }}({{ $row->matakuliah->kode_matakuliah }})</option>
                    @endforeach
                </select>
                    <label for="first_name">Kelas Perkuliahan</label>
                @error('kelasperkuliahan_id')
                <span class="red-text text-darken-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-field ">
                <input type="hidden"  name="penggunaanruang_id" value="1">
                {{-- <select name="penggunaanruang_id" class="select2 browser-default">
                    <option value="">type penggunaan</option>
                    @foreach($penggunaanruang as $row)
                        <option value="{{ $row->id }}" @if(old('penggunaanruang_id',$old->penggunaanruang_id) == $row->id) selected @endif value="{{$row->id}}">{{$row->penggunaan_ruangan}}</option>
                    @endforeach
                </select>
                    <label for="first_name">Penggunaan Ruangan<span style="color:red">*</span></label>
                @error('penggunaanruang_id')
                <span class="red-text text-darken-2">{{ $message }}</small>
                @enderror --}}
            </div>

            <div class="input-field">
              <select name="hari" id="hari" class="validate">
                <option value="">pilih hari</option>
                <option value="senin" @if(old('hari',$old->hari) == "senin") selected @endif>Senin</option>
                <option value="selasa" @if(old('hari',$old->hari) == "selasa") selected @endif>Selasa</option>
                <option value="rabu" @if(old('hari',$old->hari) == "rabu") selected @endif>Rabu</option>
                <option value="kamis" @if(old('hari',$old->hari) == "kamis") selected @endif>Kamis</option>
                <option value="jumat" @if(old('hari',$old->hari) == "jumat") selected @endif>Jum'at</option>
                <option value="sabtu" @if(old('hari',$old->hari) == "sabtu") selected @endif>Sabtu</option>
              </select>
                <label for="first_name">Hari</label>
                @error('kode')
                <span class="red-text text-darken-2">{{ $message }}</small>
                @enderror
          </div>

            <div class="input-field">
                <input placeholder="jam mulai" name="jam_mulai" id="kode" type="time" class="validate  @error('jam_mulai') is-invalid @enderror"value="{{ old('jam_mulai',\Carbon\Carbon::createFromFormat('H:i:s',$old->jam_awal)->format('h:i')) }}">
                <label for="first_name">Jam Mulai</label>
                @error('kode')
                <span class="red-text text-darken-2">{{ $message }}</small>
                @enderror
          </div>

          <div class="input-field">
            <input placeholder="jam mulai" name="jam_akhir" id="kode" type="time" class="validate  @error('jam_mulai') is-invalid @enderror" value="{{ old('jam_akhir',\Carbon\Carbon::createFromFormat('H:i:s',$old->jam_akhir)->format('h:i')) }}">
            <label for="first_name">Jam Akhir</label>
            @error('kode')
            <span class="red-text text-darken-2">{{ $message }}</small>
            @enderror
      </div>

        <div class="input-field">
            <input placeholder="tanggal awal masuk" name="tanggal_awal_masuk" id="tanggal_awal_masuk" type="date" class="validate  @error('tanggal_awal_masuk') is-invalid @enderror" value="{{ old('tanggal_awal_masuk',$old->tanggal_awal_masuk) }}">
            <label for="first_name">tanggal awal masuk</label>
            <small>tanggal ini untuk menentukan tanggal awal perkuliahan saat di generate 1 semester</small>
            @error('tanggal_awal_masuk')
            <span class="red-text text-darken-2">{{ $message }}</small>
            @enderror
        </div>

            <div class="input-field">
                <button type="submit" class="waves-effect waves-light btn-small"><i class="material-icons right">send</i>save</button>
                <a href={{route('ruangperkuliahan.show',$old->ruang_id)}} class="waves-effect purple darken-1 btn-small"><i class="material-icons left">keyboard_arrow_left</i>back</a>
            </div>
        </div>
    </div>
</div>

</div>
</form>



</div><!-- START RIGHT SIDEBAR NAV -->

</div>
      </div>
      <div class="content-overlay"></div>
    </div>
  </div>



  @stop
  @section('script')


@endsection
