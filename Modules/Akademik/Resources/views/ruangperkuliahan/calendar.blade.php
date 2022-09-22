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

          </div>
        </div>
      </div>
    </div>
    <div class="col s12">
      <div class="container">
        <div class="section section-data-tables">
<div class="card">

</div>

<!-- Page Length Options -->
           <!-- Full Calendar -->

           <div id="app-calendar">
            <div class="row">

              <div class="col s12">
                <div class="card">
                  <div class="card-content">
                    <h4 class="card-title">
                     Management Ruangan
                    </h4>
                    <div class="row">
                      <div class="col m3 s12">
                        <div id='external-events'>
                          <h6>Daftar Kelas</h6>
                          <div class="fc-events-container mb-5" style="
                          height: 450px;
                          overflow: scroll;">
                             @foreach($getkelas as $dk)
                                <div class='fc-event' id="event" idkelas="{{ $dk->id }}" data-color='{{ $dk->color }}'>{{ $dk->nama_kelas }}{{ $dk->kode }}</div>
                            @endforeach
                          </div>
                        </div>

                          <p>
                            <label>
                              <input type="checkbox" id="drop-remove" />
                              <span>Remove After Drop</span>
                            </label>
                          </p>
                      </div>
                      <div class="col m9 s12">
                        <div id='fc-external-drag'></div>
                        {{-- <div id='calendar'></div> --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- START RIGHT SIDEBAR NAV -->



</div><!-- START RIGHT SIDEBAR NAV -->

</div>
      </div>
      <div class="content-overlay"></div>
    </div>
  </div>

  <style>
    .fc-event{
    cursor: pointer;
}
  </style>

  @stop
  @section('script')
  <script>

$.ajaxSetup({

headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});
$(document).ready(function () {
  /* initialize the calendar
   -----------------------------------------------------------------*/
  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendarInteraction.Draggable;
  var containerEl = document.getElementById('external-events');
  var containerElp = document.getElementById('external-events-pept');
  var calendarEl = document.getElementById('fc-external-drag');
  var checkbox = document.getElementById('drop-remove');
  let idruangan = {{ $idruangan }}
  var SITEURL = "{{ route('ruangperkuliahan.jadwalkelas',$idruangan) }}";



  var calendar = new Calendar(calendarEl, {
    header: {
      left: 'prev,next today',
      center: 'title',
      right: "dayGridMonth,timeGridWeek,timeGridDay"
    },

    editable: true,
    plugins: ["dayGrid", "timeGrid", "interaction"],
    droppable: true, // this allows things to be dropped onto the calendar
    defaultDate: Date.now(),
    slotDuration: '00:05:00',
    slotLabelInterval: 5,
    // slotLabelFormat: 'h(:mm)a',
    events: SITEURL,
    disableResizing: true,
    selectable:true,
    selectHelper:true,
    displayEventEnd:true,
    eventClick: function(info) {
        var idjadwal = info.event._def.publicId;
        $.ajax({
            url:"{{ url('akademik/ruangperkuliahan/getkelas') }}/"+idjadwal,

            type: "GET",
            success: function (response) {

                var date = new Date(response.tanggal_perkuliahan);
                var tahun = date.getFullYear();
                var bulan = date.getMonth();
                var tanggal = date.getDate();
                var hari = date.getDay();var jam = date.getHours();
                var menit = date.getMinutes();
                var detik = date.getSeconds();
                switch(hari) {
                    case 0: hari = "Minggu"; break;
                    case 1: hari = "Senin"; break;
                    case 2: hari = "Selasa"; break;
                    case 3: hari = "Rabu"; break;
                    case 4: hari = "Kamis"; break;
                    case 5: hari = "Jum'at"; break;
                    case 6: hari = "Sabtu"; break;
                }switch(bulan) {
                    case 0: bulan = "Januari"; break;
                    case 1: bulan = "Februari"; break;
                    case 2: bulan = "Maret"; break;
                    case 3: bulan = "April"; break;
                    case 4: bulan = "Mei"; break;
                    case 5: bulan = "Juni"; break;
                    case 6: bulan = "Juli"; break;
                    case 7: bulan = "Agustus"; break;
                    case 8: bulan = "September"; break;
                    case 9: bulan = "Oktober"; break;
                    case 10: bulan = "November"; break;
                    case 11: bulan = "Desember"; break;
                }
                var tampilTanggal =  hari + ", " + tanggal + " " + bulan + " " + tahun;
                var tampilWaktu = "Jam: " + jam + ":" + menit + ":" + detik;
                // displayMessage("Event Created Successfully");
                swal({

                      html: "<h5>"+info.event.title.toUpperCase()+"</h5> <br/>"+tampilTanggal+"<br/> waktu "+response.jam_masuk+" - "+response.jam_keluar+"<br/><br/><h6>Anda ingin menghapus data ini ? </h6><p>ini mungkin akan menghapus semua generate tanggal kelas ini</p>",

                      showCancelButton: true,
                      icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Hapus'

                  })
                  .then((dt) => {
                      if (dt) {
                          window.location.href = "{{ url('akademik/ruangperkuliahan') }}/" + response.id + "/deletekelas?ruangid="+response.ruang_id+"&ruangperkuliahanid="+response.ruangperkuliahan_id;
                      }
                  });
            }

        });

    },
    // dateClick: function(info) {
    //     // alert('Clicked on: ' + info.dateStr);

    // },
    drop: function (info, date) {

      var d = info.date;
      var days = ["minggu", "senin", "selasa", "rabu", "kamis", "jum'at", "sabtu"],
      dayName = days[d.getDay()];

       var idkelas = info.draggedEl.attributes.idkelas.nodeValue;
       var penggunaan = 1;
       var ruang = idruangan;
       var starttime = info.date.toTimeString()
       var tanggal = info.date
       var hari = dayName

        $.ajax({
            url:"{{ route('ruangperkuliahan.savecalendar') }}",
            data: {
                idkelas: idkelas,
                penggunaanruang: penggunaan,
                jamawal: starttime,
                ruang:ruang,
                tanggalawalmasuk : tanggal.toISOString(),
                hari:hari
            },
            type: "POST",
            success: function (response) {
                // console.log(response)
                location.reload();
                // displayMessage("Event Created Successfully");
            }
        });
      // is the "remove after drop" checkbox checked?

      if (checkbox.checked) {
        // if so, remove the element from the "Draggable Events" list
        info.draggedEl.parentNode.removeChild(info.draggedEl);
      }

    },
    eventDrop:function(info){
        var d = info.event.start;
        var days = ["minggu", "senin", "selasa", "rabu", "kamis", "jum'at", "sabtu"],
        dayName = days[d.getDay()];
        var idkelas = info.event._def.publicId;
        var penggunaan = 1;
        var ruang = idruangan;
        var starttime = info.event.start.toTimeString()
        var tanggal = info.event.end
        var hari = dayName

        $.ajax({
            url:"{{ route('ruangperkuliahan.updatecalendar') }}",
            data: {
                idkelas: idkelas,
                penggunaanruang: penggunaan,
                jamawal: starttime,
                ruang:ruang,
                tanggalawalmasuk : tanggal.toISOString(),
                hari:hari
            },
            type: "POST",
            success: function (response) {
                // console.log(response)
                location.reload();
                // displayMessage("Event Created Successfully");
            }
        });

    },
    eventDurationEditable:false
    // eventResize: function(info) {
    //     alert(info.event);
    // }

  });
  calendar.render();

  // initialize the external events
  // ----------------------------------------------------------------

  //   var colorData;
  $('#external-events .fc-event').each(function () {
    // Different colors for events
    $(this).css({ 'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color') });
  });
  var colorData;
  $('#external-events .fc-event').mousemove(function () {
    colorData = $(this).data('color');
  })
  // Draggable event init
  new Draggable(containerEl, {
    itemSelector: '.fc-event',
    eventData: function (eventEl) {

      return {
        title: eventEl.innerText,
        color: colorData
      };
    }
  });

//   pept
  //   var colorData;
  $('#external-events-pept .fc-event-pept').each(function () {
    // Different colors for events
    $(this).css({ 'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color') });
  });
  var colorData;
  $('#external-events-pept .fc-event-pept').mousemove(function () {
    colorData = $(this).data('color');
  })
  // Draggable event init
  new Draggable(containerElp, {
    itemSelector: '.fc-event-pept',
    eventData: function (eventEl) {
      return {
        title: eventEl.innerText,
        color: colorData
      };
    }
  });
})

    </script>

@endsection
