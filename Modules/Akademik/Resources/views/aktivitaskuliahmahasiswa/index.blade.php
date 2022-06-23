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
                    <th>Mahasiswa</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>IPS</th>
                    <th>IPK</th>
                    <th>Jumlah SKS Semester</th>
                    <th>SKS TOTAL</th>
                    <th>Biaya Kuliah</th>
                    <th>#</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>IPS</th>
                    <th>IPK</th>
                    <th>Jumlah SKS Semester</th>
                    <th>SKS TOTAL</th>
                    <th>Biaya Kuliah</th>
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
                          url: "{{ route('aktivitaskuliahmahasiswa.data') }}",
                          type: "GET",
                      },
                      columns: [
                      {
                          data:"DT_RowIndex",
                          name:"DT_RowIndex"
                      },
                      {
                            data: 'mahasiswa',
                            name: 'mahasiswa'
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
                        {
                            data: 'biaya',
                            name: 'biaya'
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
                          window.location.href = "{{ url('akademik/aktivitaskuliahmahasiswa') }}/" + id + "/delete";
                      }
                  });
          }
    </script>

@endsection
