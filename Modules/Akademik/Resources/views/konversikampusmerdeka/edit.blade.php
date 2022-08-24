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
                                        <form action="{{ route($page . '.update', $aktivitas->id) }}" method="POST"
                                            enctype="multipart/form-data" class="col s12">
                                            @csrf
                                            <div class="row">
                                                @foreach ($form as $forms)
                                                    @if ($forms['type'] == 'text')
                                                        <div class="input-field col {{ $forms['col'] }}">
                                                            <input placeholder="{{ $forms['placeholder'] }}"
                                                                name="{{ $forms['name'] }}" id="{{ $forms['name'] }}"
                                                                type="text"
                                                                class="validate  @error('nama_fakultas') is-invalid @enderror"
                                                                value="{{ old($forms['name'], $forms['data']) }}">
                                                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                            <?php $error = $forms['name']; ?>
                                                            @error($error)
                                                                <span
                                                                    class="red-text text-darken-2">{{ $message }}</small>
                                                                @enderror
                                                        </div>
                                                    @elseif($forms['type'] === 'number')
                                                        <div class="input-field col {{ $forms['col'] }}">
                                                            <input placeholder="{{ $forms['placeholder'] }}"
                                                                name="{{ $forms['name'] }}" id="{{ $forms['name'] }}"
                                                                type="number" step="any"
                                                                class="validate  @error('nama_fakultas') is-invalid @enderror"
                                                                value="{{ old($forms['name'], $forms['data']) }}">
                                                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                            <?php $error = $forms['name']; ?>
                                                            @error($error)
                                                                <span
                                                                    class="red-text text-darken-2">{{ $message }}</small>
                                                                @enderror
                                                        </div>
                                                    @elseif($forms['type'] === 'date')
                                                        <div class="input-field col {{ $forms['col'] }}">
                                                            <input placeholder="{{ $forms['placeholder'] }}"
                                                                name="{{ $forms['name'] }}" id="{{ $forms['name'] }}"
                                                                type="date" step="any"
                                                                class="validate  @error('nama_fakultas') is-invalid @enderror"
                                                                value="{{ old($forms['name'], $forms['data']) }}">
                                                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                            <?php $error = $forms['name']; ?>
                                                            @error($error)
                                                                <span
                                                                    class="red-text text-darken-2">{{ $message }}</small>
                                                                @enderror
                                                        </div>
                                                    @elseif($forms['type'] === 'textarea')
                                                        <div class="input-field col {{ $forms['col'] }}">
                                                            <textarea placeholder="{{ $forms['placeholder'] }}" name="{{ $forms['name'] }}" id="{{ $forms['name'] }}"
                                                                type="text" value={{ old($forms['name']) }}>{{ old($forms['name'], $forms['data']) }}</textarea>
                                                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                            <?php $error = $forms['name']; ?>
                                                            @error($error)
                                                                <span
                                                                    class="red-text text-darken-2">{{ $message }}</small>
                                                                @enderror
                                                        </div>
                                                    @elseif($forms['type'] === 'select')
                                                        <div class="input-field col {{ $forms['col'] }}">
                                                            @php $v = $forms['value']; @endphp
                                                            <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                                                                <option value="">Pilih</option>
                                                                @foreach ($forms['relasi'] as $p)
                                                                    <option value="{{ $p->id }}"
                                                                        <?php
                                                                        if ($p->id == $forms['data']) {
                                                                            echo 'selected';
                                                                        } else {
                                                                            echo '';
                                                                        }
                                                                        
                                                                        ?>>{{ $p->$v }}</option>
                                                                @endforeach
                                                            </select>

                                                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                            <?php $error = $forms['name']; ?>
                                                            @error($error)
                                                                <span
                                                                    class="red-text text-darken-2">{{ $message }}</small>
                                                                @enderror
                                                        </div>
                                                    @elseif($forms['type'] === 'selectsemester')
                                                        <div class="input-field col {{ $forms['col'] }}">

                                                            <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                                                                <option value="">Pilih</option>
                                                                @foreach ($jenis as $row)
                                                                    <option <?php
                                                                    if ($row->id == $forms['data']) {
                                                                        echo 'selected';
                                                                    } else {
                                                                        echo '';
                                                                    }
                                                                    
                                                                    ?>
                                                                        value="{{ $row->id }}">
                                                                        {{ $row->Tahunajaran->tahun_ajaran }}-{{ $row->jenis_semester }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                            <?php $error = $forms['name']; ?>
                                                            @error($error)
                                                                <span
                                                                    class="red-text text-darken-2">{{ $message }}</small>
                                                                @enderror
                                                        </div>
                                                    @elseif($forms['type'] === 'selectsemester')
                                                        <div class="input-field col {{ $forms['col'] }}">

                                                            <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                                                                <option value="">Pilih</option>
                                                                @foreach ($jenis as $row)
                                                                    <option <?php
                                                                    if ($row->id == $forms['data']) {
                                                                        echo 'selected';
                                                                    } else {
                                                                        echo '';
                                                                    }
                                                                    
                                                                    ?>
                                                                        value="{{ $row->id }}">
                                                                        {{ $row->Tahunajaran->tahun_ajaran }}-{{ $row->jenis_semester }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                            <?php $error = $forms['name']; ?>
                                                            @error($error)
                                                                <span
                                                                    class="red-text text-darken-2">{{ $message }}</small>
                                                                @enderror
                                                        </div>
                                                    @elseif($forms['type'] === 'selectprogram')
                                                        <div class="input-field col {{ $forms['col'] }}">

                                                            <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                                                                <option value="">Pilih</option>
                                                                @foreach ($programstudy as $row)
                                                                    <option <?php
                                                                    if ($row->id == $forms['data']) {
                                                                        echo 'selected';
                                                                    } else {
                                                                        echo '';
                                                                    }
                                                                    
                                                                    ?>
                                                                        value="{{ $row->id }}">
                                                                        {{ $row->jurusan->nama_jurusan }}</option>
                                                                @endforeach
                                                            </select>

                                                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                            <?php $error = $forms['name']; ?>
                                                            @error($error)
                                                                <span
                                                                    class="red-text text-darken-2">{{ $message }}</small>
                                                                @enderror
                                                        </div>
                                                    @elseif($forms['type'] === 'selectanggota')
                                                        <div class="input-field col {{ $forms['col'] }}">

                                                            <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                                                                <option value="">Pilih</option>
                                                                <option value="personal"
                                                                    @if ($forms['data'] == 'personal') selected @endif>
                                                                    Personal</option>
                                                                <option value="kelompok"
                                                                    @if ($forms['data'] == 'kelompok') selected @endif>
                                                                    Kelompok</option>


                                                            </select>

                                                            <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                            <?php $error = $forms['name']; ?>
                                                            @error($error)
                                                                <span
                                                                    class="red-text text-darken-2">{{ $message }}</small>
                                                                @enderror
                                                        </div>
                                                    @endif
                                                @endforeach


                                                @if ((request('act') ?? '') != 'detail')
                                                    <div class="input-field col s12">
                                                        <button type="submit"
                                                            class="waves-effect waves-light btn-small"><i
                                                                class="material-icons right">send</i>save</button>
                                                        <a href="{{ route('datapesertaaktif.index') }}"
                                                            class="waves-effect purple darken-1 btn-small"><i
                                                                class="material-icons left">keyboard_arrow_left</i>back</a>
                                                    </div>
                                                @endif
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
                                    <h4 class="card-title">Peserta Aktivitas</h4>
                                    <div class="row">
                                        <div class="col s12">
                                            <table id="page-length-option" class="display">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>NIM</th>
                                                        <th>Nama Mahasiwa</th>
                                                        <th>Peran</th>
                                                        <th>#</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>NIM</th>
                                                        <th>Nama Mahasiwa</th>
                                                        <th>Peran</th>
                                                        <th>#</th>
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



@stop
@section('script')
    <script>
        (function() {
            loadDataTable();
        })();

        function loadDataTable() {
            let iddatapesertaaktif = {{ $aktivitas->id }}
            $(document).ready(function() {
                $('#page-length-option').DataTable({
                    "scrollX": true,
                    "autoWidth": true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('akademik/datapesertaaktif/datapesertaaktif') }}/" +
                            iddatapesertaaktif,
                        type: "GET",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: 'mahasiswa.nim',
                            name: 'mahasiswa.nim'
                        },
                        {
                            data: 'mahasiswa.nama',
                            name: 'mahasiswa.nama'
                        },



                        {
                            data: 'peranpeserta',
                            name: 'peranpeserta'
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

                //   pembimbing
                $('.pembimbing').DataTable({
                    "scrollX": true,
                    "autoWidth": true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('akademik/datapesertaaktif/datapembimbing') }}/" +
                            iddatapesertaaktif,
                        type: "GET",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: 'dosen.nidn',
                            name: 'dosen.nidn'
                        },
                        {
                            data: 'dosen.nama_dosen',
                            name: 'dosen.nama_dosen'
                        },

                        {
                            data: 'order',
                            name: 'order'
                        },

                        {
                            data: 'kategorikegiatan.nama_kategori_kegiatan',
                            name: 'kategorikegiatan.nama_kategori_kegiatan'
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

                //   penguji
                $('.penguji').DataTable({
                    "scrollX": true,
                    "autoWidth": true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('akademik/datapesertaaktif/datapenguji') }}/" +
                            iddatapesertaaktif,
                        type: "GET",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: 'dosen.nidn',
                            name: 'dosen.nidn'
                        },
                        {
                            data: 'dosen.nama_dosen',
                            name: 'dosen.nama_dosen'
                        },

                        {
                            data: 'order',
                            name: 'order'
                        },

                        {
                            data: 'kategorikegiatan.nama_kategori_kegiatan',
                            name: 'kategorikegiatan.nama_kategori_kegiatan'
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

        function deleteConfirmPeserta(id) {
            swal({
                    title: "Kamu Yakin ?",
                    text: "akan menghapus data ini !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((dt) => {
                    if (dt) {
                        window.location.href = "{{ url('akademik/datapesertaaktif') }}/" + id + "/deletepeserta";
                    }
                });
        }

        function deleteConfirmDospem(id) {
            swal({
                    title: "Kamu Yakin ?",
                    text: "akan menghapus data ini !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((dt) => {
                    if (dt) {
                        window.location.href = "{{ url('akademik/datapesertaaktif') }}/" + id + "/deletepembimbing";
                    }
                });
        }

        function deleteConfirmDospen(id) {
            swal({
                    title: "Kamu Yakin ?",
                    text: "akan menghapus data ini !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((dt) => {
                    if (dt) {
                        window.location.href = "{{ url('akademik/datapesertaaktif') }}/" + id + "/deletepenguji";
                    }
                });
        }
    </script>

@endsection
