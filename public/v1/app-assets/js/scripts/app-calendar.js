/* Calendar */
/*-------- */

$(document).ready(function () {
  /* initialize the calendar
   -----------------------------------------------------------------*/
  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendarInteraction.Draggable;
  var containerEl = document.getElementById('external-events');
  var containerElp = document.getElementById('external-events-pept');
  var calendarEl = document.getElementById('fc-external-drag');
  var checkbox = document.getElementById('drop-remove');

  //  Basic Calendar Initialize
//   var basicCal = document.getElementById('basic-calendar');
//   var fcCalendar = new FullCalendar.Calendar(basicCal, {
//     defaultDate: '2019-01-01',
//     editable: true,
//     plugins: ["dayGrid", "interaction"],
//     eventLimit: true, // allow "more" link when too many events
//     events: [
//       {
//         title: 'All Day Event',
//         start: '2019-01-01'
//       },
//       {
//         title: 'Long Event',
//         start: '2019-01-07',
//         end: '2019-01-10'
//       },
//       {
//         id: 999,
//         title: 'Repeating Event',
//         start: '2019-01-09T16:00:00'
//       },
//       {
//         id: 999,
//         title: 'Repeating Event',
//         start: '2019-01-16T16:00:00'
//       },
//       {
//         title: 'Conference',
//         start: '2019-01-11',
//         end: '2019-01-13'
//       },
//       {
//         title: 'Meeting',
//         start: '2019-01-12T10:30:00',
//         end: '2019-01-12T12:30:00'
//       },
//       {
//         title: 'Dinner',
//         start: '2019-01-12T20:00:00'
//       },
//       {
//         title: 'Birthday Party',
//         start: '2019-01-13T07:00:00'
//       },
//       {
//         title: 'Click for Google',
//         url: 'http://google.com/',
//         start: '2019-01-28'
//       }
//     ],
//   });
//   fcCalendar.render();

  // initialize the calendar
  // -----------------------------------------------------------------
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
        start: '2022-09-09T16:00:00',
        color: '#009688'
      },
      {
        title: 'Long Event',
        start: '2019-01-07',
        end: '2019-01-10',
        color: '#4CAF50'
      },
      {
        id: 999,
        title: 'Meeting',
        start: '2019-01-09T16:00:00',
        color: '#00bcd4'
      },
      {
        id: 999,
        title: 'Happy Hour',
        start: '2019-01-16T16:00:00',
        color: '#3f51b5'
      },
      {
        title: 'Conference Meeting',
        start: '2019-01-11',
        end: '2019-01-13',
        color: '#e51c23'
      },
      {
        title: 'Meeting',
        start: '2019-01-12T10:30:00',
        end: '2019-01-12T12:30:00',
        color: '#00bcd4'
      },
      {
        title: 'Dinner',
        start: '2019-01-12T20:00:00',
        color: '#4a148c'
      },
      {
        title: 'Birthday Party',
        start: '2019-01-13T07:00:00',
        color: '#ff5722'
      },
      {
        title: 'Click for Google',
        url: 'http://google.com/',
        start: '2019-01-28',
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
       var ruang = 1;
       var starttime = info.date.toTimeString()
       var tanggal = info.date
       var hari = dayName

        $.ajax({
            url:"/",
            data: {
                idkelas: idkelas,
                penggunaanruang: penggunaan,
                jamawal: starttime,
                ruangid:ruang,
                tanggalawalmasuk : tanggal,
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
    eventDrop:function(info,event){
      // console.log(info)
    },
    eventResize: function(info) {
        alert(info.event.end);
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
