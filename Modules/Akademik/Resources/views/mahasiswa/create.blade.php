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

            <div class="col s12">
                <ul class="tabs tab-demo z-depth-1">
                   <li class="tab col m3"><a class="active" href="#test1">Data Pribadi</a></li>
                   <li class="tab col "><a href="#test2">Alamat</a></li>
                   <li class="tab col m3"><a href="#test3">Orang Tua</a></li>
                   <li class="tab col "><a href="#test4">Wali</a></li>
                   <li class="tab col m3"><a href="#test5">Kebutuhan Khusus</a></li>
                </ul>
             </div>
             <div class="col s12">
                <div id="test1" class="col s12 ">
                    <div class="mt-3 mb-3"></div>
                    <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="nama" name="nama" id="nama" type="text" class="validate  @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                        <label for="first_name">Nama<span style="color:red">*</span></label>

                        @error('nama')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="tempat_lahir" name="tempat_lahir" id="tempat_lahir" type="text" class="validate  @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                        <label for="first_name">Tempat Lahir<span style="color:red">*</span></label>

                        @error('tempat_lahir')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="tanggal_lahir" name="tanggal_lahir" id="tanggal_lahir" type="date" class="validate  @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                        <label for="first_name">Tanggal Lahir<span style="color:red">*</span></label>

                        @error('tanggal_lahir')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4  mt-2 mb-2">
                       <select name="jenis_kelamin" id="jenis_kelamin">
                           <option value="">jenis kelamin</option>
                           <option value="laki-laki" @if(old('jenis_kelamin') == 'laki-laki') selected @endif>Laki - Laki</option>
                           <option value="perempuan" @if(old('jenis_kelamin') == 'perempuan') selected @endif>Perempuan</option>
                       </select>
                        <label for="first_name">Jenis Kelamin<span style="color:red">*</span></label>

                        @error('tempat_lahir')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="ibu_kandung" name="ibu_kandung" id="ibu_kandung" type="text" class="validate  @error('ibu_kandung') is-invalid @enderror" value="{{ old('ibu_kandung') }}">
                        <label for="first_name">Nama Ibu<span style="color:red">*</span></label>
                        @error('ibu_kandung')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <select name="agama" id="agama">
                            <option value="">Agama</option>
                            <option value="islam" @if(old('agama') == 'islam') selected @endif>Islam</option>
                            <option value="kristen" @if(old('agama') == 'kristen') selected @endif>Kristen</option>
                            <option value="katolik" @if(old('agama') == 'katolik') selected @endif>Katolik</option>
                            <option value="hindu" @if(old('agama') == 'hindu') selected @endif>Hindu</option>
                            <option value="budha" @if(old('agama') == 'budha') selected @endif>Budha</option>
                            <option value="konghucu" @if(old('agama') == 'konghucu') selected @endif>Konghucu</option>
                        </select>
                         <label for="first_name">Agama<span style="color:red">*</span></label>

                         @error('tempat_lahir')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>
                </div>
                <div id="test2" class="col s12">
                    <div class="input-field col s6  mt-3 mb-3">
                        <select name="kewarganegaraan_id" class="select2 browser-default">
                            <option value="">Kewarganegaraan</option>
                            @foreach($kewarganegaraan as $row)
                                <option @if(old('kewarganegaraan_id') == $row->id_country) selected @endif value="{{$row->id_country}}">{{$row->country_name}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Kewarganegaraan<span style="color:red">*</span></label>
                        @error('kewarganegaraan_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="input-field col s6  mt-3 mb-3">
                        <input placeholder="nik" name="nik" id="nik" type="text" class="validate  @error('nik') is-invalid @enderror" value="{{ old('nik') }}">
                        <label for="first_name">NIK<span style="color:red">*</span></label>

                        @error('nik')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s6  mt-2 mb-2">
                        <input placeholder="nisn" name="nisn" id="nisn" type="text" class="validate  @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}">
                        <label for="first_name">NISN<span style="color:red">*</span></label>

                        @error('nisn')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s6  mt-2 mb-2">
                        <input placeholder="npwp" name="npwp" id="npwp" type="text" class="validate  @error('npwp') is-invalid @enderror" value="{{ old('npwp') }}">
                        <label for="first_name">NPWP<span style="color:red">*</span></label>

                        @error('nisn')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>



                      <div class="input-field col s12 mt-2 mb-2">
                        <label for="first_name">Jalan</label>
                        <textarea  name="jalan" id="textarea2" class="materialize-textarea  @error('jalan') is-invalid @enderror">{{ old('jalan') }}</textarea>


                      @error('jalan')
                      <span class="red-text text-darken-2">{{ $message }}</small>
                      @enderror
                    </div>

                        <div class="input-field col s6 mt-2 mb-2">
                        <select name="province_id" class="select2 browser-default">
                            <option value="" disabled selected>Provinsi</option>
                            @foreach($province as $row)
                                <option  {{ old('province_id') == $row->id ? 'selected' : '' }}  value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Provinsi</label>
                        @error('province_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s6 mt-2 mb-2">
                        <select name="city_id" id="city_id" class="select2 browser-default">
                            {{-- <option value="" disabled selected>Kota</option> --}}
                        </select>
                        <label for="first_name">Kota</label>
                        @error('city_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s6 mt-2 mb-2">
                        <select name="district_id" id="district_id" class="select2 browser-default">
                            {{-- <option value="" disabled selected>Kecamatan</option> --}}
                        </select>
                        <label for="first_name">Kecamatan</label>
                        @error('district_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s6 mt-2 mb-2">
                        <select name="village_id" id="village_id" class="select2 browser-default">
                            {{-- <option value="" disabled selected>Kecamatan</option> --}}
                        </select>
                        <label for="first_name">Kelurahan</label>
                        @error('village_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="RT" name="rt" id="RT" type="number" class="validate  @error('rt') is-invalid @enderror" value="{{ old('rt') }}">
                        <label for="first_name">RT</label>
                        @error('rt')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="RW" name="rw" id="RW" type="number" class="validate  @error('rw') is-invalid @enderror" value="{{ old('rw') }}">
                        <label for="first_name">RW</label>
                        @error('rw')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="dusun" name="dusun" id="dusun" type="text" class="validate  @error('dusun') is-invalid @enderror" value="{{ old('dusun') }}">
                        <label for="first_name">Dusun<span style="color:red">*</span></label>

                        @error('dusun')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="telephone" name="telephone" id="telephone" type="text" class="validate  @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                        <label for="first_name">Telephone<span style="color:red">*</span></label>

                        @error('telephone')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="handphone" name="handphone" id="handphone" type="text" class="validate  @error('handphone') is-invalid @enderror" value="{{ old('handphone') }}">
                        <label for="first_name">Handphone<span style="color:red">*</span></label>

                        @error('handphone')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4  mt-2 mb-2">
                        <select name="penerima_kps" id="penerima_kps">
                            <option value="">Penerima KPS</option>
                            <option value="y">Ya</option>
                            <option value="n">Tidak</option>

                        </select>
                         <label for="first_name">Penerima KPS<span style="color:red">*</span></label>

                         @error('penerima_kps')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <div class="input-field col s6  mt-2 mb-2">
                        <select name="alat_transportasi" id="alat_transportasi">
                            <option value="">Alat Transportasi</option>
                            <option value="kereta api">Kereta Api</option>
                            <option value="angkutan umum">Angkutan Umum</option>
                            <option value="sepeda motor">Sepeda Motor</option>
                            <option value="sepeda">Sepeda</option>
                            <option value="mobil umum">Mobil atau bus jemputan</option>
                            <option value="perahu">Perahu atau getek</option>
                            <option value="ojek">Ojek</option>
                            <option value="jalan kaki">Jalan Kaki</option>
                            <option value="mobil pribadi">Mobil Pribadi</option>
                        </select>
                         <label for="first_name">Alat Transportasi<span style="color:red">*</span></label>

                         @error('alat_transportasi')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <div class="input-field col s6  mt-2 mb-2">
                        <select name="jenis_tinggal" id="jenis_tinggal">
                            <option value="">Jenis Tinggal</option>
                            <option value="asrama">Asrama</option>
                            <option value="panti asuhan">Panti Asuhan</option>
                            <option value="wali">Wali</option>
                            <option value="kost">Kost</option>
                            <option value="orang tua">Bersama Orang Tua</option>

                        </select>
                         <label for="first_name">Alat Transportasi<span style="color:red">*</span></label>

                         @error('jenis_tinggal')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>


                </div>
                <div id="test3" class="col s12">
                    <p class="mt-2 mb-2">Data Ayah</p>
                    <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="nama ayah" name="nama_ayah" id="nama_ayah" type="text" class="validate  @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah') }}">
                        <label for="first_name">Nama</label>
                        @error('nama_ayah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="nik ayah" name="nik_ayah" id="nik_ayah" type="text" class="validate  @error('nik_ayah') is-invalid @enderror" value="{{ old('nik_ayah') }}">
                        <label for="first_name">NIK</label>
                        @error('nik_ayah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="tanggal lahir" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" type="date" class="validate  @error('tanggal_lahir_ayah') is-invalid @enderror" value="{{ old('tanggal_lahir_ayah') }}">
                        <label for="first_name">Tanggal Lahir</label>
                        @error('tanggal_lahir_ayah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                       <select name="pendidikan_ayah" id="pendidikan">
                           <option value="">pendidikan</option>
                           <option value="sd">SD</option>
                           <option value="smp">SMP</option>
                           <option value="sma">SMA</option>
                           <option value="d1">D1</option>
                           <option value="d2">D2</option>
                           <option value="d3">D3</option>
                           <option value="d4">D4</option>
                           <option value="s1">S1</option>
                           <option value="s2">S2</option>
                           <option value="s3">S3</option>
                           <option value="paket A">Paket A</option>
                           <option value="paket B">Paket B</option>
                           <option value="paket C">Paket C</option>
                           <option value="tidak sekolah">Tidak Sekolah</option>
                       </select>
                        <label for="first_name">Pendidikan</label>
                        @error('pendidikan_ayah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <select name="pekerjaan_ayah" id="pekerjan">
                            <option value="">pekerjaan</option>
                            <option value="tidak bekerja">Tidak Bekerja</option>
                            <option value="petani">Petani</option>
                            <option value="peternak">Peternak</option>
                            <option value="nelayan">Nelayan</option>
                            <option value="pedagang kecil">Pedagang Kecil</option>
                            <option value="pedagang besar">Pedagang Besar</option>
                            <option value="peneliti">Peneliti</option>
                            <option value="karyawan swasta">Karyawan</option>
                            <option value="buruh">Buruh</option>
                            <option value="magang">Magang</option>
                            <option value="wirausaha">Wirausaha</option>
                            <option value="konsultan">Konsultan</option>
                            <option value="pns/tni/polri">PNS / TNI / POLRI</option>
                            <option value="pensiunan">pensiunan</option>
                            <option value="pimpinan">Pimpinan</option>
                            <option value="pengajar">Pengajar</option>
                        </select>
                         <label for="first_name">Pekerjaan</label>
                         @error('pekerjaan_ayah')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <div class="input-field col s4 mt-2 mb-2">
                        <select name="penghasilan_ayah" id="pnghasilan">
                            <option value="">penghasilan</option>
                            <option value="dibawah 500.000">Dibawah 500.000</option>
                            <option value="1000.000 - 2000.000">1000.000 sd 2000.000</option>
                            <option value="2000.000 - 4000.000">2000.000 sd 4000.000</option>
                            <option value="4000.000 - 5000.000">4000.000 sd 5000.000</option>
                            <option value="5000.000 - 20.000.000">5000.000 sd 20.000.000</option>
                            <option value="diatas 20.000.000">diatas 20.000.000</option>
                        </select>
                         <label for="first_name">Penghasilan</label>
                         @error('penghasilan_ayah')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <p class="mt-2 mb-2">Data Ibu</p>
                       <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="nama ibu" name="nama_ibu" id="nama_ibu" type="text" class="validate  @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu') }}">
                        <label for="first_name">Nama</label>
                        @error('nama_ibu')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="nik ibu" name="nik_ibu" id="nik_ibu" type="text" class="validate  @error('nik_ibu') is-invalid @enderror" value="{{ old('nik_ibu') }}">
                        <label for="first_name">NIK</label>
                        @error('nik_ibu')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="tanggal lahir" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" type="date" class="validate  @error('tanggal_lahir_ibu') is-invalid @enderror" value="{{ old('tanggal_lahir_ibu') }}">
                        <label for="first_name">Tanggal Lahir</label>
                        @error('tanggal_lahir_ibu')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                       <select name="pendidikan_ibu" id="pendidikan">
                           <option value="">pendidikan</option>
                           <option value="sd">SD</option>
                           <option value="smp">SMP</option>
                           <option value="sma">SMA</option>
                           <option value="d1">D1</option>
                           <option value="d2">D2</option>
                           <option value="d3">D3</option>
                           <option value="d4">D4</option>
                           <option value="s1">S1</option>
                           <option value="s2">S2</option>
                           <option value="s3">S3</option>
                           <option value="paket A">Paket A</option>
                           <option value="paket B">Paket B</option>
                           <option value="paket C">Paket C</option>
                           <option value="tidak sekolah">Tidak Sekolah</option>
                       </select>
                        <label for="first_name">Pendidikan</label>
                        @error('pendidikan_ibu')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <select name="pekerjaanibuh" id="pekerjan">
                            <option value="">pekerjaan</option>
                            <option value="tidak bekerja">Tidak Bekerja</option>
                            <option value="petani">Petani</option>
                            <option value="peternak">Peternak</option>
                            <option value="nelayan">Nelayan</option>
                            <option value="pedagang kecil">Pedagang Kecil</option>
                            <option value="pedagang besar">Pedagang Besar</option>
                            <option value="peneliti">Peneliti</option>
                            <option value="karyawan swasta">Karyawan</option>
                            <option value="buruh">Buruh</option>
                            <option value="magang">Magang</option>
                            <option value="wirausaha">Wirausaha</option>
                            <option value="konsultan">Konsultan</option>
                            <option value="pns/tni/polri">PNS / TNI / POLRI</option>
                            <option value="pensiunan">pensiunan</option>
                            <option value="pimpinan">Pimpinan</option>
                            <option value="pengajar">Pengajar</option>
                        </select>
                         <label for="first_name">Pekerjaan</label>
                         @error('pekerjaan_ibu')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <div class="input-field col s4 mt-2 mb-2">
                        <select name="penghasilan_ibu" id="pnghasilan">
                            <option value="">penghasilan</option>
                            <option value="0">tidak punya penghasilan</option>
                            <option value="dibawah 500.000">Dibawah 500.000</option>
                            <option value="1000.000 - 2000.000">1000.000 sd 2000.000</option>
                            <option value="2000.000 - 4000.000">2000.000 sd 4000.000</option>
                            <option value="4000.000 - 5000.000">4000.000 sd 5000.000</option>
                            <option value="5000.000 - 20.000.000">5000.000 sd 20.000.000</option>
                            <option value="diatas 20.000.000">diatas 20.000.000</option>
                        </select>
                         <label for="first_name">Penghasilan</label>
                         @error('penghasilan_ibu')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>
                </div>
                <div id="test4" class="col s12">
                    <div class="input-field col s4 mt-3 mb-2">
                        <input placeholder="nama wali" name="nama_wali" id="nama_wali" type="text" class="validate  @error('nama_wali') is-invalid @enderror" value="{{ old('nama_wali') }}">
                        <label for="first_name">Nama</label>
                        @error('nama_wali')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="tanggal lahir" name="tanggal_lahir_wali" id="tanggal_lahir_wali" type="date" class="validate  @error('tanggal_lahir_wali') is-invalid @enderror" value="{{ old('tanggal_lahir_wali') }}">
                        <label for="first_name">Tanggal Lahir</label>
                        @error('tanggal_lahir_wali')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                       <select name="pendidikan_wali" id="pendidikan">
                           <option value="">pendidikan</option>
                           <option value="sd">SD</option>
                           <option value="smp">SMP</option>
                           <option value="sma">SMA</option>
                           <option value="d1">D1</option>
                           <option value="d2">D2</option>
                           <option value="d3">D3</option>
                           <option value="d4">D4</option>
                           <option value="s1">S1</option>
                           <option value="s2">S2</option>
                           <option value="s3">S3</option>
                           <option value="paket A">Paket A</option>
                           <option value="paket B">Paket B</option>
                           <option value="paket C">Paket C</option>
                           <option value="tidak sekolah">Tidak Sekolah</option>
                       </select>
                        <label for="first_name">Pendidikan</label>
                        @error('pendidikan_wali')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <select name="pekerjaan_wali" id="pekerjan">
                            <option value="">pekerjaan</option>
                            <option value="tidak bekerja">Tidak Bekerja</option>
                            <option value="petani">Petani</option>
                            <option value="peternak">Peternak</option>
                            <option value="nelayan">Nelayan</option>
                            <option value="pedagang kecil">Pedagang Kecil</option>
                            <option value="pedagang besar">Pedagang Besar</option>
                            <option value="peneliti">Peneliti</option>
                            <option value="karyawan swasta">Karyawan</option>
                            <option value="buruh">Buruh</option>
                            <option value="magang">Magang</option>
                            <option value="wirausaha">Wirausaha</option>
                            <option value="konsultan">Konsultan</option>
                            <option value="pns/tni/polri">PNS / TNI / POLRI</option>
                            <option value="pensiunan">pensiunan</option>
                            <option value="pimpinan">Pimpinan</option>
                            <option value="pengajar">Pengajar</option>
                        </select>
                         <label for="first_name">Pekerjaan</label>
                         @error('pekerjaan_wali')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <div class="input-field col s4 mt-2 mb-2">
                        <select name="penghasilan_wali" id="pnghasilan">
                            <option value="">penghasilan</option>
                            <option value="dibawah 500.000">Dibawah 500.000</option>
                            <option value="1000.000 - 2000.000">1000.000 sd 2000.000</option>
                            <option value="2000.000 - 4000.000">2000.000 sd 4000.000</option>
                            <option value="4000.000 - 5000.000">4000.000 sd 5000.000</option>
                            <option value="5000.000 - 20.000.000">5000.000 sd 20.000.000</option>
                            <option value="diatas 20.000.000">diatas 20.000.000</option>
                        </select>
                         <label for="first_name">Penghasilan</label>
                         @error('penghasilan_wali')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>
                </div>
                <div id="test5" class="col s12">
                    <div class="input-field col s4  mt-3 mb-3">
                        <select name="kebutuhan_khusus" id="kebutuhan_khusus">
                            <option value="">kebutuhan khusus</option>
                            <option value="y">Ya</option>
                            <option value="n">Tidak</option>
                        </select>
                         <label for="first_name">Kebutuhan Khusus<span style="color:red">*</span></label>

                         @error('kebutuhan_khusus')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>
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
  {{-- script untuk dropdow change --}}


  <script>
      $(document).ready(function(){
        //   city
        $('select[name="province_id"]').on('change', function(){
            let provinceid = $(this).val();
            if(provinceid){
                jQuery.ajax({
                    url:"{{ url('city') }}/" + provinceid,
                    type:"GET",
                    dataType:'json',
                    success:function(data){
                        // console.log(data);
                        $('select[name="city_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="city_id"]').append('<option value="'+value.id+'">'+value.name+'</option>')
                        });
                    }
                });
            }else{
                $('select[name="city_id"]').empty();
            }
        });

        // kecsmatan
        $('select[name="city_id"]').on('change', function(){
            let cityid = $(this).val();

            if(cityid){
                jQuery.ajax({
                    url:"{{ url('district') }}/" + cityid,
                    type:"GET",
                    dataType:'json',
                    success:function(data){
                        $('select[name="district_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="district_id"]').append('<option value="'+value.id+'">'+value.name+'</option>')
                        });
                    }
                });
            }else{
                $('select[name="district_id"]').empty();
            }
        });

        // kelurahan
        $('select[name="district_id"]').on('change', function(){
            let districtid = $(this).val();
            if(districtid){
                jQuery.ajax({
                    url:"{{ url('village') }}/" + districtid,
                    type:"GET",
                    dataType:'json',
                    success:function(data){
                        // console.log(data)
                        $('select[name="village_id"]').empty();
                        $.each(data, function(key, value){
                            console.log('od',value.id)
                            $('select[name="village_id"]').append('<option value="'+value.id+'">'+value.name+'</option>')
                        });
                    }
                });
            }else{
                $('select[name="village_id"]').empty();
            }
        });



      });
    </script>





@endsection
