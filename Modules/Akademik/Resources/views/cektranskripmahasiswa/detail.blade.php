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
                        <h5 class="breadcrumbs-title mt-0 mb-0"><span>Data {{ $title }}</span></h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                            </li>
                            {{-- <li class="breadcrumb-item"><a href="#">Table</a>
              </li> --}}
                            <li class="breadcrumb-item active">{{ $title }}
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
                                        <div class="col s12">
                                            <table id="page-length-option" class="display">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Program Studi</th>
                                                        <th>Agkatan</th>
                                                        <th>Jumlah Mahasiswa</th>
                                                        <th>Jumlah Mahasiswa Sudah Dihitung</th>
                                                        <th>#</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <th>No</th>
                                                    <th>Program Studi</th>
                                                    <th>Agkatan</th>
                                                    <th>Jumlah Mahasiswa</th>
                                                    <th>Jumlah Mahasiswa Sudah Dihitung</th>
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
        var table;
        // ini vendor data
        (function() {
            loadDataTable();
        })();

        function loadDataTable() {
            $(document).ready(function() {
                table = $('#page-length-option').DataTable({
                    "scrollX": true,
                    "autoWidth": true,
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    ajax: {
                        url: "{{ route('transkripnilai.data') }}",
                        type: "GET",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: 'program_study',
                            name: 'program_study'
                        },

                        {
                            data: 'angkatan',
                            name: 'angkatan'
                        },

                        {
                            data: 'total_mahasiswa',
                            name: 'total_mahasiswa'
                        },



                        {
                            data: 'sudah_hitung',
                            name: 'sudah_hitung'
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

        function calculate(e) {
            swal({
                title: 'Now loading',
                allowEscapeKey: false,
                allowOutsideClick: false,
                onOpen: () => {
                    swal.showLoading();
                }
            }).then(
                $.get('/akademik/transkripnilai/calculate/' + $(e).data('programstudyid'), function(data) {
                    swal({
                        title: 'Finished!',
                        type: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        onClose: () => {
                            table.ajax.reload();
                        }
                    })
                })
            )

        }
    </script>

@endsection
