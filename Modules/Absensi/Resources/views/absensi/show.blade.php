@extends('layouts.v1')
@section('title') {{$title}} @endsection
@section('content')
<div class="row">
    <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
      <!-- Search for small screen-->
      <div class="container">
        <div class="row">
          <div class="col s10 m6 l6">
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Data {{$title}}</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
              <li class="breadcrumb-item"><a href="{{ route('ruangperkuliahan.index') }}">Ruangan</a>
              </li>
              <li class="breadcrumb-item active">{{$title}}
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
        <div class="col s10">
            <p>Nama Dosen :
                @foreach($dosen as $d)
                  {{ $d->dosen->nama_dosen }}
                @endforeach
            </ul> </p>
            <p>Matakuliah : {{ $ruang->kelasperkuliahan->matakuliah->nama_matakuliah }} </p>
            <p>Bobot SKS: {{ $ruang->kelasperkuliahan->matakuliah->bobot_mata_kuliah }}</p>


        </div>
      </div>
      <div class="row">
        <div class="col s12">
          <table id="page-length-option" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pertemuan</th>
                    <th>Type</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1 @endphp
                @foreach ($semester as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Pertemuan {{ $row->pertemuan_ke }}</td>
                        <td>{{ $row->type }}</td>
                        <td>{{ Carbon\Carbon::parse($row->tanggal_perkuliahan)->isoFormat('D MMMM Y') }}</td>
                        <td>{{ Carbon\Carbon::parse($row->jam_masuk)->format('H:i') }}</td>
                        <td>{{ Carbon\Carbon::parse($row->jam_keluar)->format('H:i') }}</td>
                        <td><a href="{{ route('absensi.edit',$row->id) }}" class="btn-small">detail</a></td>
                    </tr>
                @endforeach
            </tbody>

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


@endsection
