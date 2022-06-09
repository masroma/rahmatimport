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
                       <li class="tab col m2"><a href="#test2">Detail</a></li>
                       <li class="tab col m2"><a href="#test3">Alamat</a></li>
                       <li class="tab col m2"><a href="#test4">Keluarga</a></li>
                       <li class="tab col "><a href="#test5">Kebutuhan Khusus</a></li>
                    </ul>
                 </div>
                 <div class="col s12 mt-3">
                    <div id="test1" class="col s12 ">
                        <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="nama" name="nidn" id="nidn" type="text" class="validate  @error('nidn') is-invalid @enderror" value="{{ old('nidn') }}">
                            <label for="first_name">NIDN</label>

                            @error('nidn')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
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

                           {{-- detail --}}
                           <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="NIP" name="nip" id="nip" type="text" class="validate  @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                            <label for="first_name">NIP</label>

                            @error('nip')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="NIK" name="nik" id="nik" type="text" class="validate  @error('nik') is-invalid @enderror" value="{{ old('nik') }}">
                            <label for="first_name">NIK<span style="color:red">*</span></label>

                            @error('nik')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="NPWP" name="npwp" id="npwp" type="text" class="validate  @error('npwp') is-invalid @enderror" value="{{ old('npwp') }}">
                            <label for="first_name">NPWP</label>

                            @error('npwp')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="Telephone" name="telephone" id="telephone" type="text" class="validate  @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                            <label for="first_name">Telephone</label>

                            @error('telephone')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="Handphone" name="telephone" id="handphone" type="text" class="validate  @error('handphone') is-invalid @enderror" value="{{ old('handphone') }}">
                            <label for="first_name">Handphone</label>

                            @error('handphone')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="Handphone" name="email" id="email" type="text" class="validate  @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            <label for="first_name">Email</label>

                            @error('email')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                    </div>
                    <div id="test2" class="col s12 ">
                        <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="ikatan kerja" name="ikatan_kerja" id="ikatan_kerja" type="text" class="validate  @error('ikatan_kerja') is-invalid @enderror" value="{{ old('ikatan_kerja') }}">
                            <label for="first_name">Ikatan Kerja</label>

                            @error('ikatan_kerja')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                        <div class="input-field col s4  mt-2 mb-2">
                            {{-- <input placeholder="status pegawai" name="status_pegawai" id="status_pegawai" type="text" class="validate  @error('status_pegawai') is-invalid @enderror" value="{{ old('status_pegawai') }}"> --}}
                            <select name="status_pegawai" id="status_pegawai">
                                <option value=""></option>
                                <option value="cpns" @if(old('status_pegawai') == 'cpns') selected @endif>Calon Pegawai Negeri Sipil</option>
                                <option value="honorer" @if(old('status_pegawai') == 'honorer') selected @endif>Honorer</option>
                                <option value="pns" @if(old('status_pegawai') == 'pns') selected @endif>Pegawai Negeri Sipil</option>
                                <option value="pty" @if(old('status_pegawai') == 'pty') selected @endif>Pegawai Tetap Yayasam</option>
                            </select>
                            <label for="first_name">Status Pegawai</label>

                            @error('status_pegawai')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>

                          <div class="input-field col s4  mt-2 mb-2">
                            {{-- <input placeholder="status pegawai" name="status_pegawai" id="status_pegawai" type="text" class="validate  @error('status_pegawai') is-invalid @enderror" value="{{ old('status_pegawai') }}"> --}}
                            <select name="jenis_pegawai" id="jenis_pegawai" disabled>
                                <option value=""></option>
                                <option value="dosen" selected>Dosen</option>
                                <option value="tendik" >Tenaga Pendidik</option>

                            </select>
                            <label for="first_name">Status Pegawai</label>

                            @error('jenis_pegawai')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>

                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="no sk cpns" name="no_sk_cpns" id="no_sk_cpns" type="text" class="validate  @error('no_sk_cpns') is-invalid @enderror" value="{{ old('no_sk_cpns') }}">
                            <label for="first_name">No SK CPNS</label>

                            @error('no_sk_cpns')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>

                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="tanggal sk cpns" name="tanggal_sk_cpns" id="tanggal_sk_cpns" type="date" class="validate  @error('tanggal_sk_cpns') is-invalid @enderror" value="{{ old('tanggal_sk_cpns') }}">
                            <label for="first_name">Tanggal SK CPNS</label>

                            @error('tanggal_sk_cpns')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>

                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="no sk pengangkatan" name="no_sk_pengangkatan" id="no_sk_pengangkatan" type="text" class="validate  @error('no_sk_pengangkatan') is-invalid @enderror" value="{{ old('no_sk_pengangkatan') }}">
                            <label for="first_name">No SK Pengangkatan</label>

                            @error('no_sk_pengangkatan')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>

                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="tanggal sk pengangkatan" name="tanggal_sk_pengangkatan" id="tanggal_sk_pengangkatan" type="date" class="validate  @error('tanggal_sk_pengangkatan') is-invalid @enderror" value="{{ old('tanggal_sk_pengangkatan') }}">
                            <label for="first_name">Tanggal SK Pengangkatan</label>

                            @error('tanggal_sk_pengangkatan')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>

                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="lembaga pengangkatan" name="lembaga_pengangkatan" id="lembaga_pengangkatan" type="text" class="validate  @error('lembaga_pengangkatan') is-invalid @enderror" value="{{ old('lembaga_pengangkatan') }}">
                            <label for="first_name">Lembaga Pengangkatan</label>

                            @error('lembaga_pengangkatan')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>

                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="pangkat golongan" name="pangkat_golongan" id="pangkat_golongan" type="text" class="validate  @error('pangkat_golongan') is-invalid @enderror" value="{{ old('pangkat_golongan') }}">
                            <label for="first_name">Pangkat Golongan</label>

                            @error('pangkat_golongan')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>

                          <div class="input-field col s4  mt-2 mb-2">
                            <input placeholder="sumber_lainya" name="sumber_lainya" id="sumber_lainya" type="text" class="validate  @error('sumber_lainya') is-invalid @enderror" value="{{ old('sumber_lainya') }}">
                            <label for="first_name">Sumber Lainya</label>

                            @error('sumber_lainya')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>


                    </div>
                    <div id="test3" class="col s12 ">

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

                      <div class="input-field col s4 mt-2 mb-2">
                        <input placeholder="Kode Pos" name="kode_pos" id="kode_pos" type="number" class="validate  @error('kode_pos') is-invalid @enderror" value="{{ old('kode_pos') }}">
                        <label for="first_name">Kode Pos</label>
                        @error('kode_pos')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                    </div>
                 </div>

                 <div id="test4" class="col s12 ">
                    <div class="input-field col s4  mt-2 mb-2">
                        {{-- <input placeholder="status pegawai" name="status_pegawai" id="status_pegawai" type="text" class="validate  @error('status_pegawai') is-invalid @enderror" value="{{ old('status_pegawai') }}"> --}}
                        <select name="status_pernikahan" id="status_pernikahan">
                            <option value=""></option>
                            <option value="belum menikah" @if(old('status_pernikahan') == 'belum menikah') selected @endif>Belum Menikah</option>
                            <option value="sudah menikah" @if(old('status_pernikahan') == 'sudah menikah') selected @endif>Sudah Menikah</option>
                            <option value="bercerai" @if(old('bercerai') == 'bercerai') selected @endif>Bercerai</option>

                        </select>
                        <label for="first_name">Status Pernikahan</label>

                        @error('status_pernikahan')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>


                 <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="nama pasangan " name="nama_pasangan" id="nama_pasangan" type="text" class="validate  @error('nama_pasangan') is-invalid @enderror" value="{{ old('nama_pasangan') }}">
                    <label for="first_name">Nama Pasangan </label>

                    @error('nama_pasangan')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="nip pasangan " name="nip_pasangan" id="nip_pasangan" type="text" class="validate  @error('nip_pasangan') is-invalid @enderror" value="{{ old('nip_pasangan') }}">
                    <label for="first_name">NIP Pasangan </label>

                    @error('nip_pasangan')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="tmt pasangan " name="tmt_pasangan" id="tmt_pasangan" type="text" class="validate  @error('tmt_pasangan') is-invalid @enderror" value="{{ old('tmt_pasangan') }}">
                    <label for="first_name">TMT Pasangan </label>

                    @error('tmt_pasangan')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4  mt-2 mb-2">
                    <input placeholder="pekerjaan" name="pekerjaan" id="pekerjaan" type="text" class="validate  @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan') }}">
                    <label for="first_name">Pekerjaan </label>

                    @error('pekerjaan')
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


</div><!-- START RIGHT SIDEBAR NAV -->

</div>
      </div>
      <div class="content-overlay"></div>
    </div>
  </div>





@endsection
