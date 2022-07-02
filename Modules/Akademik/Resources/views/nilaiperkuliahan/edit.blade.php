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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Edit data {{$page}}</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
               <li class="breadcrumb-item"><a href="{{route($page.'.index')}}">{{$page}}</a>
              </li>
              <li class="breadcrumb-item active">edit
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
            <div class="col s6 mt-2">
                <p>Program Study : {{ $nilaiperkuliahan->programstudy->jenjang->nama_jenjang.' '.$nilaiperkuliahan->programstudy->jurusan->nama_jurusan }}</p>
            </div>
            <div class="col s6 mt-2">
                <p>Tahun Ajaran : {{ $nilaiperkuliahan->jenissemester->tahunajaran->tahun_ajaran.' '.$nilaiperkuliahan->jenissemester->jenis_semester }}</p>
            </div>
            <div class="col s6 mt-2">
                <p>Matakuliah : {{ $nilaiperkuliahan->matakuliah->nama_matakuliah }}</p>
            </div>
            <div class="col s6 mt-2">
                <p>Nama Kelas : {{ $nilaiperkuliahan->nama_kelas.$nilaiperkuliahan->kode }}</p>
            </div>
        </div>
        </div>
        </div>
</div>

<form action="{{ route($page.'.update',[$nilaiperkuliahan->id]) }}" method="POST"
    enctype="multipart/form-data" class="col s12">
    @csrf
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
               <div class="row">
                <div class="col s6">
                    <h5>Daftar Peserta Kelas</h5>
                </div>
                <div class="col s6">
                    <button type="submit" class="waves-effect waves-light btn-small right"><i class="material-icons right">send</i>save</button>
                </div>
               </div>
                <table>
                    <thead>
                        <tr>

                            <th>#</th>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Angkatan</th>

                            <th>Angka</th>
                            <th>Huruf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1 @endphp
                        @foreach($mahasiswa as $row)
                        <tr>
                            <td></td>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->mahasiswa->nim }}</td>
                            <td>{{ $row->mahasiswa->nama }}</td>
                            <td>{{ $row->mahasiswa->riwayatpendidikan ? $row->mahasiswa->riwayatpendidikan->programstudy->jurusan->nama_jurusan : '' }}</td>
                            <td>{{ $row->mahasiswa->riwayatpendidikan ? \Carbon\Carbon::parse($row->mahasiswa->riwayatpendidikan->tahun_masuk)->isoFormat('Y') : '' }}</td>
                            <td>
                                <input type="hidden" name="mahasiswa_id[]" class="validate mahasiswa_id" value="{{ $row->mahasiswa->id }}">
                                <input type="number" name="angka[]" min="0" class="validate angka" step="any" value="{{$row->nilai ? $row->nilai->nilai_angka : 0}}">
                            </td>
                            <td>
                                <select name="huruf[]" id="">
                                    <option value=""></option>
                                    <option value="a-" @if($row->nilai ? $row->nilai->nilai_huruf == 'a-' : "") selected @endif>A- (3,67)</option>
                                    <option value="a"  @if($row->nilai ? $row->nilai->nilai_huruf == 'a' : "") selected @endif>A (4,00)</option>
                                    <option value="b-"  @if($row->nilai ? $row->nilai->nilai_huruf == 'b-' : "") selected @endif>B- (2,67)</option>
                                    <option value="b"  @if($row->nilai ? $row->nilai->nilai_huruf == 'b' : "") selected @endif>B (3,00)</option>
                                    <option value="b+"  @if($row->nilai ? $row->nilai->nilai_huruf == 'b+' : "") selected @endif>B+ (3,33)</option>
                                    <option value="c-"  @if($row->nilai ? $row->nilai->nilai_huruf == 'c-' : "") selected @endif>C- (1,67)</option>
                                    <option value="c"  @if($row->nilai ? $row->nilai->nilai_huruf == 'c' : "") selected @endif>C (2,00)</option>
                                    <option value="c+"  @if($row->nilai ? $row->nilai->nilai_huruf == 'c+' : "") selected @endif>C+ (2,33)</option>
                                    <option value="d"  @if($row->nilai ? $row->nilai->nilai_huruf == 'd' : "") selected @endif>D (1,00)</option>
                                    <option value="e"  @if($row->nilai ? $row->nilai->nilai_huruf == 'e' : "") selected @endif>E (0,00)</option>
                                    <option value="t"  @if($row->nilai ? $row->nilai->nilai_huruf == 't' : "") selected @endif>T (0,00)</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</form>



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

  </script>


@endsection
