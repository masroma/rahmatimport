@extends('layouts.v1')
@section('title') {{ $page }} @endsection
@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0"><span>Data {{ $title }}</span></h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                            </li>
                            {{-- <li class="breadcrumb-item"><a href="#">Table</a>
              </li> --}}
                            <li class="breadcrumb-item active">{{ $title }}
                            </li>
                        </ol>
                    </div>
                    <div class="col s2 m6 l6">
                        {{-- <a class="btn waves-effect waves-light green  breadcrumbs-btn right me-3" style="margin-top:-3px; margin-left:10px" href="{{route($page.'.trash')}}"  id="tombol-tambah" ><i class="material-icons left">delete</i>Trash</a> --}}
                        {{-- @if ($canCreate)
              <a class="btn waves-effect waves-light breadcrumbs-btn right" href="{{route($page.'.create')}}"  id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a>

              @endif --}}

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

                    <div id="modal1" class="modal modal-fixed-footer">
                        <div class="modal-content">
                            <h4>KRS </h4>
                            <table id="page-length-options" class="display krs">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Matakuliah</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <a href="" class="modal-action modal-close  waves-effect waves-green btn-flat ">x
                                tutup</a>
                        </div>
                    </div>

                    <!-- DataTables Row grouping -->


                    <!-- Page Length Options -->
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    {{-- <h4 class="card-title">Page Length Options</h4> --}}
                                    <div class="row">
                                        <div class="col s12">
                                            <table id="page-length-option" border="1">
                                                <thead>
                                                    <tr>
                                                        <th class="center-align" rowspan="2">No</th>
                                                        <th class="center-align" rowspan="2">NIM</th>
                                                        <th class="center-align" rowspan="2">Nama</th>
                                                        <th class="center-align" colspan="6">Perhitungan Berdasarkan KRS & Nilai Mahasiswa
                                                        </th>
                                                        <th class="center-align" colspan="6">Data Aktivitas Kuliah Mahasiswa</th>
                                                        <th class="center-align" rowspan="2">#</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-align">Status Mahasiswa</th>
                                                        <th class="center-align">Jumlah SKS Semester</th>
                                                        <th class="center-align">Jumlah SKS Total</th>
                                                        <th class="center-align">IPK</th>
                                                        <th class="center-align">IPS</th>
                                                        <th class="center-align">Biaya Semester</th>

                                                        <th class="center-align">Status Mahasiswa</th>
                                                        <th class="center-align">Jumlah SKS Semester</th>
                                                        <th class="center-align">Jumlah SKS Total</th>
                                                        <th class="center-align">IPK</th>
                                                        <th class="center-align">IPS</th>
                                                        <th class="center-align">Biaya Semester</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                      <th class="center-align" rowspan="2">No</th>
                                                        <th class="center-align" rowspan="2">NIM</th>
                                                        <th class="center-align" rowspan="2">Nama</th>
                                                        <th class="center-align">Status Mahasiswa</th>
                                                        <th class="center-align">Jumlah SKS Semester</th>
                                                        <th class="center-align">Jumlah SKS Total</th>
                                                        <th class="center-align">IPK</th>
                                                        <th class="center-align">IPS</th>
                                                        <th class="center-align">Biaya Semester</th>

                                                        <th class="center-align">Status Mahasiswa</th>
                                                        <th class="center-align">Jumlah SKS Semester</th>
                                                        <th class="center-align">Jumlah SKS Total</th>
                                                        <th class="center-align">IPK</th>
                                                        <th class="center-align">IPS</th>
                                                        <th class="center-align">Biaya Semester</th>
                                                        <th class="center-align" rowspan="2">#</th>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <th class="center-align" colspan="6">Perhitungan Berdasarkan KRS & Nilai Mahasiswa
                                                        </th>
                                                        <th class="center-align" colspan="6">Data Aktivitas Kuliah Mahasiswa</th>
                                                        
                                                    </tr>

                                                </tfoot>
                                            </table>
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
        // ini vendor data
        (function() {
            loadDataTable();
        })();

        function loadDataTable() {
            $(document).ready(function() {
                $('#page-length-option').DataTable({
                    "scrollX": true,
                    "autoWidth": true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('hitungaktivitaskuliahmahasiswa.data') }}",
                        type: "GET",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: 'nim',
                            name: 'nim'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'krs_nilai.status_id',
                            name: 'krs_nilai.status_id'
                        },
                        {
                            data: 'krs_nilai.jumlah_sks_semester',
                            name: 'krs_nilai.jumlah_sks_semester'
                        },
                        {
                            data: 'krs_nilai.sks_total',
                            name: 'krs_nilai.sks_total'
                        },
                        {
                            data: 'krs_nilai.ipk',
                            name: 'krs_nilai.ipk'
                        },
                        {
                            data: 'krs_nilai.ips',
                            name: 'krs_nilai.ips'
                        },
                        {
                            data: 'krs_nilai.biaya_kuliah',
                            name: 'krs_nilai.biaya_kuliah'
                        },
                        {
                            data: 'akm.status_id',
                            name: 'akm.status_id'
                        },
                        {
                            data: 'akm.jumlah_sks_semester',
                            name: 'akm.jumlah_sks_semester'
                        },
                        {
                            data: 'akm.sks_total',
                            name: 'akm.sks_total'
                        },
                        {
                            data: 'akm.ipk',
                            name: 'akm.ipk'
                        },
                        {
                            data: 'akm.ips',
                            name: 'akm.ips'
                        },
                        {
                            data: 'akm.biaya_kuliah',
                            name: 'akm.biaya_kuliah'
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

        function detailKrs(id) {
            console.log("data", id);
            $(document).ready(function() {
                $('#page-length-options').DataTable({
                    "scrollX": true,
                    "autoWidth": true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('akademik/hitungaktivitaskuliahmahasiswa/datakrs') }}/" + id,
                        type: "GET",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: 'matakuliah.kode_matakuliah',
                            name: 'matakuliah.nama_matakuliah'
                        },

                        {
                            data: 'matakuliah.nama_matakuliah',
                            name: 'matakuliah.nama_matakuliah'
                        },

                        {
                            data: 'matakuliah.bobot_mata_kuliah',
                            name: 'matakuliah.bobot_mata_kuliah'
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
                        window.location.href = "{{ url('akademik/dosen') }}/" + id + "/delete";
                    }
                });
        }
    </script>

@endsection
