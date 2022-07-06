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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Export data {{$page}}</span></h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Export data {{$page}}
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
                                    <form action="{{ route('krsmahasiswa.store') }}" method="POST" enctype="multipart/form-data" class="col s12">
                                        @csrf
                                        <div class="row">

                                            @foreach ($form as $forms)

                                            @if($forms['type'] == "title")
                                            <div class="input-field col {{ $forms['col'] }}">
                                                <h5 class="blue-text center">{{ $forms['placeholder'] }}</h5>
                                            </div>
                                            @elseif($forms['type'] == "text")
                                            <div class="input-field col {{ $forms['col'] }}">
                                                <input placeholder="{{ $forms['placeholder'] }}" name="{{ $forms['name'] }}" id="{{ $forms['name'] }}" type="text" class="validate  @error('nama_fakultas') is-invalid @enderror" value="{{ old($forms['name']) }}">
                                                <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                <?php $error = $forms['name']; ?>
                                                @error($error)
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                    @enderror
                                            </div>
                                            @elseif($forms['type'] === "number")
                                            <div class="input-field col {{ $forms['col'] }}">
                                                <input placeholder="{{ $forms['placeholder'] }}" name="{{ $forms['name'] }}" id="{{ $forms['name'] }}" type="number" step="any" class="validate  @error('nama_fakultas') is-invalid @enderror" value="{{ old($forms['name']) }}">
                                                <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                <?php $error = $forms['name']; ?>
                                                @error($error)
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                    @enderror
                                            </div>
                                            @elseif($forms['type'] === "selectsemester")
                                            <div class="input-field col {{ $forms['col'] }}">

                                                <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}" required>
                                                    <option value="">Pilih</option>
                                                    @foreach($jenis as $row)
                                                    <option value="{{$row->id}}">{{ $row->Tahunajaran->tahun_ajaran }}-{{$row->jenis_semester}}</option>
                                                    @endforeach
                                                </select>

                                                <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                <?php $error = $forms['name']; ?>
                                                @error($error)
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                    @enderror
                                            </div>
                                            @elseif($forms['type'] === "textarea")
                                            <div class="input-field col {{ $forms['col'] }}">
                                                <textarea placeholder="{{ $forms['placeholder'] }}" name="{{ $forms['name'] }}" id="{{ $forms['name'] }}" type="text" value={{ old($forms['name']) }}>{{ old($forms['name']) }}</textarea>
                                                <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                <?php $error = $forms['name']; ?>
                                                @error($error)
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                    @enderror
                                            </div>
                                            @elseif($forms['type'] === "select")
                                            <div class="input-field col {{ $forms['col'] }}">
                                                @php $v = $forms['value']; @endphp
                                                <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}" required>
                                                    <option value="">Pilih</option>
                                                    @foreach ($forms['relasi'] as $p)
                                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                                    @endforeach
                                                </select>

                                                <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                <?php $error = $forms['name']; ?>
                                                @error($error)
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                    @enderror
                                            </div>
                                            @elseif($forms['type'] === "format")
                                            <div class="input-field col {{ $forms['col'] }}">

                                                <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                                                    <option value="">Pilih</option>
                                                    <option value="html">HTML</option>
                                                    <option value="docx">DOCX</option>
                                                    <option value="xlsx">XLSX</option>
                                                </select>

                                                <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                <?php $error = $forms['name']; ?>
                                                @error($error)
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                    @enderror
                                            </div>
                                            @elseif($forms['type'] == 'selectsortbymahasiswa')
                                            <div class="input-field col s4 m4 offset-m2">

                                                <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                                                    <option value="nim">NIM</option>
                                                    <option value="nama">Nama Mahasiswa</option>
                                                    <option value="program_studi">Program Studi</option>
                                                    <option value="status">Status</option>
                                                    <option value="jenis_pendaftaran">Jenis Pendaftaran</option>
                                                    <option value="jenis_kelamin">Jenis kelamin</option>
                                                </select>

                                                <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                <?php $error = $forms['name']; ?>
                                                @error($error)
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                    @enderror
                                            </div>
                                            <div class="input-field col s4 m4 offset-s2">

                                                <select name="sorttype" id="sorttype">
                                                    <option value="asc">A-Z (Ascending)</option>
                                                    <option value="desc">Z-A (Descending)</option>
                                                </select>

                                                <label for="first_name">&nbsp;</label>
                                                <?php $error = "sorttype" ?>
                                                @error($error)
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                    @enderror
                                            </div>
                                            @elseif($forms['type'] == 'selectformat')
                                            <div class="input-field col s8 offset-s2 m8 offset-m2">

                                                <select name="{{ $forms['name'] }}" id="{{ $forms['name'] }}">
                                                    <option value="">Pilih</option>
                                                    <option value="html">HTML</option>
                                                    <option value="docx">DOCX</option>
                                                    <option value="xlsx">XLSX</option>
                                                </select>

                                                <label for="first_name">{{ $forms['placeholder'] }}</label>
                                                <?php $error = $forms['name']; ?>
                                                @error($error)
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                    @enderror
                                            </div>
                                            @endif
                                            @endforeach



                                            <div class="input-field center col s8 offset-s2 m8 offset-m2">
                                                <button type="submit" class="waves-effect waves-light btn-small">Generate</button>
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
<script>


</script>

@endsection