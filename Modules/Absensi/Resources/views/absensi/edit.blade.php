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
              <li class="breadcrumb-item active">pertemuan ke {{ $jadwal->pertemuan_ke }}
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
    <div class="col s4">
      <div class="card">
        <div class="card-content">
                   <form action="{{ route('absensi.update', $jadwal->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Tanggal Perkuliahan</label>
                        <input type="date" name="tanggal_perkuliahan" id="" class="form-control" value="{{ old('tanggal_perkuliahan',$jadwal->tanggal_perkuliahan) }}">
                        @error('tanggal_perkuliahan')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Jam Masuk</label>
                        <input type="time" name="jam_masuk" id="" class="form-control" value="{{ old('jam_masuk',$jadwal->jam_masuk) }}">
                        @error('jam_masuk')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Jam Keluar</label>
                        <input type="time" name="jam_keluar" id="" class="form-control" value="{{ old('jam_keluar',$jadwal->jam_keluar) }}">
                        @error('jam_keluar')
                        <span class="red-text text-darken-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-2">
                    <button  class="btn-small block">update waktu perkuliahan</button>
                    </div>
                </form>

        </div>
      </div>
    </div>
    <div class="col s8">
        <div class="card">
          <div class="card-content">
                      <div class="form-group mb-3">
                          <label for="">Tema</label>
                          <h6>{{ $absenssidosen->tema ?? '-' }}</h6>
                      </div>
                      <div class="form-group">
                        <label for="">Pokok Pembahasan</label>
                        <p>{{ $absensidosen->pokok_bahasan  ?? "-"}}</p>
                    </div>
          </div>
        </div>
      </div>
  </div>
<div class="row">
<div class="col s12">
  <div class="card">
    <div class="card-content">
      {{-- <h4 class="card-title">Page Length Options</h4> --}}

      <div class="row">
        <div class="col s12">
          <table id="page-length-option" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Mahasiswa</th>
                    <th>Status</th>
                </tr>
            </thead>
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
              $(document).ready(function () {
                let id = {{ $id }};
                console.log(id);
                  $('#page-length-option').DataTable({
                      "scrollX": true,
                      "autoWidth": true,
                      processing: true,
                      serverSide: true,
                      ajax: {
                        url: "{{ url('absensi/datamahasiswa') }}/" + id,
                          type: "GET",
                      },
                      columns: [
                      {
                          data:"DT_RowIndex",
                          name:"DT_RowIndex"
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
                            data: 'status',
                            name: 'status'
                        },


                      ],
                      order: [
                          [0, 'asc']
                      ]
                  });
              });
          }

    </script>


@endsection
