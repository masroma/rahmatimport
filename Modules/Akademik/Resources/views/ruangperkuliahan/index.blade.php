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
<form action="{{ route('ruangperkuliahan.store') }}" method="POST"
enctype="multipart/form-data" class="col s12">
@csrf
<!-- Page Length Options -->
<div class="row">
<div class="col s6">
    <div class="card">
        <div class="card-content">
                <div class="input-field">
                    <input placeholder="Kode" name="kode" id="kode" type="text" class="validate  @error('kode') is-invalid @enderror" value="{{ old('kode') }}">
                    <label for="first_name">Kode<span style="color:red">*</span></label>
                    @error('kode')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
              </div>
              <div class="input-field">
                <select name="kelasperkuliahan_id" class="select2 browser-default">
                    <option value="">Kelas Perkuliahan</option>
                    @foreach($kelasperkuliahan as $row)
                        <option @if(old('kelasperkuliahan_id') == $row->id) selected @endif value="{{$row->id}}">{{$row->nama_kelas}}-{{ $row->matakuliah->nama_matakuliah }} ({{ $row->matakuliah->kode_matakuliah }})</option>
                    @endforeach
                </select>
                    <label for="first_name">Kelas Perkuliahan</label>
                @error('kelasperkuliahan_id')
                <span class="red-text text-darken-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-field ">
                <select name="penggunaanruang_id" class="select2 browser-default">
                    <option value="">type penggunaan</option>
                    @foreach($penggunaanruang as $row)
                        <option value="{{ $row->id }}" @if(old('penggunaanruang_id') == $row->id) selected @endif value="{{$row->id}}">{{$row->penggunaan_ruangan}}</option>
                    @endforeach
                </select>
                    <label for="first_name">Penggunaan Ruangan<span style="color:red">*</span></label>
                @error('penggunaanruang_id')
                <span class="red-text text-darken-2">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-field">
              <select name="hari" id="hari" class="validate">
                <option value="">pilih hari</option>
                <option value="senin" @if(old('hari') == "senin") selected @endif>Senin</option>
                <option value="selasa" @if(old('hari') == "selasa") selected @endif>Selasa</option>
                <option value="rabu" @if(old('hari') == "rabu") selected @endif>Rabu</option>
                <option value="kamis" @if(old('hari') == "kamis") selected @endif>Kamis</option>
                <option value="jumat" @if(old('hari') == "jumat") selected @endif>Jum'at</option>
                <option value="sabtu" @if(old('hari') == "sabtu") selected @endif>Sabtu</option>
              </select>
                <label for="first_name">Jam Mulai</label>
                @error('kode')
                <span class="red-text text-darken-2">{{ $message }}</small>
                @enderror
          </div>

            <div class="input-field">
                <input placeholder="jam mulai" name="jam_mulai" id="kode" type="time" class="validate  @error('jam_mulai') is-invalid @enderror" value="{{ old('kode') }}">
                <label for="first_name">Jam Mulai</label>
                @error('kode')
                <span class="red-text text-darken-2">{{ $message }}</small>
                @enderror
          </div>

          <div class="input-field">
            <input placeholder="jam mulai" name="jam_akhir" id="kode" type="time" class="validate  @error('jam_mulai') is-invalid @enderror" value="{{ old('kode') }}">
            <label for="first_name">Jam Akhir</label>
            @error('kode')
            <span class="red-text text-darken-2">{{ $message }}</small>
            @enderror
      </div>

            <div class="input-field">
                <button type="submit" class="waves-effect waves-light btn-small"><i class="material-icons right">send</i>save</button>
                <a href={{route('ruangan.index')}} class="waves-effect purple darken-1 btn-small"><i class="material-icons left">keyboard_arrow_left</i>back</a>
            </div>
        </div>
    </div>
</div>
<div class="col s6" >
  <div class="card">
    <div class="card-content" >
        <h4>Jadwal</h4>
        <table id="page-length-option" class="display">
            <thead>
                <tr>
                 <th>Time</th>
                 <th>Senin</th>
                 <th>Selasa</th>
                 <th>Rabu</th>
                 <th>Kamis</th>
                 <th>Jum'at</th>
                 <th>Sabtu</th>
                </tr>
                 </thead>
        </table>
        <div style="overflow-y: scroll; position:relative; height:400px">
            <table id="page-length-option" class="display">
                <tbody>

                    @for($i=$open_time; $i<=$close_time; $i+= 300)
                    <tr>
                        <td>{{ date("H:i", $i) }}</td>
                        <td class="text-center">
                            <label>
                            <input type="checkbox" name="waktu[]"  value="{{date("h:i", $i)}}-senin" {{in_array(date("H:i", $i), $senin) ? "disabled" : ""}}/>
                            <span></span>
                          </label></td>
                          <td class="text-center">
                            <label>
                            <input type="checkbox" name="waktu[]"  value="{{date("h:i", $i)}}-selasa"  {{in_array(date("H:i", $i), $selasa) ? "disabled" : ""}}/>
                            <span></span>
                          </label></td>
                          <td class="text-center">
                            <label>
                            <input type="checkbox" name="waktu[]"  value="{{date("h:i", $i)}}-rabu"  {{in_array(date("H:i", $i), $rabu) ? "disabled" : ""}}/>
                            <span></span>
                          </label></td>
                          <td class="text-center">
                            <label>
                            <input type="checkbox" name="waktu[]"  value="{{date("h:i", $i)}}-kamis"  {{in_array(date("H:i", $i), $kamis) ? "disabled" : ""}}/>
                            <span></span>
                          </label></td>
                          <td class="text-center">
                            <label>
                            <input type="checkbox" name="waktu[]"  value="{{date("h:i", $i)}}-jumat"  {{in_array(date("H:i", $i), $jumat) ? "disabled" : ""}}/>
                            <span></span>
                          </label></td>
                          <td class="text-center">
                            <label>
                            <input type="checkbox" name="waktu[]"  value="{{date("h:i", $i)}}-sabtu"  {{in_array(date("H:i", $i), $sabtu) ? "disabled" : ""}}/>
                            <span></span>
                          </label></td>
                    </tr>

                @endfor
                </tbody>

            </table>
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