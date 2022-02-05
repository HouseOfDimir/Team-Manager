$(function(){
    var Calendar    = FullCalendar.Calendar;
    var calendarEl  = document.getElementById('calendar');

    calendar = new Calendar(calendarEl, {
        headerToolbar: /* {end: 'today prev, next'} */false,
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        initialView: 'resourceTimeGridWeek',
        slotMinTime: '07:00:00',
        slotMaxTime:'18:00:00',
        slotDuration: '00:20:00',
        initialDate: config.data.start,
        datesAboveResources:true,
        eventDisplay:'block',
        allDaySlot: false,
        editable  : false,
        droppable : false,
        weekends: false,
        locale: 'fr',
        events: function(fetchInfo, successCallback, failureCallback){
            events = [];
            fetch(config.routes.getAllEvents + '?'+ new URLSearchParams({fkEmployee: config.data.fkEmployee ,end: config.data.end, start: config.data.start}), fetchGet())
                .then(response=>response.json())
                .then(data => {console.log(data)
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
                        });
                    });
                    successCallback(events);
                });
        },
        resources:function(fetchInfo, successCallback, failureCallback){
            resources= []
            fetch(config.routes.getEmployeeById, fetchGet())
                .then(response=>response.json())
                .then(data => {
                    resources.push({
                        id:data.id,
                        title:data.title
                    });
                    successCallback(resources);
                });
        },
    })
    calendar.render();

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

