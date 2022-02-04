$(function(){
    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
        ele.each(function () {

            // create an Event Object (https://fullcalendar.io/docs/event-object)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            }

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject)

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex        : 1070,
                revert        : true, // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            })
        })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    var Calendar    = FullCalendar.Calendar;
    var Draggable   = FullCalendar.Draggable;
    var containerEl = document.getElementById('external-events');
    var calendarEl  = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
        itemSelector: '.external-event',
        eventData: function(eventEl){
            return {
                title: eventEl.innerText,
                backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
            }
        }
    })

    calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left  : 'prev,next today',
            center: 'title',
            right : 'resourceTimeGridWeek,resourceTimeGridDay'
        },
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        initialView: 'resourceTimeGrid',
        refetchResourcesOnNavigate:true,
        slotMinTime: '07:00:00',
        slotMaxTime:'18:00:00',
        slotDuration: '00:15:00',
        weekends:false,
        datesAboveResources:true,
        eventDisplay:'block',
        allDaySlot: false,
        editable  : true,
        droppable : true, // this allows things to be dropped onto the calendar !!!
        locale: 'fr',
        events:function(fetchInfo, successCallback, failureCallback){
            events= []
            fetch(config.routes.getAllEvents + '?'+ new URLSearchParams({end: moment(fetchInfo.end).format('YYYYMMDD'), start: moment(fetchInfo.start).format('YYYYMMDD')}), fetchGet())
                .then(response=>response.json())
                .then(data => {
                    $.each(data, function(key, value){
                        events.push({
                            id:value.id,
                            resourceId:value.resourceId,
                            title:value.title,
                            color:value.color,
                            backgroundColor:value.backgroundColor,
                            start:value.start,
                            end:value.end,
                            parentId:value.resourceId
                        })
                    })
                    successCallback(events)
                })
        },
        resources:function(fetchInfo, successCallback, failureCallback){
            resources= []
            fetch(config.routes.getAllResources, fetchGet())
                .then(response=>response.json())
                .then(data => {
                    $.each(data, function(key, value){
                        resources.push({
                            id:value.id,
                            title:value.title
                        })
                    })
                    successCallback(resources)
                })
        },
        eventReceive:function(info){
            var end       = moment(info.event._instance.range.end).subtract(1, 'h')
            var eventData = {
                start     : moment(info.event.start).format("YYYY-MM-DD HH-mm"),
                end       : moment(end._d).format("YYYY-MM-DD HH-mm"),
                fkTask    : info.draggedEl.id.split('_')[1],
                fkEmployee: info.event._def.resourceIds[0],
                eventDate : moment(info.event.start).format("YYYYMMDD"),
                type      : config.modelFunc.add
            }
            fetch(config.routes.addEvent, fetchPost(eventData))
            .then(response=>response.json())
                    .then(data => {
                        $.atomNotify(data.feedback, data.style)
                    })
                    .catch(function(error){
                        $.atomNotify(error)
                    })

        },
        eventClick: function(event){
            eventData = {
                type   : config.modelFunc.delete,
                fkEvent: event.event.id
            }
            calendar.getEventById(event.event.id).remove()
            fetch(config.routes.addEvent, fetchPost(eventData))
                .then(response=>response.json())
                .then(data => {
                    $.atomNotify(data.feedback, data.style)
                })
                .catch(function(error){
                    $.atomNotify(error)
                })
        },
        eventChange: function(changeInfo){
            var eventData = {
                fkEvent   : changeInfo.oldEvent.id,
                fkEmployee: changeInfo.event._def.resourceIds[0],
                start     : moment(changeInfo.event.start).format("YYYY-MM-DD HH:mm"),
                end       : moment(changeInfo.event.end).format("YYYY-MM-DD HH:mm"),
                eventDate : moment(changeInfo.event.start).format("YYYYMMDD"),
                type      : config.modelFunc.update
            }
            fetch(config.routes.addEvent, fetchPost(eventData))
                .then(response=>response.json())
                .then(data => {
                    $.atomNotify(data.feedback, data.style)
                })
                .catch(function(error){
                    $.atomNotify(error)
                })
        }
    })
    calendar.render()
})

function fetchPost(datas){
    return {
        headers: {
            "X-CSRF-Token": $('input[name="_token"]').val(),
            "content-type": 'application/json'
        },
        method: "post",
        body: JSON.stringify(datas)
    }
}

function fetchGet(){
    return{
        method: 'GET',
        headers:{
            "Accept": "application/json"
        }
    }
}
