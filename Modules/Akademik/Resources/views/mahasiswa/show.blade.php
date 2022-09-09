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
                        <h5 class="breadcrumbs-title mt-0 mb-0"><span>Detail data {{ $page }}</span></h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route($page . '.index') }}">{{ $page }}</a>
                            </li>
                            <li class="breadcrumb-item active">detail
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
                    <!-- DataTables example -->



                    <!-- DataTables Row grouping -->


                    <!-- Page Length Options -->
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    {{-- <h4 class="card-title">Page Length Options</h4> --}}
                                    <div class="row">
                                        <div class="col s12 m6 l10">
                                            <h4 class="card-title">{{ $mahasiswa->nama }} -
                                                {{ $mahasiswa->Riwayatpendidikan->Programstudy->jurusan->nama_jurusan }}
                                            </h4>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                        <div class="row" id="main-view">
                                            <div class="col s12">
                                                <ul class="tabs tab-demo z-depth-1">
                                                    <li class="tab col"><a class="active" href="#test1">Data Pribadi</a>
                                                    </li>
                                                    <li class="tab col "><a href="#test2">Alamat</a></li>
                                                    <li class="tab col"><a href="#test3">Orang Tua</a></li>
                                                    <li class="tab col "><a href="#test4">Wali</a></li>
                                                    <li class="tab col"><a href="#test5">Kebutuhan Khusus</a></li>
                                                    <li class="tab col"><a href="#akm">Aktivitas Perkuliahan</a></li>
                                                    <li class="tab col"><a href="#transkrip">Transkrip</a></li>
                                                    @if ($mahasiswa->Riwayatpendidikan->jenis_pendaftaran == 4)
                                                        <li class="tab col"><a href="#nilaiTransfer">Nilai Transfer</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="col s12">
                                                <div id="test1" class="col s6">
                                                    <table>

                                                        <tr>
                                                            <td>Nama</td>
                                                            <td>{{ $mahasiswa->nama }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tempat Lahir</td>
                                                            <td>{{ $mahasiswa->tempat_lahir }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Lahir</td>
                                                            <td>{{ \Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->isoFormat('dddd, D MMMM Y') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jenis Kelamin</td>
                                                            <td>{{ $mahasiswa->jenis_kelamin }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama Ibu</td>
                                                            <td>{{ $mahasiswa->ibu_kandung }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Agama</td>
                                                            <td>{{ $mahasiswa->agam }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div id="test2" class="col s6">
                                                    <table>

                                                        <tr>
                                                            <td>Kewarganegaraan</td>
                                                            <td>{{ $mahasiswa->Detail->Kewarganegaraan->country_name }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama Jalan</td>
                                                            <td>{{ $mahasiswa->Detail->jalan }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Provinsi</td>
                                                            <td>
                                                                @if ($mahasiswa->Detail->Provinsi)
                                                                    {{ $mahasiswa->Detail->Provinsi->name }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kota</td>
                                                            <td>
                                                                @if ($mahasiswa->Detail->Kota)
                                                                    {{ $mahasiswa->Detail->Kota->name }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kecamatan</td>
                                                            <td>
                                                                @if ($mahasiswa->Detail->Kecamatan)
                                                                    {{ $mahasiswa->Detail->Kecamatan->name }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kelurahan</td>
                                                            <td>
                                                                @if ($mahasiswa->Detail->Kecamatan)
                                                                    {{ $mahasiswa->Detail->Kelurahan->name }}
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>RT</td>
                                                            <td>{{ $mahasiswa->Detail->rt }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>RW</td>
                                                            <td>{{ $mahasiswa->Detail->rw }}</td>
                                                        </tr>


                                                    </table>
                                                </div>
                                                <div id="test3" class="col s12">
                                                    <div class="col s6">
                                                        <table>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <p>Data Ayah</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Nama </td>
                                                                <td>{{ $mahasiswa->OrangTua->nama_ayah }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>NIK </td>
                                                                <td>{{ $mahasiswa->OrangTua->nik_ayah }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tanggal Lahir </td>
                                                                <td>{{ \Carbon\Carbon::parse($mahasiswa->OrangTua->tanggal_lahir_ayah)->isoFormat('dddd, D MMMM Y') }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pendidikan</td>
                                                                <td>{{ $mahasiswa->OrangTua->pendidikan_ayah }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pekerjaan</td>
                                                                <td>{{ $mahasiswa->OrangTua->pekerjaan_ayah }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Penghasilan</td>
                                                                <td>{{ $mahasiswa->OrangTua->penghasilan_ayah }} </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col s6">
                                                        <table>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <p>Data Ibu</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Nama </td>
                                                                <td>{{ $mahasiswa->OrangTua->nama_ibu }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>NIK </td>
                                                                <td>{{ $mahasiswa->OrangTua->nik_ibu }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tanggal Lahir </td>
                                                                <td>{{ \Carbon\Carbon::parse($mahasiswa->OrangTua->tanggal_lahir_ibu)->isoFormat('dddd, D MMMM Y') }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pendidikan</td>
                                                                <td>{{ $mahasiswa->OrangTua->pendidikan_ibu }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pekerjaan</td>
                                                                <td>{{ $mahasiswa->OrangTua->pekerjaan_ibu }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Penghasilan</td>
                                                                <td>{{ $mahasiswa->OrangTua->penghasilan_ibu }} </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div id="test4" class="col s6">
                                                    <table>

                                                        <tr>
                                                            <td>Nama </td>
                                                            <td>{{ $mahasiswa->Wali->nama_wali }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Lahir </td>
                                                            <td>{{ \Carbon\Carbon::parse($mahasiswa->Wali->tanggal_lahir_wali)->isoFormat('dddd, D MMMM Y') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pendidikan</td>
                                                            <td>{{ $mahasiswa->Wali->pendidikan_wali }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pekerjaan</td>
                                                            <td>{{ $mahasiswa->Wali->pekerjaan_wali }} </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Penghasilan</td>
                                                            <td>{{ $mahasiswa->Wali->penghasilan_wali }} </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div id="test5" class="col s6">
                                                    <table>

                                                        <tr>
                                                            <td>Kebutuhan Khusus </td>
                                                            <td>
                                                                @if ($mahasiswa->KebutuhanKhusus->kebutuhan_khusus == 'y')
                                                                    Iya
                                                                @else
                                                                    Tidak
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div id="akm" class="col s12" style="padding:1rem">
                                                    <div class="row">
                                                        <div class="input-field col s6  mt-2 mb-2">
                                                            <input readonly type="text" class="validate "
                                                                value="{{ $mahasiswa->nim }}">
                                                            <label for="first_name">NIM</label>
                                                        </div>
                                                        <div class="input-field col s6  mt-2 mb-2">
                                                            <input readonly type="text" class="validate "
                                                                value="{{ $mahasiswa->nama }}">
                                                            <label for="first_name">Nama</label>
                                                        </div>
                                                        <div class="input-field col s6  mt-2 mb-2">
                                                            <input readonly type="text" class="validate "
                                                                value="{{ $mahasiswa->Riwayatpendidikan->Programstudy->jurusan->nama_jurusan }}">
                                                            <label for="first_name">Program Studi</label>
                                                        </div>
                                                        <div class="input-field col s6  mt-2 mb-2">
                                                            <input readonly type="text" class="validate "
                                                                value="{{ date('Y', strtotime($mahasiswa->Riwayatpendidikan->tanggal_masuk)) }}">
                                                            <label for="first_name">Angkatan</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <strong class="col s6 left">Aktivitas Kuliah Mahasiswa</strong>
                                                        <table id="akmTable" class="centered" style="width:100% !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2">No</th>
                                                                    <th rowspan="2">Semester</th>
                                                                    <th rowspan="2">Status</th>
                                                                    <th rowspan="2">IPS</th>
                                                                    <th rowspan="2">IPK</th>
                                                                    <th colspan="2">Jumlah SKS</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Semester</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th rowspan="2">No</th>
                                                                    <th rowspan="2">Semester</th>
                                                                    <th rowspan="2">Status</th>
                                                                    <th rowspan="2">IPS</th>
                                                                    <th rowspan="2">IPK</th>
                                                                    <th>Semester</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="2">Jumlah SKS</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div id="transkrip" class="col s12" style="padding:1rem">
                                                    <div class="row">
                                                        <div class="input-field col s6  mt-2 mb-2">
                                                            <input readonly type="text" class="validate "
                                                                value="{{ $mahasiswa->nim }}">
                                                            <label for="first_name">NIM</label>
                                                        </div>
                                                        <div class="input-field col s6  mt-2 mb-2">
                                                            <input readonly type="text" class="validate "
                                                                value="{{ $mahasiswa->nama }}">
                                                            <label for="first_name">Nama</label>
                                                        </div>
                                                        <div class="input-field col s6  mt-2 mb-2">
                                                            <input readonly type="text" class="validate "
                                                                value="{{ $mahasiswa->Riwayatpendidikan->Programstudy->jurusan->nama_jurusan }}">
                                                            <label for="first_name">Program Studi</label>
                                                        </div>
                                                        <div class="input-field col s6  mt-2 mb-2">
                                                            <input readonly type="text" class="validate "
                                                                value="{{ date('Y', strtotime($mahasiswa->Riwayatpendidikan->tanggal_masuk)) }}">
                                                            <label for="first_name">Angkatan</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <strong class="col s6 left">Aktivitas Kuliah Mahasiswa</strong>
                                                        <table id="transkripTable" class="centered" style="width:100% !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2">No</th>
                                                                    <th rowspan="2">Kode MK</th>
                                                                    <th rowspan="2">Nama MK</th>
                                                                    <th rowspan="2">Bobot MK</th>
                                                                    <th colspan="3">Nilai</th>
                                                                    <th rowspan="2">sks * N.indeks</th>
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
                                                                    <th rowspan="2">Kode MK</th>
                                                                    <th rowspan="2">Nama MK</th>
                                                                    <th rowspan="2">Bobot MK</th>
                                                                    <th>Angka</th>
                                                                    <th>Huruf</th>
                                                                    <th>Indeks</th>
                                                                    <th rowspan="2">sks * N.indeks</th>
                                                                </tr>
                                                                <tr>

                                                                    <th colspan="3">Nilai</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                @if ($mahasiswa->Riwayatpendidikan->jenis_pendaftaran == 4)
                                                    <div id="nilaiTransfer" class="col s12" style="padding:1rem">
                                                        <div class="row">
                                                            <div class="input-field col s6  mt-2 mb-2">
                                                                <input readonly type="text" class="validate "
                                                                    value="{{ $mahasiswa->nim }}">
                                                                <label for="first_name">NIM</label>
                                                            </div>
                                                            <div class="input-field col s6  mt-2 mb-2">
                                                                <input readonly type="text" class="validate "
                                                                    value="{{ $mahasiswa->nama }}">
                                                                <label for="first_name">Nama</label>
                                                            </div>
                                                            <div class="input-field col s6  mt-2 mb-2">
                                                                <input readonly type="text" class="validate "
                                                                    value="{{ $mahasiswa->Riwayatpendidikan->Programstudy->jurusan->nama_jurusan }}">
                                                                <label for="first_name">Program Studi</label>
                                                            </div>
                                                            <div class="input-field col s6  mt-2 mb-2">
                                                                <input readonly type="text" class="validate "
                                                                    value="{{ date('Y', strtotime($mahasiswa->Riwayatpendidikan->tanggal_masuk)) }}">
                                                                <label for="first_name">Angkatan</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <strong class="col s6 left">Nilai Transfer</strong>
                                                            <a href="{{route('nilaitransfer.print',[$mahasiswa->id ])}}"
                                                                class="btn waves-effect waves-light breadcrumbs-btn green col s2 right" target="_blank"><i
                                                                    class="material-icons left">print</i>Cetak Nilai
                                                                Transkrip </a>
                                                            <a href="#addNilai"
                                                                class="btn waves-effect waves-light breadcrumbs-btn col s2 right modal-trigger"
                                                                style="margin-right: 1rem;"><i
                                                                    class="material-icons left">add_circle_outline</i>Tambah
                                                            </a>
                                                            <table id="nilaiTransferTable" class="centered"
                                                                style="width:100% !important;" style="width:100% !important;">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="4">Nilai PT Asal</th>
                                                                        <th colspan="4">Nilai PT Baru (Diakui)</th>
                                                                        <th rowspan="2">#</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Kode MK</th>
                                                                        <th>Nama MK</th>
                                                                        <th>Bobot (sks)</th>
                                                                        <th>Nilai Huruf</th>
                                                                        <th>Kode MK</th>
                                                                        <th>Nama MK</th>
                                                                        <th>Bobot (sks)</th>
                                                                        <th>Nilai Huruf</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>Kode MK</th>
                                                                        <th>Nama MK</th>
                                                                        <th>Bobot (sks)</th>
                                                                        <th>Nilai Huruf</th>
                                                                        <th>Kode MK</th>
                                                                        <th>Nama MK</th>
                                                                        <th>Bobot (sks)</th>
                                                                        <th>Nilai Huruf</th>
                                                                        <th rowspan="2">#</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th colspan="4">Nilai PT Asal</th>
                                                                        <th colspan="4">Nilai PT Baru (Diakui)</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div><!-- START RIGHT SIDEBAR NAV -->

        </div>
    </div>

    <div id="addNilai" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Nilai Tansfer</h4>
            <div class="container">
                <div class="section section-data-tables">
                    <!-- Page Length Options -->
                    <div class="row">
                        <form action="{{ route('nilaitransfer.store') }}" method="POST" id="formAddNilai">
                            @csrf
                            <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->id }}">
                            <div class="row">
                                <div class="input-field col s6">

                                    <input type="text" name="perguruantinggi_asal" value="" required>

                                    <label for="first_name">Perguruan Tinggi</label>
                                    <?php $error = 'perguruantinggi_asal'; ?>
                                    @error($error)
                                        <span class="red-text text-darken-2">{{ $message }}</small>
                                        @enderror

                                </div>

                                <div class="input-field col s6">
                                    <input type="text" name="kode_mk_asal" value="" required>
                                    <label for="first_name">Kode MK Asal</label>

                                </div>

                                <div class="input-field col s6">
                                    <input type="text" name="matakuliah_asal" value="" required>
                                    <label for="first_name">Mata Kuliah Asal</label>
                                    <?php $error = 'matakuliah_asal'; ?>
                                    @error($error)
                                        <span class="red-text text-darken-2">{{ $message }}</small>
                                        @enderror
                                </div>

                                <div class="input-field col s6">
                                    <input type="number" name="sks_asal" value="" required>
                                    <label for="first_name">SKS Asal</label>
                                    <?php $error = 'sks_asal'; ?>
                                    @error($error)
                                        <span class="red-text text-darken-2">{{ $message }}</small>
                                        @enderror
                                </div>

                                <div class="input-field col s6">
                                    <input type="text" name="nilai_huruf_asal" value="" required>
                                    <label for="first_name">Nilai Huruf Asal</label>
                                    <?php $error = 'nilai_huruf_asal'; ?>
                                    @error($error)
                                        <span class="red-text text-darken-2">{{ $message }}</small>
                                        @enderror
                                </div>

                                <div class="input-field col s6">

                                    <select name="matakuliah_diakui" id="matakuliah_diakui">
                                        <option value="">Pilih</option>
                                        @foreach ($mata_kuliah as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->kode_matakuliah }} - {{ $item->nama_matakuliah }}</option>
                                        @endforeach
                                    </select>

                                    <label for="first_name">Mata Kuliah Diakui</label>
                                    <?php $error = 'matakuliah_diakui'; ?>
                                    @error($error)
                                        <span class="red-text text-darken-2">{{ $message }}</small>
                                        @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input type="text" name="nilai_index_diakui" value="" required>
                                    <label for="first_name">Nilai Indekx Diakui</label>
                                    <?php $error = 'nilai_index_diakui'; ?>
                                    @error($error)
                                        <span class="red-text text-darken-2">{{ $message }}</small>
                                        @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input type="text" name="nilai_huruf_diakui" value="" required>
                                    <label for="first_name">Nilai Huruf Diakui</label>
                                    <?php $error = 'nilai_huruf_diakui'; ?>
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
            <button type="button" onclick="$('#formAddNilai').submit()"
                class="btn waves-effect waves-light cyan modal-trigger breadcrumbs-btn right me-3">Simpan</button>
        </div>
    </div>

@stop
@section('script')
    <script>
        (function() {
            loadDataTable();
        })();

        function loadDataTable() {
            $('#akmTable').DataTable({
                "scrollX": true,
                "autoWidth": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('/akademik/mahasiswa') . '/' . $mahasiswa->id . '/getakm' }}",
                    type: "GET",
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: 'semester',
                        name: 'semester'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'ips',
                        name: 'ips'
                    },

                    {
                        data: 'ipk',
                        name: 'ipk'
                    },
                    {
                        data: 'jumlah_sks_semester',
                        name: 'jumlah_sks_semester'
                    },

                    {
                        data: 'sks_total',
                        name: 'sks_total'
                    },

                ],
                order: [
                    [0, 'asc']
                ]
            });
            $('#transkripTable').DataTable({
                "scrollX": true,
                "autoWidth": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('/akademik/mahasiswa') . '/' . $mahasiswa->id . '/gettranskrip' }}",
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
                        data: 'nindex',
                        name: 'nindex'
                    },



                ],
                order: [
                    [0, 'asc']
                ]
            });
            $('#nilaiTransferTable').DataTable({
                "scrollX": true,
                "autoWidth": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('/akademik/mahasiswa') . '/' . $mahasiswa->id . '/gettransfer' }}",
                    type: "GET",
                },
                columns: [{
                        data: 'kode_mk_asal',
                        name: 'kode_mk_asal'
                    },
                    {
                        data: 'matakuliah_asal',
                        name: 'matakuliah_asal'
                    },

                    {
                        data: 'sks_asal',
                        name: 'sks_asal'
                    },

                    {
                        data: 'nilai_huruf_asal',
                        name: 'nilai_huruf_asal'
                    },
                    {
                        data: 'kode_mk_diakui',
                        name: 'kode_mk_diakui'
                    },
                    {
                        data: 'matakuliah_diakui',
                        name: 'matakuliah_diakui'
                    },

                    {
                        data: 'sks_diakui',
                        name: 'sks_diakui'
                    },

                    {
                        data: 'nilai_huruf_diakui',
                        name: 'nilai_huruf_diakui'
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
                        window.location.href = "{{ url('akademik/mahasiswa/nilaitransfer/delete/') }}/" + id;
                    }
                });
        }
    </script>

@endsection
