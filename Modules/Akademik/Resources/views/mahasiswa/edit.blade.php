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
            <form action="{{ route($page.'.update',[$mahasiswa->id]) }}" method="POST"
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
                        <input placeholder="nama" name="nama" id="nama" type="text" class="validate  @error('nama') is-invalid @enderror" value="{{ old('nama',$mahasiswa->nama) }}">
                        <label for="first_name">Nama<span style="color:red">*</span></label>

                        @error('nama')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="tempat_lahir" name="tempat_lahir" id="tempat_lahir" type="text" class="validate  @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir',$mahasiswa->tempat_lahir) }}">
                        <label for="first_name">Tempat Lahir<span style="color:red">*</span></label>

                        @error('tempat_lahir')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="tanggal_lahir" name="tanggal_lahir" id="tanggal_lahir" type="date" class="validate  @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir',$mahasiswa->tanggal_lahir) }}">
                        <label for="first_name">Tanggal Lahir<span style="color:red">*</span></label>

                        @error('tanggal_lahir')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4  mt-2 mb-2">
                       <select name="jenis_kelamin" id="jenis_kelamin">
                           <option value="">jenis kelamin</option>
                           <option value="laki-laki" @if(old('jenis_kelamin',$mahasiswa->jenis_kelamin) == 'laki-laki') selected @endif>Laki - Laki</option>
                           <option value="perempuan" @if(old('jenis_kelamin',$mahasiswa->jenis_kelamin) == 'perempuan') selected @endif>Perempuan</option>
                       </select>
                        <label for="first_name">Jenis Kelamin<span style="color:red">*</span></label>

                        @error('tempat_lahir')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="ibu_kandung" name="ibu_kandung" id="ibu_kandung" type="text" class="validate  @error('ibu_kandung') is-invalid @enderror" value="{{ old('ibu_kandung',$mahasiswa->ibu_kandung) }}">
                        <label for="first_name">Nama Ibu<span style="color:red">*</span></label>
                        @error('ibu_kandung')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <select name="agama" id="agama">
                            <option value="">Agama</option>
                            <option value="islam" @if(old('agama',$mahasiswa->agama) == 'islam') selected @endif>Islam</option>
                            <option value="kristen" @if(old('agama',$mahasiswa->agama) == 'kristen') selected @endif>Kristen</option>
                            <option value="katolik" @if(old('agama',$mahasiswa->agama) == 'katolik') selected @endif>Katolik</option>
                            <option value="hindu" @if(old('agama',$mahasiswa->agama) == 'hindu') selected @endif>Hindu</option>
                            <option value="budha" @if(old('agama',$mahasiswa->agama) == 'budha') selected @endif>Budha</option>
                            <option value="konghucu" @if(old('agama',$mahasiswa->agama) == 'konghucu') selected @endif>Konghucu</option>
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
                                <option @if(old('kewarganegaraan_id', $mahasiswa->Detail->kewarganegaraan_id) == $row->id_country) selected @endif value="{{$row->id_country}}">{{$row->country_name}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Kewarganegaraan<span style="color:red">*</span></label>
                        @error('kewarganegaraan_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="input-field col s6  mt-3 mb-3">
                        <input placeholder="nik" name="nik" id="nik" type="text" class="validate  @error('nik') is-invalid @enderror" value="{{ old('nik',$mahasiswa->Detail->ktp) }}">
                        <label for="first_name">NIK<span style="color:red">*</span></label>

                        @error('nik')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s6  mt-2 mb-2">
                        <input placeholder="nisn" name="nisn" id="nisn" type="text" class="validate  @error('nisn') is-invalid @enderror" value="{{ old('nisn',$mahasiswa->Detail->nisn) }}">
                        <label for="first_name">NISN<span style="color:red">*</span></label>

                        @error('nisn')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s6  mt-2 mb-2">
                        <input placeholder="npwp" name="npwp" id="npwp" type="text" class="validate  @error('npwp') is-invalid @enderror" value="{{ old('npwp',$mahasiswa->Detail->npwp) }}">
                        <label for="first_name">NPWP</label>

                        @error('nisn')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>



                      <div class="input-field col s12 mt-2 mb-2">
                        <label for="first_name">Jalan</label>
                        <textarea  name="jalan" id="textarea2" class="materialize-textarea  @error('jalan') is-invalid @enderror">{{ old('jalan',$mahasiswa->Detail->jalan) }}</textarea>


                      @error('jalan')
                      <span class="red-text text-darken-2">{{ $message }}</small>
                      @enderror
                    </div>

                        <div class="input-field col s6 ">
                        <select name="province_id" class="select2 browser-default">
                            <option value="" disabled selected>Provinsi</option>
                            @foreach($province as $row)
                                <option  {{ old('province_id',$mahasiswa->Detail->province_id) == $row->id ? 'selected' : '' }}  value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                          </select>
                            <label for="first_name">Provinsi</label>
                        @error('province_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s6">
                        <select name="city_id" id="city_id" class="select2 browser-default">
                            <option value="" disabled selected>Kota</option>
                            @foreach($city as $row)
                            <option  {{ $mahasiswa->Detail->city_id  == $row->id ? 'selected' : '' }}  value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                        </select>
                        <label for="first_name">Kota</label>
                        @error('city_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s6">
                        <select name="district_id" id="district_id" class="select2 browser-default">
                            <option value="" disabled selected>Kecamatan</option>
                            @foreach($district as $row)
                            <option  {{  $mahasiswa->Detail->district_id  == $row->id ? 'selected' : '' }}  value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                        </select>
                        <label for="first_name">Kecamatan</label>
                        @error('district_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s6">
                        <select name="village_id" id="village_id" class="select2 browser-default">
                            <option value="" disabled selected>Kelurahan</option>
                            @foreach($village as $row)
                            <option  {{ $mahasiswa->Detail->village_id  == $row->id ? 'selected' : '' }}  value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                        </select>
                        <label for="first_name">Kelurahan</label>
                        @error('village_id')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="RT" name="rt" id="RT" type="number" class="validate  @error('rt') is-invalid @enderror" value="{{ old('rt',$mahasiswa->Detail->rt) }}">
                        <label for="first_name">RT</label>
                        @error('rt')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="RW" name="rw" id="RW" type="number" class="validate  @error('rw') is-invalid @enderror" value="{{ old('rw',$mahasiswa->Detail->rw) }}">
                        <label for="first_name">RW</label>
                        @error('rw')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="dusun" name="dusun" id="dusun" type="text" class="validate  @error('dusun') is-invalid @enderror" value="{{ old('dusun',$mahasiswa->Detail->dusun) }}">
                        <label for="first_name">Dusun</label>

                        @error('dusun')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="telephone" name="telephone" id="telephone" type="text" class="validate  @error('telephone') is-invalid @enderror" value="{{ old('telephone',$mahasiswa->Detail->telephone) }}">
                        <label for="first_name">Telephone</label>

                        @error('telephone')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4  mt-2 mb-2">
                        <input placeholder="handphone" name="handphone" id="handphone" type="text" class="validate  @error('handphone') is-invalid @enderror" value="{{ old('handphone',$mahasiswa->Detail->handphone) }}">
                        <label for="first_name">Handphone</label>

                        @error('handphone')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4  mt-2 mb-2">
                        <select name="penerima_kps" id="penerima_kps">
                            <option value="">Penerima KPS</option>
                            <option value="y" @if(old('agama',$mahasiswa->Detail->penerima_kps) == 'y') selected @endif >Ya</option>
                            <option value="n" @if(old('agama',$mahasiswa->Detail->penerima_kps) == 'n') selected @endif>Tidak</option>

                        </select>
                         <label for="first_name">Penerima KPS<span style="color:red">*</span></label>

                         @error('penerima_kps')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <div class="input-field col s6  mt-2 mb-2">
                        <select name="alat_transportasi" id="alat_transportasi">
                            <option value="">Alat Transportasi</option>
                            <option value="kereta api" @if(old('agama',$mahasiswa->Detail->alat_transportasi) == 'kereta api') selected @endif>Kereta Api</option>
                            <option value="angkutan umum"@if(old('agama',$mahasiswa->Detail->alat_transportasi) == 'angkutan umum') selected @endif>Angkutan Umum</option>
                            <option value="sepeda motor"@if(old('agama',$mahasiswa->Detail->alat_transportasi) == 'sepeda motor') selected @endif>Sepeda Motor</option>
                            <option value="sepeda"@if(old('agama',$mahasiswa->Detail->alat_transportasi) == 'sepeda') selected @endif>Sepeda</option>
                            <option value="mobil umum"@if(old('agama',$mahasiswa->Detail->alat_transportasi) == 'mobil_umum') selected @endif>Mobil atau bus jemputan</option>
                            <option value="perahu"@if(old('agama',$mahasiswa->Detail->alat_transportasi) == 'perahu') selected @endif>Perahu atau getek</option>
                            <option value="ojek"@if(old('agama',$mahasiswa->Detail->alat_transportasi) == 'ojek') selected @endif>Ojek</option>
                            <option value="jalan kaki"@if(old('agama',$mahasiswa->Detail->alat_transportasi) == 'jalan kaki') selected @endif>Jalan Kaki</option>
                            <option value="mobil pribadi"@if(old('agama',$mahasiswa->Detail->alat_transportasi) == 'mobil pribadi') selected @endif>Mobil Pribadi</option>
                        </select>
                         <label for="first_name">Alat Transportasi</label>

                         @error('alat_transportasi')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <div class="input-field col s6  mt-2 mb-2">
                        <select name="jenis_tinggal" id="jenis_tinggal">
                            <option value="">Jenis Tinggal</option>
                            <option value="asrama" @if(old('jenis_tinggal',$mahasiswa->Detail->jenis_tinggal) == 'asrama') selected @endif>Asrama</option>
                            <option value="panti asuhan"  @if(old('jenis_tinggal',$mahasiswa->Detail->jenis_tinggal) == 'panti asuhan') selected @endif>Panti Asuhan</option>
                            <option value="wali"  @if(old('jenis_tinggal',$mahasiswa->Detail->jenis_tinggal) == 'wali') selected @endif>Wali</option>
                            <option value="kost"  @if(old('jenis_tinggal',$mahasiswa->Detail->jenis_tinggal) == 'kost') selected @endif>Kost</option>
                            <option value="orang tua"  @if(old('jenis_tinggal',$mahasiswa->Detail->jenis_tinggal) == 'orang tua') selected @endif>Bersama Orang Tua</option>

                        </select>
                         <label for="first_name">Jenis Tinggal</label>

                         @error('jenis_tinggal')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>


                </div>
                <div id="test3" class="col s12">
                    <p class="mt-2 mb-2">Data Ayah</p>
                    <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="nama ayah" name="nama_ayah" id="nama_ayah" type="text" class="validate  @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah', $mahasiswa->OrangTua->nama_ayah) }}">
                        <label for="first_name">Nama</label>
                        @error('nama_ayah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="nik ayah" name="nik_ayah" id="nik_ayah" type="text" class="validate  @error('nik_ayah') is-invalid @enderror" value="{{ old('nik_ayah',$mahasiswa->OrangTua->nik_ayah) }}">
                        <label for="first_name">NIK</label>
                        @error('nik_ayah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="tanggal lahir" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" type="date" class="validate  @error('tanggal_lahir_ayah') is-invalid @enderror" value="{{ old('tanggal_lahir_ayah',$mahasiswa->OrangTua->tanggal_lahir_ayah) }}">
                        <label for="first_name">Tanggal Lahir</label>
                        @error('tanggal_lahir_ayah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                       <select name="pendidikan_ayah" id="pendidikan">
                           <option value="">pendidikan</option>
                           <option value="sd"  @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'sd') selected @endif>SD</option>
                           <option value="smp"  @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'smp') selected @endif>SMP</option>
                           <option value="sma"  @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'sma') selected @endif>SMA</option>
                           <option value="d1"  @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'd1') selected @endif>D1</option>
                           <option value="d2"  @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'd2') selected @endif>D2</option>
                           <option value="d3"  @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'd3') selected @endif>D3</option>
                           <option value="d4"  @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'd4') selected @endif>D4</option>
                           <option value="s1"  @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 's1') selected @endif>S1</option>
                           <option value="s2"  @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 's2') selected @endif>S2</option>
                           <option value="s3"  @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 's3') selected @endif>S3</option>
                           <option value="paket A " @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'paket A') selected @endif>Paket A</option>
                           <option value="paket B " @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'paket B') selected @endif>Paket B</option>
                           <option value="paket C " @if(old('pendidikan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'paket C') selected @endif>Paket C</option>
                           <option value="tidak sekolah"  @if(old('agama',$mahasiswa->OrangTua->pendidikan_ayah) == 'tidak Sekolah') selected @endif>Tidak Sekolah</option>
                       </select>
                        <label for="first_name">Pendidikan</label>
                        @error('pendidikan_ayah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <select name="pekerjaan_ayah" id="pekerjan">
                            <option value="">pekerjaan</option>
                            <option value="tidak bekerja" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pendidikan_ayah) == 'tidak bekerja') selected @endif>Tidak Bekerja</option>
                            <option value="petani" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'petani') selected @endif>Petani</option>
                            <option value="peternak" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'peternak') selected @endif>Peternak</option>
                            <option value="nelayan" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'nelayan') selected @endif>Nelayan</option>
                            <option value="pedagang kecil" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'pedagang kecil') selected @endif>Pedagang Kecil</option>
                            <option value="pedagang besar" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'pedagang besar') selected @endif>Pedagang Besar</option>
                            <option value="peneliti" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'peneliti') selected @endif>Peneliti</option>
                            <option value="karyawan swasta" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'karyawan swasta') selected @endif>Karyawan</option>
                            <option value="buruh" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'buruh') selected @endif>Buruh</option>
                            <option value="magang" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'magang') selected @endif>Magang</option>
                            <option value="wirausaha" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'wirausaha') selected @endif>Wirausaha</option>
                            <option value="konsultan" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'konsultasi') selected @endif>Konsultan</option>
                            <option value="pns/tni/polri" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'pns/tni/polri') selected @endif>PNS / TNI / POLRI</option>
                            <option value="pensiunan" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'pensiunan') selected @endif>pensiunan</option>
                            <option value="pimpinan" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'pimpinan') selected @endif>Pimpinan</option>
                            <option value="pengajar" @if(old('pekerjaan_ayah',$mahasiswa->OrangTua->pekerjaan_ayah) == 'pengajar') selected @endif>Pengajar</option>
                        </select>
                         <label for="first_name">Pekerjaan</label>
                         @error('pekerjaan_ayah')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <div class="input-field col s4 mt-2 mb-2">
                        <select name="penghasilan_ayah" id="pnghasilan">
                            <option value="">penghasilan</option>
                            <option value="dibawah 500.000" @if(old('penghasilan_ayah',$mahasiswa->OrangTua->penghasilan_ayah) == 'dibawah 500.000') selected @endif>Dibawah 500.000</option>
                            <option value="1000.000 - 2000.000" @if(old('penghasilan_ayah',$mahasiswa->OrangTua->penghasilan_ayah) == '1000.000 - 2000.000') selected @endif>1000.000 sd 2000.000</option>
                            <option value="2000.000 - 4000.000" @if(old('penghasilan_ayah',$mahasiswa->OrangTua->penghasilan_ayah) == '2000.000 - 4000.000') selected @endif>2000.000 sd 4000.000</option>
                            <option value="4000.000 - 5000.000" @if(old('penghasilan_ayah',$mahasiswa->OrangTua->penghasilan_ayah) == '4000.000 - 5000.000') selected @endif>4000.000 sd 5000.000</option>
                            <option value="5000.000 - 20.000.000" @if(old('penghasilan_ayah',$mahasiswa->OrangTua->penghasilan_ayah) == '5000.000 - 20.000.000') selected @endif>5000.000 sd 20.000.000</option>
                            <option value="diatas 20.000.000" @if(old('penghasilan_ayah',$mahasiswa->OrangTua->penghasilan_ayah) == 'diatas 20.000.000') selected @endif>diatas 20.000.000</option>
                        </select>
                         <label for="first_name">Penghasilan</label>
                         @error('penghasilan_ayah')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <p class="mt-2 mb-2">Data Ibu</p>
                       <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="nama ibu" name="nama_ibu" id="nama_ibu" type="text" class="validate  @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu',$mahasiswa->OrangTua->nama_ibu) }}">
                        <label for="first_name">Nama</label>
                        @error('nama_ibu')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="nik ibu" name="nik_ibu" id="nik_ibu" type="text" class="validate  @error('nik_ibu') is-invalid @enderror" value="{{ old('nik_ibu',$mahasiswa->OrangTua->nik_ibu) }}">
                        <label for="first_name">NIK</label>
                        @error('nik_ibu')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="tanggal lahir" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" type="date" class="validate  @error('tanggal_lahir_ibu') is-invalid @enderror" value="{{ old('tanggal_lahir_ibu',$mahasiswa->OrangTua->tanggal_lahir_ibu) }}">
                        <label for="first_name">Tanggal Lahir</label>
                        @error('tanggal_lahir_ibu')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                       <select name="pendidikan_ibu" id="pendidikan">
                        <option value="">pendidikan</option>
                        <option value="sd"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'sd') selected @endif>SD</option>
                        <option value="smp"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'smp') selected @endif>SMP</option>
                        <option value="sma"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'sma') selected @endif>SMA</option>
                        <option value="d1"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'd1') selected @endif>D1</option>
                        <option value="d2"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'd2') selected @endif>D2</option>
                        <option value="d3"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'd3') selected @endif>D3</option>
                        <option value="d4"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'd4') selected @endif>D4</option>
                        <option value="s1"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 's1') selected @endif>S1</option>
                        <option value="s2"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 's2') selected @endif>S2</option>
                        <option value="s3"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 's3') selected @endif>S3</option>
                        <option value="paket A " @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'paket A') selected @endif>Paket A</option>
                        <option value="paket B " @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'paket B') selected @endif>Paket B</option>
                        <option value="paket C " @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'paket C') selected @endif>Paket C</option>
                        <option value="tidak sekolah"  @if(old('pendidikan_ibu',$mahasiswa->OrangTua->pendidikan_ibu) == 'tidak Sekolah') selected @endif>Tidak Sekolah</option>
                       </select>
                        <label for="first_name">Pendidikan</label>
                        @error('pendidikan_ibu')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <select name="pekerjaan_ibu" id="pekerjan">
                            <option value="">pekerjaan</option>
                            <option value="tidak bekerja" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'tidak bekerja') selected @endif>Tidak Bekerja</option>
                            <option value="petani" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'petani') selected @endif>Petani</option>
                            <option value="peternak" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'peternak') selected @endif>Peternak</option>
                            <option value="nelayan" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'nelayan') selected @endif>Nelayan</option>
                            <option value="pedagang kecil" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'pedagang kecil') selected @endif>Pedagang Kecil</option>
                            <option value="pedagang besar" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'pedagang besar') selected @endif>Pedagang Besar</option>
                            <option value="peneliti" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'peneliti') selected @endif>Peneliti</option>
                            <option value="karyawan swasta" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'karyawan swasta') selected @endif>Karyawan</option>
                            <option value="buruh" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'buruh') selected @endif>Buruh</option>
                            <option value="magang" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'magang') selected @endif>Magang</option>
                            <option value="wirausaha" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'wirausaha') selected @endif>Wirausaha</option>
                            <option value="konsultan" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'konsultasi') selected @endif>Konsultan</option>
                            <option value="pns/tni/polri" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ayah) == 'pns/tni/polri') selected @endif>PNS / TNI / POLRI</option>
                            <option value="pensiunan" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'pensiunan') selected @endif>pensiunan</option>
                            <option value="pimpinan" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'pimpinan') selected @endif>Pimpinan</option>
                            <option value="pengajar" @if(old('pekerjaan_ibu',$mahasiswa->OrangTua->pekerjaan_ibu) == 'pengajar') selected @endif>Pengajar</option>
                        </select>
                         <label for="first_name">Pekerjaan</label>
                         @error('pekerjaan_ibu')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <div class="input-field col s4 mt-2 mb-2">
                        <select name="penghasilan_ibu" id="pnghasilan">
                            <option value="">penghasilan</option>
                            <option value="dibawah 500.000" @if(old('penghasilan_ibu',$mahasiswa->OrangTua->penghasilan_ibu) == 'dibawah 500.000') selected @endif>Dibawah 500.000</option>
                            <option value="1000.000 - 2000.000" @if(old('penghasilan_ibu',$mahasiswa->OrangTua->penghasilan_ibu) == '1000.000 - 2000.000') selected @endif>1000.000 sd 2000.000</option>
                            <option value="2000.000 - 4000.000" @if(old('penghasilan_ibu',$mahasiswa->OrangTua->penghasilan_ibu) == '2000.000 - 4000.000') selected @endif>2000.000 sd 4000.000</option>
                            <option value="4000.000 - 5000.000" @if(old('penghasilan_ibu',$mahasiswa->OrangTua->penghasilan_ibu) == '4000.000 - 5000.000') selected @endif>4000.000 sd 5000.000</option>
                            <option value="5000.000 - 20.000.000" @if(old('penghasilan_ibu',$mahasiswa->OrangTua->penghasilan_ibu) == '5000.000 - 20.000.000') selected @endif>5000.000 sd 20.000.000</option>
                            <option value="diatas 20.000.000" @if(old('penghasilan_ibu',$mahasiswa->OrangTua->penghasilan_ibu) == 'diatas 20.000.000') selected @endif>diatas 20.000.000</option>
                        </select>
                         <label for="first_name">Penghasilan</label>
                         @error('penghasilan_ibu')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>
                </div>
                <div id="test4" class="col s12">
                    <div class="input-field col s4 mt-3 mb-2">
                        <input placeholder="nama wali" name="nama_wali" id="nama_wali" type="text" class="validate  @error('nama_wali') is-invalid @enderror" value="{{ old('nama_wali', $mahasiswa->Wali->nama) }}">
                        <label for="first_name">Nama</label>
                        @error('nama_wali')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="tanggal lahir" name="tanggal_lahir_wali" id="tanggal_lahir_wali" type="date" class="validate  @error('tanggal_lahir_wali') is-invalid @enderror" value="{{ old('tanggal_lahir_wali',$mahasiswa->Wali->tanggal_lahir_wali) }}">
                        <label for="first_name">Tanggal Lahir</label>
                        @error('tanggal_lahir_wali')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                       <select name="pendidikan_wali" id="pendidikan">
                        <option value="">pendidikan</option>
                        <option value="sd"  @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 'sd') selected @endif>SD</option>
                        <option value="smp"  @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 'smp') selected @endif>SMP</option>
                        <option value="sma"  @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 'sma') selected @endif>SMA</option>
                        <option value="d1"  @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_ibu) == 'd1') selected @endif>D1</option>
                        <option value="d2"  @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 'd2') selected @endif>D2</option>
                        <option value="d3"  @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 'd3') selected @endif>D3</option>
                        <option value="d4"  @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 'd4') selected @endif>D4</option>
                        <option value="s1"  @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 's1') selected @endif>S1</option>
                        <option value="s2"  @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 's2') selected @endif>S2</option>
                        <option value="s3"  @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 's3') selected @endif>S3</option>
                        <option value="paket A " @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 'paket A') selected @endif>Paket A</option>
                        <option value="paket B " @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 'paket B') selected @endif>Paket B</option>
                        <option value="paket C " @if(old('pendidikan_wali',$mahasiswa->Wali->pendidikan_wali) == 'paket C') selected @endif>Paket C</option>
                        <option value="tidak sekolah"  @if(old('pendidikan_ibu',$mahasiswa->Wali->pendidikan_ibu) == 'tidak Sekolah') selected @endif>Tidak Sekolah</option>
                       </select>
                        <label for="first_name">Pendidikan</label>
                        @error('pendidikan_wali')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 mt-2 mb-2">
                        <select name="pekerjaan_wali" id="pekerjan">
                            <option value="">pekerjaan</option>
                            <option value="tidak bekerja" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'tidak bekerja') selected @endif>Tidak Bekerja</option>
                            <option value="petani" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'petani') selected @endif>Petani</option>
                            <option value="peternak" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'peternak') selected @endif>Peternak</option>
                            <option value="nelayan" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'nelayan') selected @endif>Nelayan</option>
                            <option value="pedagang kecil" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'pedagang kecil') selected @endif>Pedagang Kecil</option>
                            <option value="pedagang besar" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'pedagang besar') selected @endif>Pedagang Besar</option>
                            <option value="peneliti" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'peneliti') selected @endif>Peneliti</option>
                            <option value="karyawan swasta" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'karyawan swasta') selected @endif>Karyawan</option>
                            <option value="buruh" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'buruh') selected @endif>Buruh</option>
                            <option value="magang" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'magang') selected @endif>Magang</option>
                            <option value="wirausaha" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'wirausaha') selected @endif>Wirausaha</option>
                            <option value="konsultan" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'konsultasi') selected @endif>Konsultan</option>
                            <option value="pns/tni/polri" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_ayah) == 'pns/tni/polri') selected @endif>PNS / TNI / POLRI</option>
                            <option value="pensiunan" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'pensiunan') selected @endif>pensiunan</option>
                            <option value="pimpinan" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'pimpinan') selected @endif>Pimpinan</option>
                            <option value="pengajar" @if(old('pekerjaan_wali',$mahasiswa->Wali->pekerjaan_wali) == 'pengajar') selected @endif>Pengajar</option>
                        </select>
                         <label for="first_name">Pekerjaan</label>
                         @error('pekerjaan_wali')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>

                       <div class="input-field col s4 mt-2 mb-2">
                        <select name="penghasilan_wali" id="pnghasilan">
                            <option value="">penghasilan</option>
                            <option value="dibawah 500.000" @if(old('penghasilan_Wali',$mahasiswa->Wali->penghasilan_ibu) == 'dibawah 500.000') selected @endif>Dibawah 500.000</option>
                            <option value="1000.000 - 2000.000" @if(old('penghasilan_Wali',$mahasiswa->Wali->penghasilan_ibu) == '1000.000 - 2000.000') selected @endif>1000.000 sd 2000.000</option>
                            <option value="2000.000 - 4000.000" @if(old('penghasilan_Wali',$mahasiswa->Wali->penghasilan_ibu) == '2000.000 - 4000.000') selected @endif>2000.000 sd 4000.000</option>
                            <option value="4000.000 - 5000.000" @if(old('penghasilan_Wali',$mahasiswa->Wali->penghasilan_ibu) == '4000.000 - 5000.000') selected @endif>4000.000 sd 5000.000</option>
                            <option value="5000.000 - 20.000.000" @if(old('penghasilan_Wali',$mahasiswa->Wali->penghasilan_ibu) == '5000.000 - 20.000.000') selected @endif>5000.000 sd 20.000.000</option>
                            <option value="diatas 20.000.000" @if(old('penghasilan_Wali',$mahasiswa->Wali->penghasilan_ibu) == 'diatas 20.000.000') selected @endif>diatas 20.000.000</option>
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
                            <option value="y"  @if(old('kebutuhan_khusus',$mahasiswa->KebutuhanKhusus->kebutuhan_khusus) == 'y') selected @endif>Ya</option>
                            <option value="n"  @if(old('kebutuhan_khusus',$mahasiswa->KebutuhanKhusus->kebutuhan_khusus) == 'n') selected @endif>Tidak</option>
                        </select>
                         <label for="first_name">Kebutuhan Khusus</label>

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
