@extends('layouts.v1')
@section('title')
    {{ $page }}
@endsection
@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0"><span>Edit data {{ $page }}</span></h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">{{ $page }}</a>
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
                                        <div class="input-field col m6">
                                            <input type="text" readonly
                                                value="{{ $aktivitas->aktivitas_mahasiswa->judul }}">
                                            <label for="first_name">Judul</label>
                                        </div>
                                        <div class="input-field col m6">
                                            <input type="text" readonly value="{{ $aktivitas->Mahasiswa->nama }}">
                                            <label for="first_name">Nama</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col m6">
                                            <input type="text" readonly
                                                value="{{ $aktivitas->aktivitas_mahasiswa->Semester->jenis_semester }} {{ $aktivitas->aktivitas_mahasiswa->Semester->Tahunajaran->tahun_ajaran }}">
                                            <label for="first_name">Semester</label>
                                        </div>
                                        <div class="input-field col m6">
                                            <input type="text" readonly value="{{ $aktivitas->Mahasiswa->nim }}">
                                            <label for="first_name">NIM</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col m6">
                                            <input type="text" readonly
                                                value="{{ $aktivitas->aktivitas_mahasiswa->JenisAktivitas->jenis_aktivitas }}">
                                            <label for="first_name">Jenis Aktivitas</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col s2 m6 l6">
                                            <h4 class="card-title">Nilai</h4>
                                        </div>
                                        <div class="col s2 m6 l6">
                                            <a class="btn waves-effect waves-light cyan modal-trigger breadcrumbs-btn right me-3"
                                                style="margin-top:-3px; margin-left:10px" href="#addNilai"
                                                id="tombol-tambah"><i class="material-icons left">add</i>Tambah</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <table id="nilaiTable" class="centered">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">No</th>
                                                        <th rowspan="2">Mata Kuliah</th>
                                                        <th rowspan="2">SKS</th>
                                                        <th colspan="3">Nilai</th>
                                                        <th rowspan="2">#</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Angka</th>
                                                        <th>Huruf</th>
                                                        <th>Indeks</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td rowspan="2">No</td>
                                                        <td rowspan="2">Mata Kuliah</td>
                                                        <td rowspan="2">SKS</td>
                                                        <td>Angka</td>
                                                        <td>Huruf</td>
                                                        <td>Indeks</td>
                                                        <td rowspan="2">#</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">Nilai</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
    </div>
    <div id="addNilai" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Detail KRS</h4>
            <div class="container">
                <div class="section section-data-tables">
                    <!-- Page Length Options -->
                    <div class="row">
                        <form action="{{route('konversikampusmerdeka.store')}}" method="POST" id="formAddNilai">
                            @csrf
                            <input type="hidden" name="aktivitas_id" value="{{ $aktivitas->aktivitas_mahasiswa->id }}">
                            <input type="hidden" name="mahasiswa_id" value="{{ $aktivitas->Mahasiswa->id }}">
                            <div class="row">
                                <div class="input-field col m12">

                                    <select name="matakuliah_id" id="matakuliah_id" required>
                                        <option value="">Pilih</option>
                                        @foreach ($matakuliah as $item)
                                            <option value="{{ $item->id }}" data-sks="{{ $item->bobot_mata_kuliah }}">
                                                {{ $item->kode_matakuliah }} {{ $item->nama_matakuliah }}</option>
                                        @endforeach
                                    </select>

                                    <label for="first_name">Mata Kuliah</label>
                                    <?php $error = 'matakuliah_id'; ?>
                                    @error($error)
                                        <span class="red-text text-darken-2">{{ $message }}</small>
                                        @enderror

                                </div>

                                <div class="input-field col m12">
                                    <input type="text" readonly name="sks" value="">
                                    <label for="first_name">SKS</label>

                                </div>

                                <div class="input-field col m12">
                                    <input type="text" name="nilai_angka" value="">
                                    <label for="first_name">Nilai Angka</label>
                                    <?php $error = 'nilai_angka'; ?>
                                    @error($error)
                                        <span class="red-text text-darken-2">{{ $message }}</small>
                                        @enderror
                                </div>

                                <div class="input-field col m12">

                                    <select name="nilai_huruf" id="nilai_huruf">
                                        <option value="">Pilih</option>
                                        @foreach ($skalaNilai as $item)
                                            <option value="{{ $item->nilai_huruf }}-{{ $item->nilai_index }}">{{ $item->nilai_huruf }} - {{ $item->nilai_index }}</option>
                                        @endforeach
                                    </select>

                                    <label for="first_name">Index</label>
                                    <?php $error = 'nilai_huruf'; ?>
                                    @error($error)
                                    <span class="red-text text-darken-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close btn waves-effect waves-light red accent-2 ">Close</a>
            <button type="button" onclick="$('#formAddNilai').submit()" class="btn waves-effect waves-light cyan modal-trigger breadcrumbs-btn right me-3">Simpan</button>
        </div>
    </div>
@stop
@section('script')
    <script>
        (function() {
            loadDataTable();
        })();

        function loadDataTable() {
            let id = {{ $aktivitas->aktivitas_mahasiswa->id }}
            let mahasiswa_id = {{ $aktivitas->Mahasiswa->id }}
            $('#nilaiTable').DataTable({
                "scrollX": true,
                "autoWidth": true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('akademik/konversikampusmerdeka/datapesertaaktif/detail/data/') }}/" +
                        id + '/' + mahasiswa_id,
                    type: "GET",
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: 'matakuliah.nama_matakuliah',
                        name: 'matakuliah.nama_matakuliah'
                    },
                    {
                        data: 'matakuliah.bobot_mata_kuliah',
                        name: 'matakuliah.bobot_mata_kuliah'
                    },
                    {
                        data: 'nilai_angka',
                        name: 'nilai_angka'
                    },
                    {
                        data: 'nilai_huruf',
                        name: 'nilai_huruf'
                    },
                    {
                        data: 'index',
                        name: 'index'
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
        }
        $('#matakuliah_id').change(function(){
            var sks =$(this).find(':selected').data('sks')
            $('input[name="sks"]').val(sks)
            $('input[name="sks"]').focus()
        })
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
                          window.location.href = "{{ url('akademik/konversikampusmerdeka') }}/" + id + "/delete";
                      }
                  });
          }
    </script>
@endsection
