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
                <div class="row">
                    <div class="input-field col s12">
                      <label for=""><b>Informasi Kampus</b></label>
                      <br>
                    </div>
                  <div class="input-field col s4">
                    <input placeholder="kode_kampus" name="kode_kampus" id="kode_kampus" type="text" class="validate  @error('kode_kampus') is-invalid @enderror" value="{{ old('kode_kampus') }}">
                    <label for="first_name">Kode Kampus</label>

                    @error('kode_kampus')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s4">
                    <input placeholder="cabang_kampus" name="cabang_kampus" id="cabang_kampus" type="text" class="validate  @error('cabang_kampus') is-invalid @enderror" value="{{ old('cabang_kampus') }}">
                    <label for="first_name">Cabang Kampus</label>

                    @error('cabang_kampus')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="input-field col s4">
                    <input placeholder="telephone" name="telephone" id="telephone" type="number" class="validate  @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                    <label for="first_name">Telephone</label>
                    @error('telephone')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4">
                    <input placeholder="faximile" name="faximile" id="faximile" type="text" class="validate  @error('faximile') is-invalid @enderror" value="{{ old('faximile') }}">
                    <label for="first_name">Faximile</label>
                    @error('faximile')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4">
                    <input placeholder="email" name="email" id="email" type="text" class="validate  @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    <label for="first_name">email</label>
                    @error('email')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4">
                    <input placeholder="website" name="website" id="website" type="text" class="validate  @error('email') is-invalid @enderror" value="{{ old('website') }}">
                    <label for="first_name">website</label>
                    @error('website')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>



                  {{-- jalan --}}
                  <div class="input-field col s12">
                    <label for=""><b>Alamat Kampus</b></label>
                    <br>
                  </div>
                <div class="input-field col s12">
                    <label for="first_name">Jalan</label>
                    <textarea  name="jalan" id="textarea2" class="materialize-textarea  @error('jalan') is-invalid @enderror">{{ old('jalan') }}</textarea>


                  @error('jalan')
                  <span class="red-text text-darken-2">{{ $message }}</small>
                  @enderror
                </div>

                <div class="input-field col s6">
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

                  <div class="input-field col s6">
                    <select name="city_id" id="city_id" class="select2 browser-default">
                        {{-- <option value="" disabled selected>Kota</option> --}}
                    </select>
                    <label for="first_name">Kota</label>
                    @error('city_id')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s6">
                    <select name="district_id" id="district_id" class="select2 browser-default">
                        {{-- <option value="" disabled selected>Kecamatan</option> --}}
                    </select>
                    <label for="first_name">Kecamatan</label>
                    @error('district_id')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s6">
                    <select name="village_id" id="village_id" class="select2 browser-default">
                        {{-- <option value="" disabled selected>Kecamatan</option> --}}
                    </select>
                    <label for="first_name">Kelurahan</label>
                    @error('village_id')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4">
                    <input placeholder="kode_pos" name="kode_pos" id="kode_pos" type="number" class="validate  @error('kode_pos') is-invalid @enderror" value="{{ old('kode_pos') }}">
                    <label for="first_name">Kode Pos</label>
                    @error('kode_pos')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4">
                    <input placeholder="RT" name="rt" id="RT" type="number" class="validate  @error('rt') is-invalid @enderror" value="{{ old('rt') }}">
                    <label for="first_name">RT</label>
                    @error('rt')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s4">
                    <input placeholder="RW" name="rw" id="RW" type="number" class="validate  @error('rw') is-invalid @enderror" value="{{ old('rw') }}">
                    <label for="first_name">RW</label>
                    @error('rw')
                    <span class="red-text text-darken-2">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="input-field col s12">
                    <label for=""><b>Informasi Kampus</b></label>
                    <br>
                  </div>

                  <div class="input-field col s4">
                    <input placeholder="bank" name="bank" id="bank" type="text" class="validate  @error('bank') is-invalid @enderror" value="{{ old('bank') }}">
                    <label for="first_name">Bank</label>

                    @error('bank')
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
                        $('select[name="city_id"]').append('<option value="" disabled selected>Kota</option>');
                        $.each(data, function(key, value){
                            $('select[name="city_id"]').append('<option value="'+value.id+'">'+value.name+'</option>')
                        });
                    }
                });
            }else{
                $('select[name="city_id"]').append('<option value="" disabled selected>Kota</option>');
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
                        $('select[name="district_id"]').append('<option value="" disabled selected>Kecamatan </option>');
                        $.each(data, function(key, value){
                            $('select[name="district_id"]').append('<option value="'+value.id+'">'+value.name+'</option>')
                        });
                    }
                });
            }else{
                $('select[name="district_id"]').append('<option value="" disabled selected>Kecamatan </option>');
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
                        console.log(data)
                        $('select[name="village_id"]').append('<option value="" disabled selected>Kelurahan </option>');
                        $.each(data, function(key, value){
                            $('select[name="village_id"]').append('<option value="'+value.id+'">'+value.name+'</option>')
                        });
                    }
                });
            }else{
                $('select[name="village_id"]').append('<option value="" disabled selected>Kelurahan </option>');
            }
        });



      });
    </script>





@endsection
