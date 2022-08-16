@extends('layouts.v1')
@section('title') Informasi Matakuliah ditawarkan @endsection
@section('content')
<div class="row">
            <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
            <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Edit data {{$title}}</span></h5>
                            <ol class="breadcrumbs mb-0">
                              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
                              </li>
                               <li class="breadcrumb-item"><a href="{{route($page.'.index')}}">{{$title}}</a>
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
                        <div class="card" >
                            <div class="card-content">
                                <div class="row">
                                    <form action="{{ route($page.'.update', $kurikulum->id) }}" method="POST"
                                    enctype="multipart/form-data" class="col s12">
                                    @csrf
                                       <div class="row">
                                            <div class="input-field col s6  mt-2 mb-2">
                                                <input placeholder="Nama Kurikulum" name="nama_kurikulum" id="nama_kurikulum" type="text" class="validate  @error('nama_kurikulum') is-invalid @enderror" value="{{ old('nama_kurikulum',$kurikulum->nama_kurikulum) }}">
                                                <label for="first_name">Nama Kurikulum<span style="color:red">*</span></label>
                                                @error('nama_kurikulum')
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="input-field col s6  mt-2 mb-2">
                                                <select name="programstudy_id" class="select2 browser-default">
                                                    <option value="">Program Study</option>
                                                    @foreach($programstudy as $row)
                                                        <option @if(old('programstudy_id', $kurikulum->programstudy_id) == $row->id) selected @endif value="{{$row->id}}">{{ $row->jenjang->nama_jenjang }}-{{$row->jurusan->nama_jurusan}}</option>
                                                    @endforeach
                                                </select>
                                                    <label for="first_name">Program Study<span style="color:red">*</span></label>
                                                @error('programstudy_id')
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                @enderror
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="input-field col s6 mt-2 mb-2">
                                                <input placeholder="jumlah bobot mata kuliah pilihan" name="jumlah_bobot_mata_kuliah_pilihan" id="jumlah_bobot_mata_kuliah_pilihan" type="text" class="validate  @error('jumlah_bobot_mata_kuliah_pilihan') is-invalid @enderror" value="{{ old('jumlah_bobot_mata_kuliah_pilihan',$kurikulum->jumlah_bobot_mata_kuliah_pilihan) }}">
                                                <label for="first_name">Jumlah bobot mata kuliah pilihan<span style="color:red">*</span></label>
            
                                                @error('jumlah_bobot_mata_kuliah_pilihan')
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="input-field col s6  mt-2 mb-2">
                                                <select name="masa_berlaku" class="select2 browser-default">
                                                    <option value="">Mulai Berlaku</option>
                                                    @foreach($jenissemester as $row)
                                                        <option @if(old('masa_berlaku',$kurikulum->masa_berlaku) == $row->id) selected @endif value="{{$row->id}}">{{ $row->Tahunajaran->tahun_ajaran }}-{{$row->jenis_semester}}</option>
                                                    @endforeach
                                                </select>
                                                    <label for="first_name">Mulai Berlaku<span style="color:red">*</span></label>
                                                @error('masa_berlakud')
                                                <span class="red-text text-darken-2">{{ $message }}</small>
                                                @enderror
                                            </div>
                                       </div>
                                       <div class="row">
                                        <div class="input-field col s6  mt-2 mb-2">
                                            <input placeholder="jumlah_sks" name="jumlah_sks" id="jumlah_sks" type="number" class="validate  @error('jumlah_sks') is-invalid @enderror" value="{{ old('jumlah_sks',$kurikulum->jumlah_sks) }}" disabled>
                                            <label for="first_name">jumlah sks<span style="color:red">*</span></label>
        
                                            @error('jumlah_sks')
                                            <span class="red-text text-darken-2">{{ $message }}</small>
                                            @enderror
                                        </div>
        
                                        <div class="input-field col s6  mt-2 mb-2">
                                            <input placeholder="jumlah bobot mata kuliah wajib" name="jumlah_bobot_mata_kuliah_wajib" id="jumlah_bobot_mata_kuliah_wajib" type="number" class="validate  @error('jumlah_bobot_mata_kuliah_wajib') is-invalid @enderror" value="{{ old('jumlah_bobot_mata_kuliah_wajib',$kurikulum->jumlah_bobot_mata_kuliah_wajib) }}">
                                            <label for="first_name">Jumlah bobot mata kuliah wajib<span style="color:red">*</span></label>
        
                                            @error('jumlah_bobot_mata_kuliah_wajib')
                                            <span class="red-text text-darken-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="input-field col s12">
                                                <button type="submit" class="waves-effect waves-light btn-small"><i class="material-icons right">send</i>save</button>
                                                <a href={{route($page.'.index')}} class="waves-effect purple darken-1 btn-small"><i class="material-icons left">keyboard_arrow_left</i>back</a>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div id="Scrollable-tabs" class="card card card-default scrollspy">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col s12">
                                            <ul class="tabs tab-demo z-depth-1">
                                                <li class="tab col "><a class="active" href="#satu">List Matakuliah Terdaftar</a></li>
                                                <li class="tab col "><a href="#dua">List Matakuliah Belum Terdaftar</a></li>
                                              
                                            </ul>
                                        </div>
                                      
                                        <div id="satu" class="col s12 mt-3">
                                            <div class="row">
                                                <div class="col s12">
                                                    <table id="page-length-option" class="display daftartambah">
                                                        <thead>
                                                          <tr>
                                                            <th>#</th>
                                                            <th>no</th>
                                                            <th>Wajib</th>
                                                            <th>semester</th>
                                                            <th>Kode Matakuliah</th>
                                                            <th>Nama Matakuliah</th>
                                                            <th>Matakuliah</th>
                                                            <th>Tatap Muka</th>
                                                            <th>Pratikum</th>
                                                            <th>Praktek Lapangan</th>
                                                            <th>Simulasi</th>
                                                          </tr>
                                                        </thead>
                                                      </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="dua" class="col s12 mt-3">
                                            <div class="row">
                                                <div class="col s12">
                                                    <table id="page-length-option" class="display daftarlist w-100">
                                                        <thead>
                                                          <tr>
                                                            <th># <input type="hidden" id="idkurikulum" value="{{ $kurikulum->id }}"></th>
                                                            <th>no</th>
                                                            <th>Wajib</th>
                                                            <th>semester</th>
                                                            <th>Kode Matakuliah</th>
                                                            <th>Nama Matakuliah</th>
                                                            <th>Matakuliah</th>
                                                            <th>Tatap Muka</th>
                                                            <th>Pratikum</th>
                                                            <th>Praktek Lapangan</th>
                                                            <th>Simulasi</th>
                                                          </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                     
                                      
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                    </div><!-- START RIGHT SIDEBAR NAV -->
                </div>
                <div class="content-overlay"></div>
            </div>

           

         
        </div>
        @stop
        @section('script')
        <script>
       (function() {
                    loadDataTable();
                })();
      
                function loadDataTable() {
                    $(document).ready(function () {
                        $('.daftartambah').DataTable({
                            "scrollX": true,
                            "autoWidth": true,
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('kurikulummatakuliah.data') }}",
                                type: "GET",
                            },
                            columns: [
                                {
                                    data: 'action',
                                    name: 'action'
                                },
                            {
                                data:"DT_RowIndex",
                                name:"DT_RowIndex"
                            },

                            {
                                data:"checkbox",
                                name:"checkbox"
                            },

                            {
                                data:"pilihan",
                                name:"pilihan"
                            },


                                {
                                    data: 'matakuliah.kode_matakuliah',
                                    name: 'matakuliah.kode_matakuliah'
                                },



                                {
                                    data: 'matakuliah.nama_matakuliah',
                                    name: 'matakuliah.nama_matakuliah'
                                },

                                {
                                    data: 'matakuliah.bobot_mata_kuliah',
                                    name: 'matakuliah.bobot_mata_kuliah'
                                },

                                {
                                    data: 'matakuliah.bobot_tatap_muka',
                                    name: 'matakuliah.bobot_tatap_muka'
                                },


                                {
                                    data: 'matakuliah.bobot_pratikum',
                                    name: 'matakuliah.bobot_pratikum'
                                },

                                {
                                    data: 'matakuliah.bobot_praktek_lapanagn',
                                    name: 'matakuliah.bobot_praktek_lapanagn'
                                },

                                {
                                    data: 'matakuliah.bobot_simulasi',
                                    name: 'matakuliah.bobot_simulasi'
                                },




                            ],
                            order: [
                                [0, 'asc']
                            ]
                        });

                        var table = $('.daftarlist').DataTable({
                      "scrollX": true,
                      "autoWidth": true,
                      processing: true,
                      serverSide: true,
                      ajax: {
                          url: "{{ route('kurikulummatakuliahbelumterdaftar.data') }}",
                          type: "GET",
                      },
                      columns: [
                        {
                              data: 'action',
                              name: 'action'
                          },
                      {
                          data:"DT_RowIndex",
                          name:"DT_RowIndex"
                      },

                      {
                          data:"checkbox",
                          name:"checkbox"
                      },

                      {
                          data:"pilihan",
                          name:"pilihan"
                      },


                          {
                              data: 'kode_matakuliah',
                              name: 'kode_matakuliah'
                          },



                          {
                              data: 'nama_matakuliah',
                              name: 'nama_matakuliah'
                          },

                          {
                              data: 'bobot_mata_kuliah',
                              name: 'bobot_mata_kuliah'
                          },

                          {
                              data: 'bobot_tatap_muka',
                              name: 'bobot_tatap_muka'
                          },


                          {
                              data: 'bobot_pratikum',
                              name: 'bobot_pratikum'
                          },

                          {
                              data: 'bobot_praktek_lapanagn',
                              name: 'bobot_praktek_lapanagn'
                          },

                          {
                              data: 'bobot_simulasi',
                              name: 'bobot_simulasi'
                          },




                      ],
                      order: [
                          [0, 'asc']
                      ]
                  });

                    });
                }
      
              //   ini update semester
                function myFunction(val) {
                  var semester = $('.semester').val();
                  var id = $('.id').val();
      
                  console.log(id);
                  jQuery.ajax({
                      url:"{{ url('akademik/kurikulum/updatekurikulumsemester') }}?id=" + id +"&semester=" + semester,
                      type:"GET",
                      dataType:'json',
                      success:function(data){
                          table.ajax.reload();
                          var oTable = $('#page-length-option').dataTable(); //inialisasi datatable
                                  oTable.fnDraw(false); //reset datatable
                                  iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                      title: 'Data Berhasil Disimpan',
                                      message: '{{ Session('
                                      success ')}}',
                                      position: 'bottomRight'
                                  });
                      }
                  });
      
                }
      
      
              //   ini update wajib
                function myChecked(val) {
                  var wajib = $('.wajib').val();
                  var id = $('.id').val();
      
                  jQuery.ajax({
                      url:"{{ url('akademik/kurikulum/updatekurikulumwajib') }}?id=" + id +"&wajib=" + wajib,
                      type:"GET",
                      dataType:'json',
                      success:function(data){
                          var oTable = $('#page-length-option').dataTable(); //inialisasi datatable
                                  oTable.fnDraw(false); //reset datatable
                                  iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                      title: 'Data Berhasil Disimpan',
                                      message: '{{ Session('
                                      success ')}}',
                                      position: 'bottomRight'
                                  });
                      }
                  });
      
                }
      
      
      
              //   ini delete
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
                                window.location.href = "{{ url('akademik/kurikulum') }}/" + id + "/deletematakuliah";
                            }
                        });
                }
      
                function add() {
      
                  var semester =$('.semesters').val();
                  var idmatakuliah = $("input[name=idmatakuliah]").val();
                  var idkurikulum = $('#idkurikulum').val();
      
                  if ($('#wajibs').is(":checked"))
                  {
                      var wajib = $('#wajibs').val();
                  }else{
                      var wajib = "n";
                  }
      
                  jQuery.ajax({
                      url:"{{ url('akademik/kurikulum/tambahsemester') }}?idmatakuliah=" + idmatakuliah +"&wajib=" + wajib + "&idkurikulum=" + idkurikulum + "&semester=" +semester,
                      type:"GET",
                      dataType:'json',
                      success:function(data){
                          // alert('data berhasil ditambah');
      
                          var oTables = $('#page-length-option').dataTable(); //inialisasi datatable
                                  oTables.fnDraw(false); //reset datatable
                                  iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                      title: 'Data Berhasil Ditambah',
                                      message: '{{ Session('
                                      success ')}}',
                                      position: 'bottomRight'
                                  });
      
                          table.ajax.reload();
                      }
                  });
      
      
                };
      
          </script>
      
      @endsection
