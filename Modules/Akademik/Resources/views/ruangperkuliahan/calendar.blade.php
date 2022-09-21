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
    events: [
      {
        title: 'All Day Event',
        start: '2022-09-22T08:00:00',
        color: '#009688'
      },
      {
        title: 'Long Event',
        start: '2022-01-07',
        end: '2022-01-10',
        color: '#4CAF50'
      },
      {
        id: 999,
        title: 'Meeting',
        start: '2022-01-09T16:00:00',
        color: '#00bcd4'
      },
      {
        id: 999,
        title: 'Happy Hour',
        start: '2022-09-22T16:00:00',
        color: '#3f51b5'
      },
      {
        title: 'Conference Meeting',
        start: '2022-01-11',
        end: '2022-01-13',
        color: '#e51c23'
      },
      {
        title: 'Meeting',
        start: '2022-01-12T10:30:00',
        end: '2022-01-12T12:30:00',
        color: '#00bcd4'
      },
      {
        title: 'Dinner',
        start: '2022-01-12T20:00:00',
        color: '#4a148c'
      },
      {
        title: 'Birthday Party',
        start: '2022-01-13T07:00:00',
        color: '#ff5722'
      },
      {
        title: 'Click for Google',
        url: 'http://google.com/',
        start: '2022-01-28',
      }
    ],


    selectable:true,
    selectHelper:true,
    displayEventEnd:true,
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
                console.log(response)
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

        console.log(info)
        var d = info.event.start;
        var days = ["minggu", "senin", "selasa", "rabu", "kamis", "jum'at", "sabtu"],
        dayName = days[d.getDay()];
    //     var idkelas = info.draggedEl.attributes.idkelas.nodeValue;
    //    var penggunaan = 1;
    //    var ruang = 1;
    //    var starttime = info.date.toTimeString()
    //    var tanggal = info.date
    //    var hari = dayName


    },
    eventResize: function(info) {
        alert(info.event);
    }

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
