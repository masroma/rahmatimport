@extends('layouts.v1')
@section('title') {{ $page }} @endsection
@section('content')
<style>
    [type='radio']:not(:checked), [type='radio']:checked{
        opacity:1 !important;
        pointer-events: auto !important;
    }
    [type='checkbox']:not(:checked), [type='checkbox']:checked{
        opacity:1 !important; 
        pointer-events: auto !important;
    }
</style>
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0"><span>{{ $title }}</span></h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $title }}
                            </li>
                        </ol>
                    </div>
                    <div class="col s2 m6 l6">
                        {{-- <a class="btn dropdown-settings waves-effect waves-light breadcrumbs-btn right" href="{{route('user.create')}}" id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a> --}}
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
                                <div class="card-content mx-5">
                                    {{-- <h4 class="card-title">Page Length Options</h4> --}}
                                    <div class="row">
                                        <form action="#" method="GET" enctype="multipart/form-data" class="col s12">
                                            <div class="row">
                                                <div class="input-field col m12">
                                                    <select name="mahasiswa_id" id="mahasiswa_id" required>
                                                        <option value="">Pilih</option>
                                                        @foreach ($mahasiswa as $p)
                                                            <option value="{{ $p->id }}">{{ $p->nim }} -
                                                                {{ $p->nama }}</option>
                                                        @endforeach
                                                    </select>

                                                    <label for="first_name">Mahasiswa</label>
                                                    <?php $error = 'mahasiswa_id'; ?>
                                                    @error($error)
                                                        <span class="red-text text-darken-2">{{ $message }}</small>
                                                        @enderror
                                                </div>
                                                <div class="input-field center col s8 offset-s2 m8 offset-m2">
                                                    <button type="button" onclick="getTranskripNilai()"
                                                        class="waves-effect waves-light btn-small">Tampilkan Data</button>
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
        <div class="col s12" id="transkrip">
            <div class="container">
                <div class="section section-data-tables">
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    {{-- <h4 class="card-title">Page Length Options</h4> --}}
                                    <div class="row">
                                        <div class="input-field col s6  mt-2 mb-2">
                                            <input readonly type="text" class="fill " name="nim">
                                            <label for="first_name">NIM</label>
                                        </div>
                                        <div class="input-field col s6  mt-2 mb-2">
                                            <input readonly type="text" class="fill " name="nama">
                                            <label for="first_name">Nama</label>
                                        </div>
                                        <div class="input-field col s6  mt-2 mb-2">
                                            <input readonly type="text" class="fill " name="program_study">
                                            <label for="first_name">Program Studi</label>
                                        </div>
                                        <div class="input-field col s6  mt-2 mb-2">
                                            <input readonly type="text" class="fill " name="status_keluar">
                                            <label for="first_name">Status Keluar</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <form action="{{route('cektranskripmahasiswa.store')}}" method="POST" name="detail">
                                                @csrf
                                                <button class="btn waves-effect waves-light green breadcrumbs-btn right me-3" type="button"  id="tombol-tambah" style="margin-top:-3px; margin-bottom:10px;margin-left:10px;" onclick="checkall(this)" >Unheck All</button>
                                                @if($canCreate)
                                                <button class="btn waves-effect waves-light breadcrumbs-btn right me-3" type="submit"  id="tombol-tambah" style="margin-top:-3px; margin-bottom:10px" ><i class="material-icons left">save</i>Simpan</button>
                                                @endif
                                                <table id="page-length-option" class="display">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2">No</th>
                                                            <th rowspan="2">Kode Mk</th>
                                                            <th rowspan="2">Nama MK</th>
                                                            <th rowspan="2">Periode</th>
                                                            <th rowspan="2">Bobot MK (sks)</th>
                                                            <th colspan="3">Nilai</th>
                                                            <th rowspan="2">sks * indeks </th>
                                                            <th rowspan="2">Semester Ke</th>
                                                            <th rowspan="2">
                                                                {{-- <input name="all" id="all" type="checkbox"> --}}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Angka</th>
                                                            <th>Huruf</th>
                                                            <th>Indeks</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th rowspan="2">No</th>
                                                            <th rowspan="2">Kode Mk</th>
                                                            <th rowspan="2">Nama MK</th>
                                                            <th rowspan="2">Periode</th>
                                                            <th rowspan="2">Bobot MK (sks)</th>
                                                            <th>Angka</th>
                                                            <th>Huruf</th>
                                                            <th>Indeks</th>
                                                            <th rowspan="2">sks * indeks </th>
                                                            <th rowspan="2">Semester Ke</th>
                                                            <th rowspan="2">
                                                                #
                                                            </th>
                                                        </tr>
                                                        <tr>
    
                                                            <th colspan="3">Nilai</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('script')
    <script>
        var table;
        // (function() {
        //     loadDataTable();
        // })();
        $(document).ready(function() {
            $('#transkrip').hide()
        })

        function getTranskripNilai() {
            $('#transkrip').show()
            // table.ajax.reload()
            $.get("{{ url('/akademik/cektranskripmahasiswa/mahasiswa/') }}" + "/" + ($('select[name="mahasiswa_id"]').find(':selected').val()==''?0:$('select[name="mahasiswa_id"]').find(':selected').val()),function(d){
                $('input[name="nim"]').val(d.nim)
                $('input[name="nama"]').val(d.nama)
                $('input[name="program_study"]').val(d.riwayatpendidikan.programstudy.jurusan.nama_jurusan??'')
                $('input[name="status_keluar"]').val(d.aktivitas_kuliah_mahaswa[0].status.status_mahasiswa??'')
                $('.fill').focus()
                    if(table) table.destroy()
                    loadDataTable()
                
            })
        }

        function loadDataTable() {
            table = $('#page-length-option').DataTable({
                "scrollX": true,
                "autoWidth": true,
                processing: true,
                serverSide: true,
                retrieve: true,
                ajax: {
                    url: "{{ url('/akademik/cektranskripmahasiswa/data/') }}" + "/" + ($('select[name="mahasiswa_id"]').find(':selected').val()==''?0:$('select[name="mahasiswa_id"]').find(':selected').val()),
                    type: "GET",
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: 'kode_matakuliah',
                        name: 'kode_matakuliah'
                    },

                    {
                        data: 'nama_matakuliah',
                        name: 'nama_matakuliah'
                    },

                    {
                        data: 'semester',
                        name: 'semester'
                    },
                    {
                        data: 'bobot_mata_kuliah',
                        name: 'bobot_mata_kuliah'
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
                        data: 'nilai_index',
                        name: 'nilai_index'
                    },
                    {
                        data: 'nindeks',
                        name: 'nindeks'
                    },
                    {
                        data: 'semester_ke',
                        name: 'semester_ke'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                order: [
                    [0, 'asc']
                ]
            });
        }
        function checkall(e)
        {
            
            if($(e).text()=="Check All")
            {
                $('.chk').prop('checked',true)
                $(e).text("Unheck All")
            } else {
                $('.chk').prop('checked',false)
                $(e).text("Check All")
            }
        }
    </script>

@endsection
