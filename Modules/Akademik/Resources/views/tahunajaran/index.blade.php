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
              <a class="btn waves-effect waves-light blue breadcrumbs-btn right me-3" href="{{route('index.semester')}}"  id="tombol-tambah" style="margin-top:-3px; margin-left:10px;display:none" ><i class="material-icons left">add_circle_outline</i>Import</a>
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
        <div class="col-s12">
          <form method="post" action="{{ route('tahunajaran.updatestatus') }}" >
            @csrf
            <div class="input-field col s4">
              <select class="form-control" name="id" onchange="this.form.submit()">
                <option value="">belum ada yang aktif</option>
                @foreach ($semester as $s)
                  <option value="{{ $s->id }}" @if($s->active == 1) selected @endif>{{ $s->jenis_semester }} -
                    @foreach ($s->tahun_ajarantest as $stest)
                        {{ $stest->tahun_ajaran }}

                    @endforeach
                </option>
                @endforeach
              </select>
              <label for="first_name">Status Tahun Ajaran Yang Aktif</label>
              @error('tahun_ajaran')
              <span class="red-text text-darken-2">{{ $message }}</small>
              @enderror
            </div>
          </form>
        </div>
        <div class="col s12">
          <table id="page-length-option" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun Ajaran</th>
                    <th>#</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Tahun Ajaran</th>
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
                          url: "{{ route('tahunajaran.data') }}",
                          type: "GET",
                      },
                      columns: [
                      {
                          data:"DT_RowIndex",
                          name:"DT_RowIndex"
                      },
                      {
                            data: 'tahun_ajaran',
                            name: 'tahun_ajaran'
                        },

                        {
                            data:'action',
                            name:'action'
                        }

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
                          window.location.href = "{{ url('akademik/tahunajaran') }}/" + id + "/delete";
                      }
                  });
          }
    </script>

@endsection
