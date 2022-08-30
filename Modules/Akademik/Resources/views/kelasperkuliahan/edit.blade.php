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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Edit data {{$title}}</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
               <li class="breadcrumb-item"><a href="{{route($page.'.index')}}">{{$title}}</a>
              </li>
              <li class="breadcrumb-item active">edit
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

<div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-content">
          {{-- <h4 class="card-title">Page Length Options</h4> --}}
          <div class="row">
                <form action="{{ route('kelasperkuliahan.update',$kelasperkuliahan->id) }}" method="POST"
                enctype="multipart/form-data" class="col s12">
                @csrf
                <div class="row">
                    <div class="row">
                        <div class="input-field col s6 ">
                            <select name="programstudy_id" class="select2 browser-default">
                                <option value="">Program Study</option>
                                @foreach($programstudy as $row)
                                    <option @if(old('programstudy_id',$kelasperkuliahan->programstudy_id) == $row->id) selected @endif value="{{$row->id}}">{{ $row->jenjang->nama_jenjang }}-{{$row->jurusan->nama_jurusan}}</option>
                                @endforeach
                              </select>
                                <label for="first_name">Program Study<span style="color:red">*</span></label>
                            @error('programstudy_id')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="input-field col s6">
                            <select name="semester_id" class="select2 browser-default">
                                <option value="">Semester</option>
                                @foreach($jenissemester as $row)
                                    <option @if(old('semester_id',$kelasperkuliahan->semester_id) == $row->id) selected @endif value="{{$row->id}}">{{ $row->Tahunajaran->tahun_ajaran }}-{{$row->jenis_semester}}</option>
                                @endforeach
                              </select>
                                <label for="first_name">Semester<span style="color:red">*</span></label>
                            @error('semester_id')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <select name="matakuliah_id" class="select2 browser-default">
                                <option value="">Mata Kuliah</option>
                                @foreach($matakuliah as $row)
                                    <option @if(old('matakuliah_id',$kelasperkuliahan->matakuliah_id) == $row->id) selected @endif value="{{$row->id}}">{{ $row->kode_matakuliah }}-{{$row->nama_matakuliah}}</option>
                                @endforeach
                              </select>
                                <label for="first_name">Matakuliah<span style="color:red">*</span></label>
                            @error('matakuliah_id')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="input-field col s6">
                            <input placeholder="nama kelas " name="nama_kelas" id="nama_kelas" type="text" class="validate  @error('nama_kelas') is-invalid @enderror" value="{{ old('nama_kelas',$kelasperkuliahan->nama_kelas) }}">
                            <label for="first_name">Nama Kelas</label>

                            @error('nama_kelas')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                          </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <select name="lingkup" class="select2 browser-default">
                                <option value="">lingkup</option>
                                <option value="internal" @if(old('lingkup',$kelasperkuliahan->lingkup) == 'internal') selected @endif>Internal</option>
                                <option value="external"  @if(old('lingkup',$kelasperkuliahan->lingkup) == 'external') selected @endif>External</option>
                                <option value="campuran"  @if(old('lingkup',$kelasperkuliahan->lingkup) == 'campuran') selected @endif>Campuran</option>
                              </select>
                                <label for="first_name">Lingkup</label>
                            @error('lingkup')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="input-field col s6">
                            <select name="mode_kuliah" class="select2 browser-default">
                                <option value="">lingkup</option>
                                <option value="online" @if(old('mode_kuliah',$kelasperkuliahan->mode_kuliah) == 'online') selected @endif>Online</option>
                                <option value="offline"  @if(old('mode_kuliah',$kelasperkuliahan->mode_kuliah) == 'offline') selected @endif>Offline</option>
                                <option value="campuran"  @if(old('mode_kuliah',$kelasperkuliahan->mode_kuliah) == 'campuran') selected @endif>Campuran</option>
                              </select>
                                <label for="first_name">Mode Kuliah</label>
                            @error('mode_kuliah')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="row">
                      <div class="input-field col s4">
                        <input placeholder="tanggal mulai efektif " name="tanggal_mulai_kuliah" id="tanggal_mulai_kuliah" type="date" class="validate  @error('tanggal_mulai_kuliah') is-invalid @enderror" value="{{ old('tanggal_mulai_kuliah',$kelasperkuliahan->tanggal_mulai_kuliah) }}">
                        <label for="first_name">Tanggal Mulai kuliah</label>

                        @error('tanggal_mulai_efektif')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="input-field col s4 ">
                        <input placeholder="tanggal akhir kuliah " name="tanggal_akhir_kuliah" id="tanggal_akhir_kuliah" type="date" class="validate  @error('tanggal_akhir_efektif') is-invalid @enderror" value="{{ old('tanggal_akhir_kuliah',$kelasperkuliahan->tanggal_akhir_kuliah) }}">
                        <label for="first_name">Tanggal Akhir kuliah</label>

                        @error('tanggal_akhir_kuliah')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                      </div>

                      <div class="input-field col s4 my-5">

                        <div class="d-flex">
                         <label for="first_name">Type Mahasiswa Yang Bisa mengikuti Kelas ini selain reguler</label>

                         @foreach($typemahasiswa as $m)
                            <p>
                             <label>
                                 <input type="checkbox" name="type_mahasiswa[]"  value="{{ old('type_mahasiswa',$m->type_mahasiswa) }}"
                                 <?php $namemenu = $m->type_mahasiswa; ?> @if($kelasperkuliahan->typemahasiswa_id) {{ in_array($m->type_mahasiswa, json_decode($kelasperkuliahan->typemahasiswa_id)) ? 'checked' : '' }} @endif  />
                                 <span>Kelas {{ $m->type_mahasiswa }}</span>
                               </label>
                            </p>
                            @endforeach
                        </div>

                         @error('type_mahasiswa')
                         <span class="red-text text-darken-2">{{ $message }}</small>
                         @enderror
                       </div>



                    </div>

                    <div class="row">
                       


                        <div class="input-field col s4">
                            <select name="jenis_kelas" class="select2 browser-default">
                                <option value="">jenis_kelas</option>
                                <option value="reguler" {{ old('jenis_kelas',$kelasperkuliahan->jenis_kelas) == 'reguler' ? 'selected' : '' }} >Reguler</option>
                                <option value="paralel"  {{ old('jenis_kelas',$kelasperkuliahan->jenis_kelas) == 'paralel' ? 'selected' : '' }}>Paralel</option>

                              </select>
                                <label for="first_name">Jenis Kelas</label>
                            @error('jenis_kelas')
                            <span class="red-text text-darken-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="input-field col s4">
                          <input placeholder="min_peserta" name="min_peserta" id="min_peserta" type="number" class="validate  @error('min_peserta') is-invalid @enderror" value="{{ old('min_peserta',$kelasperkuliahan->min_peserta) }}">
                          <label for="first_name">Minimal Peserta</label>
  
                          @error('min_peserta')
                          <span class="red-text text-darken-2">{{ $message }}</small>
                          @enderror
                        </div>

                        <div class="input-field col s4">
                          <input placeholder="max_peserta" name="max_peserta" id="max_peserta" type="number" class="validate  @error('max_peserta') is-invalid @enderror" value="{{ old('max_peserta',$kelasperkuliahan->max_peserta) }}">
                          <label for="first_name">Maximal Peserta</label>
  
                          @error('max_peserta')
                          <span class="red-text text-darken-2">{{ $message }}</small>
                          @enderror
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

<div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-content">
        <div class="row mb-3">
            <div class="col s6">
                <h5 class="cart-title">Data Dosen Pengajar</h5>
            </div>
            <div class="col s6">
                <a class="btn  waves-effect waves-light breadcrumbs-btn right" href="{{route('kelasperkuliahan.createdosenperkuliahan',$kelasperkuliahan->id)}}"  id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a>
            </div>
        </div>
          <div class="row">
            <div class="col s12">
              <table id="page-length-option" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIDN</th>
                        <th>Nama</th>
                        <th>Bobot SKS</th>
                        <th>Rencana Pertemuan</th>
                        <th>Realisasi Pertemuan</th>
                        <th>#</th>
                    </tr>

                </thead>
                <tfoot>
                    <tr>
                        <th colspan="3">Total SKS</th>

                        <th>{{ $sum = DB::table('dosen_perkuliahans')->where('kelasperkuliahan_id',$kelasperkuliahan->id)->where('deleted_at',NULL)->sum('dosen_perkuliahans.bobot_sks'); }}</th>
                        <th colspan="3"></th>
                    </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>-

</div>
      </div>
      <div class="content-overlay"></div>
    </div>
  </div>



  @stop
  @section('script')
  <script>

    // ini vendor data
    (function() {
            loadDataTable();
        })();

        function loadDataTable() {
            $(document).ready(function () {
                let idkelasperkuliahan = {{ $kelasperkuliahan->id }}
                $('#page-length-option').DataTable({
                    "scrollX": true,
                    "autoWidth": true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('akademik/kelasperkuliahan/datadosen') }}/" + idkelasperkuliahan,
                        type: "GET",
                    },
                    columns: [
                        {
                            data:"DT_RowIndex",
                            name:"DT_RowIndex"
                        },

                        {
                            data:"dosen.nidn",
                            name:"dosen.nidn"
                        },

                        {
                            data:"dosen.nama_dosen",
                            name:"dosen.nama_dosen"
                        },


                        {
                            data: 'bobot_sks',
                            name: 'bobot_sks'
                        },


                        {
                            data: 'jumlah_rencana_pertemuan',
                            name: 'jumlah_rencana_pertemuan'
                        },

                        {
                            data: 'jumlah_realisasi_pertemuan',
                            name: 'jumlah_realisasi_pertemuan'
                        },

                        {
                            data: 'action',
                            name: 'action'
                        },

                    ],
                    order: [
                        [0, 'asc']
                    ]
                });
            });
        }

   function deleteConfirm(id) {
            swal({
                    title: "Kamu Yakin ?",
                    text: "akan menghapus data ini !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((dt) => {
                    if (dt) {
                        window.location.href = "{{ url('akademik/kelasperkuliahan') }}/" + id + "/deletedosenpengajar";
                    }
                });
        }
  </script>

@endsection
