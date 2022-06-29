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
              {{-- <li class="breadcrumb-item"><a href="#">Table</a>
              </li> --}}
              <li class="breadcrumb-item active">{{$title}}
              </li>
            </ol>
          </div>
          <div class="col s2 m6 l6">
              @if($canCreate)
              <a class="btn  waves-effect waves-light breadcrumbs-btn right" href="{{route($page.'.create')}}"  id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a>
              @endif
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
        <div class="col s12">
          <table id="page-length-option" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Program Study</th>
                    <th>Semester</th>
                    <th>Target Mahasiswa Baru</th>
                    <th>Pendaftar Ikut Seleksi</th>
                    <th>Pendaftar Lulus Seleksi</th>
                    <th>Pendaftar Daftar Ulang</th>
                    <th>Pendaftar Mengundurkan Diri</th>
                    <th>Pendaftar Jumlah Pertemuan</th>
                    <th>Awal Perkuliahan</th>
                    <th>Akhir Perkuliahan</th>
                    <th>#</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Program Study</th>
                    <th>Semester</th>
                    <th>Target Mahasiswa Baru</th>
                    <th>Pendaftar Ikut Seleksi</th>
                    <th>Pendaftar Lulus Seleksi</th>
                    <th>Pendaftar Daftar Ulang</th>
                    <th>Pendaftar Mengundurkan Diri</th>
                    <th>Pendaftar Jumlah Pertemuan</th>
                    <th>Awal Perkuliahan</th>
                    <th>Akhir Perkuliahan</th>
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
                  $('#page-length-option').DataTable({
                      "scrollX": true,
                      "autoWidth": true,
                      processing: true,
                      serverSide: true,
                      ajax: {
                          url: "{{ route('pengaturanperiodeperkuliahan.data') }}",
                          type: "GET",
                      },
                      columns: [
                      {
                          data:"DT_RowIndex",
                          name:"DT_RowIndex"
                      },
                      {
                            data: 'jurusan.nama_jurusan',
                            name: 'jurusan.nama_jurusan'
                        },
                        {
                            data: 'semester',
                            name: 'semester'
                        },

                        {
                            data: 'target_mahasiswa_baru',
                            name: 'target_mahasiswa_baru'
                        },

                        {
                            data: 'pendaftar_ikut_seleksi',
                            name: 'pendaftar_ikut_seleksi'
                        },

                        {
                            data: 'pendaftar_lulus_seleksi',
                            name: 'pendaftar_lulus_seleksi'
                        },

                        {
                            data: 'pendaftar_daftar_ulang',
                            name: 'pendaftar_daftar_ulang'
                        },

                        {
                            data: 'pendaftar_mengundurkan_diri',
                            name: 'pendaftar_mengundurkan_diri'
                        },

                        {
                            data: 'jumlah_pertemuan',
                            name: 'jumlah_pertemuan'
                        },

                        {
                            data: 'awal_perkuliahan',
                            name: 'awal_perkuliahan'
                        },

                        {
                            data: 'akhir_perkuliahan',
                            name: 'akhir_perkuliahan'
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
                          window.location.href = "{{ url('akademik/pengaturanperiodeperkuliahan') }}/" + id + "/delete";
                      }
                  });
          }
    </script>

@endsection
