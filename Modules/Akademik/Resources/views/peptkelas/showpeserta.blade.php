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
                <p>Nama PEPT : {{ $ruang->ruangperkuliahan->pept->nama_batch }}</p>
            </div>
            <div class="col s6 mt-2">
                <p>Tanggal Pendaftaran : {{ \Carbon\Carbon::parse($ruang->ruangperkuliahan->pept->tanggal_pendaftaran)->isoFormat('D MMMM Y') }}</p>
                <p>Tanggal Tutup Pendaftaran : {{ \Carbon\Carbon::parse($ruang->ruangperkuliahan->pept->tanggal_tutup_pendaftaran)->isoFormat('D MMMM Y') }}</p>
            </div>


        </div>
        </div>
        </div>
</div>

<form action="{{ route($page.'.updatenilai',[$ruang->id]) }}" method="POST"
    enctype="multipart/form-data" class="col s12">
    @csrf
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
               <div class="row">
                <div class="col s6">
                    <h5>Daftar Peserta  {{ $ruang->ruangperkuliahan->pept->nama_batch }}</h5>
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
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1 @endphp

                        @foreach($data as $row )

                        <tr>
                            <td></td>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->mahasiswa->nim }}</td>
                            <td>{{ $row->mahasiswa->nama }}</td>

                            <td>
                                <input type="hidden" name="mahasiswa_id[]" class="validate mahasiswa_id" value="{{ $row->mahasiswa->id }}">
                                <input type="number" name="nilai[]" min="0" class="validate angka" step="any" value="{{ $row->nilai }}">
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
