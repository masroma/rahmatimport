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
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Detail data {{$page}}</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
               <li class="breadcrumb-item"><a href="{{route($page.'.index')}}">{{$page}}</a>
              </li>
              <li class="breadcrumb-item active">detail
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
            <div class="col s12 m6 l10">
                <h4 class="card-title">Data Dosen</h4>
             </div>
            </div>
          </div>
          <div class="row">
            <div class="col s12">
               <div class="row" id="main-view">
                  <div class="col s12">
                     <ul class="tabs tab-demo z-depth-1">
                        <li class="tab col m3"><a class="active" href="#test1">Data Pribadi</a></li>
                           <li class="tab col m2"><a href="#test2">Detail</a></li>
                           <li class="tab col m2"><a href="#test3">Alamat</a></li>
                           <li class="tab col m2"><a href="#test4">Keluarga</a></li>
                           <li class="tab col "><a href="#test5">Kebutuhan Khusus</a></li>
                     </ul>
                  </div>
                  <div class="col s12">
                     <div id="test1" class="col s6">
                        <table>

                            <tr>
                                <td >Nama</td>
                                <td >{{$dosen->nama_dosen}}</td>
                            </tr>
                            <tr>
                                <td >Tempat Lahir</td>
                                <td >{{$dosen->tempat_lahir}}</td>
                            </tr>
                            <tr>
                                <td >Tanggal Lahir</td>
                                <td >{{\Carbon\Carbon::parse($dosen->tanggal_lahir)->isoFormat('dddd, D MMMM Y')}}</td>
                            </tr>
                            <tr>
                                <td >Jenis Kelamin</td>
                                <td >{{$dosen->jenis_kelamin}}</td>
                            </tr>

                            <tr>
                                <td >Agama</td>
                                <td >{{$dosen->agama}}</td>
                            </tr>
                        </table>
                     </div>
                     <div id="test2" class="col s6">
                        <table>
                            <tr>
                                <td>NIK</td>
                                <td>{{ $dosen->Detail->nik }}</td>
                            </tr>
                            <tr>
                                <td>NPWP</td>
                                <td>{{ $dosen->Detail->npwp }}</td>
                            </tr>
                            <tr>
                                <td>NIP</td>
                                <td>{{ $dosen->Detail->nip }}</td>
                            </tr>
                            <tr>
                                <td>Telephone</td>
                                <td>{{ $dosen->Detail->telephone }}</td>
                            </tr>
                            <tr>
                                <td>Handphone</td>
                                <td>{{ $dosen->Detail->handphone }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $dosen->Detail->email }}</td>
                            </tr>
                            <tr>
                                <td>Ikatan Kerja</td>
                                <td>{{ $dosen->Detail->ikatan_kerja }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Pegawai</td>
                                <td>{{ $dosen->Detail->jenis_pegawai }}</td>
                            </tr>
                            <tr>
                                <td>No SK CPNS</td>
                                <td>{{ $dosen->Detail->no_sk_cpns }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal SK CPNS</td>
                                <td >{{\Carbon\Carbon::parse($dosen->Detail->tanggal_sk_cpns )->isoFormat('dddd, D MMMM Y')}}</td>
                            </tr>
                            <tr>
                                <td>No SK Pengangkatan</td>
                                <td>{{ $dosen->Detail->no_sk_pengangkatan }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal SK Pengangkatan</td>
                                <td>{{ $dosen->Detail->tanggal_sk_pengangkatan }}</td>
                            </tr>
                            <tr>
                                <td>Lembaga Pengangkatan</td>
                                <td>{{ $dosen->Detail->lembaga_pengangkatan }}</td>
                            </tr>
                            <tr>
                                <td>Sumber Lainnya</td>
                                <td>{{ $dosen->Detail->sumber_lainyas }}</td>
                            </tr>
                        </table>
                     </div>
                     <div id="test3" class="col s12">
                        <table>


                            <tr>
                                <td >Nama Jalan</td>
                                <td >{{$dosen->Address->jalan}}</td>
                            </tr>
                            <tr>
                                <td >Provinsi</td>
                                <td >@if($dosen->Address->Provinsi){{ $dosen->Address->Provinsi->name }}@endif</td>
                            </tr>
                            <tr>
                                <td >Kota</td>
                                <td >@if($dosen->Address->Kota){{ $dosen->Address->Kota->name }}@endif</td>
                            </tr>
                            <tr>
                                <td >Kecamatan</td>
                                <td >@if($dosen->Address->Kecamatan){{ $dosen->Address->Kecamatan->name }}@endif</td>
                            </tr>
                            <tr>
                                <td >Kelurahan</td>
                                <td >@if($dosen->Address->Kecamatan){{ $dosen->Address->Kelurahan->name }}@endif</td>
                            </tr>

                            <tr>
                                <td >RT</td>
                                <td >{{$dosen->Address->rt}}</td>
                            </tr>
                            <tr>
                                <td >RW</td>
                                <td >{{$dosen->Address->rw}}</td>
                            </tr>

                            <tr>
                                <td >Kode Pos</td>
                                <td >{{$dosen->Address->kode_pos}}</td>
                            </tr>


                        </table>
                     </div>
                     <div id="test4" class="col s6">
                        <table>
                            <tr>
                                <td>Status Pernikahan</td>
                                <td>{{ $dosen->Keluarga->status_pernikahan }}</td>
                            </tr>
                            <tr>
                                <td>Nama Pasangan</td>
                                <td>{{ $dosen->Keluarga->nama_pasangan }}</td>
                            </tr>
                            <tr>
                                <td>NIP Pasangan</td>
                                <td>{{ $dosen->Keluarga->nip_pasangan }}</td>
                            </tr>
                            <tr>
                                <td>TMT Pasangan</td>
                                <td>{{ $dosen->Keluarga->tmt_pasangan }}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan Pasangan</td>
                                <td>{{ $dosen->Keluarga->pekerjaan }}</td>
                            </tr>

                        </table>
                     </div>
                     <div id="test5" class="col s6">
                        <table>
                            <tr>
                                <td>Handle Kebutuhan Khusus</td>
                                <td>@if($dosen->KebutuhanKhusus->handle_kebutuhan_khusus == 'y') IYA @else TIDAK @endif</td>
                            </tr>
                            <tr>
                                <td>Handle Bahasa Isyarat</td>
                                <td>@if($dosen->KebutuhanKhusus->handle_bahasa_isyarat == 'y') IYA @else TIDAK @endif</td>
                            </tr>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
        </div>
      </div>
    </div>

    <div class="card">
        <div class="card-content">
            <div class="row mb-5">
                <div class="col s10 m6 l6">
                  <h5>Riwayat Fungsional</h5>
                </div>
                <div class="col s10 m6 l6 ">
                    <a class="btn waves-effect waves-light breadcrumbs-btn  right" href="{{ route('dosen.createfungsional',$dosen->id) }}" id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a>
                </div>
            </div>
          <div class="row">
              <div class="col s12">
                <table id="page-length-option" class="display">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Jabatan</th>
                      <th>SK Jabatan</th>
                      <th>TMT Jabatan</th>
                      <th>#</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-content">
            <div class="row mb-5">
                <div class="col s10 m6 l6">
                  <h5>Riwayat Pangkat</h5>
                </div>
                <div class="col s10 m6 l6 ">
                    <a class="btn waves-effect waves-light breadcrumbs-btn  right" href="{{ route('dosen.createpangkat',$dosen->id) }}" id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a>
                </div>
            </div>
          <div class="row">
              <div class="col s12">
                <table id="page-length-options" class="display">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Pangkat</th>
                      <th>SK Pangkat</th>
                      <th>Tanggal SK Pangkat</th>
                      <th>TMT Pangkat</th>
                      <th>Masa Kerja</th>
                      <th>#</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-content">
            <div class="row mb-5">
                <div class="col s10 m6 l6">
                  <h5>Riwayat Pendidikan</h5>
                </div>
                <div class="col s10 m6 l6 ">
                    <a class="btn waves-effect waves-light breadcrumbs-btn  right" href="{{ route('dosen.creatependidikan',$dosen->id) }}" id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a>
                </div>
            </div>
          <div class="row">
              <div class="col s12">
                <table id="page-length-option-pendidikan" class="display">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Bidang Study</th>
                      <th>Jenjang</th>
                      <th>Gelar</th>
                      <th>Perguruan Tinggi</th>
                      <th>Fakultas</th>
                      <th>Tahun Lulus</th>
                      <th>SKS</th>
                      <th>IPK</th>
                      <th>#</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-content">
            <div class="row mb-5">
                <div class="col s10 m6 l6">
                  <h5>Riwayat Penelitian</h5>
                </div>
                <div class="col s10 m6 l6 ">
                    <a class="btn waves-effect waves-light breadcrumbs-btn  right" href="{{ route('dosen.createpenelitian',$dosen->id) }}" id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a>
                </div>
            </div>
          <div class="row">
              <div class="col s12">
                <table id="page-length-option-penelitian" class="display">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul Penelitian</th>
                      <th>Bidang Ilmu</th>
                      <th>Lembaga</th>
                      <th>Tahun</th>
                      <th>#</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-content">
            <div class="row mb-5">
                <div class="col s10 m6 l6">
                  <h5>Riwayat Sertifikasi</h5>
                </div>
                <div class="col s10 m6 l6 ">
                    <a class="btn waves-effect waves-light breadcrumbs-btn  right" href="{{ route('dosen.createsertifikasi',$dosen->id) }}" id="tombol-tambah" ><i class="material-icons left">add_circle_outline</i>Tambah</a>
                </div>
            </div>
          <div class="row">
              <div class="col s12">
                <table id="page-length-option-sertifikasi" class="display">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No Peserta</th>
                      <th>Bidang Study</th>
                      <th>Jenis Sertifikasi</th>
                      <th>Tahun Sertifikasi</th>
                      <th>No SK Sertifikasi</th>
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
                let iddosen = {{ $dosen->id }};
                  $('#page-length-option').DataTable({
                      "scrollX": true,
                      "autoWidth": true,
                      processing: true,
                      serverSide: true,
                      ajax: {
                          url: "{{ url('akademik/dosen/datafungsional') }}/" + iddosen,
                          type: "GET",
                      },
                      columns: [
                            {
                                data:"DT_RowIndex",
                                name:"DT_RowIndex"
                            },
                          {
                              data: 'jabatan',
                              name: 'jabatan'
                          },

                          {
                              data: 'sk_jabatan',
                              name: 'sk_jabatan'
                          },

                          {
                              data: 'TMT_jabatan',
                              name: 'TMT_jabatan'
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

                  $('#page-length-options').DataTable({
                      "scrollX": true,
                      "autoWidth": true,
                      processing: true,
                      serverSide: true,
                      ajax: {
                          url: "{{ url('akademik/dosen/datapangkat') }}/" + iddosen,
                          type: "GET",
                      },
                      columns: [
                            {
                                data:"DT_RowIndex",
                                name:"DT_RowIndex"
                            },
                          {
                              data: 'pangkat',
                              name: 'pangkat'
                          },

                          {
                              data: 'sk_pangkat',
                              name: 'sk_pangkat'
                          },

                          {
                              data: 'tanggal_sk_pangkat',
                              name: 'tanggal_sk_pangkat'
                          },

                          {
                              data: 'TMT_pangkat',
                              name: 'TMT_pangkat'
                          },

                          {
                              data: 'masa_kerja',
                              name: 'masa_kerja'
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

                  $('#page-length-option-pendidikan').DataTable({
                      "scrollX": true,
                      "autoWidth": true,
                      processing: true,
                      serverSide: true,
                      ajax: {
                          url: "{{ url('akademik/dosen/datapendidikan') }}/" + iddosen,
                          type: "GET",
                      },
                      columns: [
                            {
                                data:"DT_RowIndex",
                                name:"DT_RowIndex"
                            },
                          {
                              data: 'bidang_study',
                              name: 'bidang_study'
                          },

                          {
                              data: 'jenjang',
                              name: 'jenjang'
                          },

                          {
                              data: 'gelar',
                              name: 'gelar'
                          },

                          {
                              data: 'perguruan_tinggi',
                              name: 'perguruan_tinggi'
                          },

                          {
                              data: 'fakultas',
                              name: 'fakultas'
                          },

                          {
                              data: 'tahun_lulus',
                              name: 'tahun_lulus'
                          },

                          {
                              data: 'sks',
                              name: 'sks'
                          },

                          {
                              data: 'ipk',
                              name: 'ipk'
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

                  $('#page-length-option-penelitian').DataTable({
                      "scrollX": true,
                      "autoWidth": true,
                      processing: true,
                      serverSide: true,
                      ajax: {
                          url: "{{ url('akademik/dosen/datapenelitian') }}/" + iddosen,
                          type: "GET",
                      },
                      columns: [
                            {
                                data:"DT_RowIndex",
                                name:"DT_RowIndex"
                            },
                          {
                              data: 'judul_penelitian',
                              name: 'judul_penelitian'
                          },

                          {
                              data: 'bidang_ilmu',
                              name: 'bidang_ilmu'
                          },

                          {
                              data: 'lembaga',
                              name: 'lembaga'
                          },

                          {
                              data: 'tahun',
                              name: 'tahun'
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

                  $('#page-length-option-sertifikasi').DataTable({
                      "scrollX": true,
                      "autoWidth": true,
                      processing: true,
                      serverSide: true,
                      ajax: {
                          url: "{{ url('akademik/dosen/datasertifikasi') }}/" + iddosen,
                          type: "GET",
                      },
                      columns: [
                            {
                                data:"DT_RowIndex",
                                name:"DT_RowIndex"
                            },
                          {
                              data: 'no_peserta',
                              name: 'no_peserta'
                          },

                          {
                              data: 'bidang_study',
                              name: 'bidang_study'
                          },

                          {
                              data: 'jenis_sertifikasi',
                              name: 'jenis_sertifikasi'
                          },

                          {
                              data: 'tahun_sertifikasi',
                              name: 'tahun_sertifikasi'
                          },

                          {
                              data: 'no_sk_sertifikasi',
                              name: 'no_sk_sertifikasi'
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


     function deleteConfirmFungsional(id) {
              swal({
                      title: "Kamu Yakin ?",
                      text: "akan menghapus data ini !",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((dt) => {
                      if (dt) {
                          window.location.href = "{{ url('akademik/dosen') }}/" + id + "/deletefungsional";
                      }
                  });
          }

          function deleteConfirmPangkat(id) {
              swal({
                      title: "Kamu Yakin ?",
                      text: "akan menghapus data ini !",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((dt) => {
                      if (dt) {
                          window.location.href = "{{ url('akademik/dosen') }}/" + id + "/deletepangkat";
                      }
                  });
          }

          function deleteConfirmPendidikan(id) {
              swal({
                      title: "Kamu Yakin ?",
                      text: "akan menghapus data ini !",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((dt) => {
                      if (dt) {
                          window.location.href = "{{ url('akademik/dosen') }}/" + id + "/deletependidikan";
                      }
                  });
          }

          function deleteConfirmPenelitian(id) {
              swal({
                      title: "Kamu Yakin ?",
                      text: "akan menghapus data ini !",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((dt) => {
                      if (dt) {
                          window.location.href = "{{ url('akademik/dosen') }}/" + id + "/deletepenelitian";
                      }
                  });
          }

          function deleteConfirmSertifikasi(id) {
              swal({
                      title: "Kamu Yakin ?",
                      text: "akan menghapus data ini !",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((dt) => {
                      if (dt) {
                          window.location.href = "{{ url('akademik/dosen') }}/" + id + "/deletesertifikasi";
                      }
                  });
          }
    </script>

@endsection
