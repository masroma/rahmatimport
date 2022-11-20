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
              <a class="btn waves-effect waves-light breadcrumbs-btn right" href="{{route($page.'.create')}}"  id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a>

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
                    <th colspan="4" class="center">Data kurikulum</th>
                    <th colspan="3" class="center">Atur Jumlah SKS</th>
                    <th>
                        <button class="btn waves-effect waves-light breadcrumbs-btn right" type="button" onclick="syncToNeoFeeder()"><i class="material-icons left">add_circle_outline</i>Sync</button>
                    </th>
                </tr>
              <tr>
                <th>#</th>
                <th>No</th>
                <th>Nama Kurikulum</th>

                <th>Program Study</th>

                <th>Mulai Berlaku</th>
                <th>Lulus</th>
                <th>Wajib</th>
                <th>Pilihan</th>

                <th>#</th>
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
                  $('#page-length-option').DataTable({
                      "scrollX": true,
                      "autoWidth": true,
                      processing: true,
                      serverSide: true,
                      ajax: {
                          url: "{{ route('kurikulum.data') }}",
                          type: "GET",
                      },
                      columns: [
                        {
                            data: "checkbox_action",
                            name: "checkbox_action"
                        },
                        {
                            data:"DT_RowIndex",
                            name:"DT_RowIndex"
                        },
                        {
                            data: 'nama_kurikulum',
                            name: 'nama_kurikulum'
                        },
                        {
                            data: 'programstudy',
                            name: 'programstudy'
                        },
                        {
                            data: 'masaberlaku',
                            name: 'masaberlaku'
                        },
                        {
                            data: 'jumlah_sks',
                            name: 'jumlah_sks'
                        },
                        {
                            data: 'jumlah_bobot_mata_kuliah_pilihan',
                            name: 'jumlah_bobot_mata_kuliah_pilihan'
                        },
                        {
                            data: 'jumlah_bobot_mata_kuliah_wajib',
                            name: 'jumlah_bobot_mata_kuliah_wajib'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                      ],
                      order: [
                          [1, 'asc']
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
                window.location.href = "{{ url('akademik/kurikulum') }}/" + id + "/delete";
            }
        });
    }

    function syncToNeoFeeder() {
        const getCheckBoxIds = $("input[name='ids[]']:checked").map(function(_, el) {
            return $(el).val()
        }).get();

        swal({
            title: "Kamu Yakin Ingin Mengupdate " + getCheckBoxIds.length + " Data Ke Neo Feeder ?",
            text: "akan mengupdate seluruh data ke neofeeder sesuai yang di centang",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
        })
        .then((dt) => {
            if(dt) {
                $.ajax({
                    url: "{{url('akademik/kurikulum/insert-or-update-kurikulum-to-neo-feeder')}}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "ids": getCheckBoxIds
                    },
                    success: function(response) {
                        const table = $('#page-length-option').DataTable();
                        table.ajax.reload();

                    },
                    error: function (error) {
                        alert(error.message)
                    }
                })


            }
        })
    }
    </script>

@endsection
