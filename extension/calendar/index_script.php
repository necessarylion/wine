<script>
   
   $(document).ready(function() {

	$('#index').addClass('active');
    var calendar = $('#calendar').fullCalendar({
     editable:true,
     height: 650,
     eventLimit: 3,
     header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
     events: 'run/cal/load.php',
     selectable:true,
     selectHelper:true,
     select: function(startDate, endDate, allDay)
     {
        bootbox.prompt({ 
            title: "Enter Event Title",
            placeholder: "Title",

            callback: function(result){ 
                if(result != null){
                  if(result == ''){
                    bootbox.alert({
                        size: "small",
                        title: "Error",
                        message: "Please Enter Title",
                        
                    })
                    return false;
                  }
                  else{
                      var start = startDate.format();
                      var end = endDate.format();
                      $.ajax({
                      url:"run/cal/crud.php",
                      type:"POST",
                      data:{title:result, start:start, end:end, insert:'0k'},
                            success:function()
                            {
                                calendar.fullCalendar('refetchEvents');
                            }
                      })
                  }
                }
                else{
                 //cancel
                }
            }
        });

     },
     editable:true,
     eventResize:function(event)
     {
      var start= moment(event.start).format('YYYY/MM/DD');
        var end= moment(event.end).format('YYYY/MM/DD');
        var title = event.title;
        var id = event.id;
        $.ajax({
        url:"run/cal/crud.php",
        type:"POST",
        data:{title:title, start:start, end:end, id:id, update:'ok'},
        success:function(){
          calendar.fullCalendar('refetchEvents');
        }
        })
     },
     eventDrop:function(event)
     {
        var start= moment(event.start).format('YYYY/MM/DD');
        var end= moment(event.end).format('YYYY/MM/DD');
        var title = event.title;
        var id = event.id;
        $.ajax({
        url:"run/cal/crud.php",
        type:"POST",
        data:{title:title, start:start, end:end, id:id, update:'ok'},
        success:function()
        {
          calendar.fullCalendar('refetchEvents');
        }
        });
     },
 
     eventClick:function(event)
     {
                 var start = moment(event.start).format('YYYY/MM/DD');
                 var end = moment(event.end).format('YYYY/MM/DD');
                 var id = event.id;
                 bootbox.dialog({
                  message: 'Edit Or Delete', 
                  onEscape: true,
                  buttons: {
                    cancel:{
                          label: "Cancel",
                          className: 'btn-secondary',
                          callback: function(){
                            
                          }
                      },
                      edit: {
                          label: 'Edit',
                          className: 'btn-success',
                          callback: function(){
                            bootbox.prompt({ 
                                title: "Enter Event Title",
                                placeholder: "Title",
                                value : event.title,
                                callback: function(result){ 
                                    if(result != null){
                                      if(result == ''){
                                        bootbox.alert({
                                            size: "small",
                                            title: "Error",
                                            message: "Please Enter Title",
                                            
                                        })
                                        return false;
                                      }
                                      else{
                                        $.ajax({
                                          url:"run/cal/crud.php",
                                          type:"POST",
                                          data:{title:result, start:start, end:end, id:id, update:'ok'},
                                          success:function()
                                          {
                                              calendar.fullCalendar('refetchEvents');
                                          }
                                          });
                                      }
                                       
                                    }
                                    else{
                                    //cancel
                                    }
                                }
                            });
                          }
                      },
                      delete: {
                          label: 'Delete',
                          className: 'btn-danger',
                          callback: function(){
                           
                                  var id = event.id;
                                  $.ajax({
                                      url:"run/cal/crud.php",
                                      type:"POST",
                                      data:{id:id, delete:'ok'},
                                      success:function()
                                      {
                                      calendar.fullCalendar('refetchEvents');
                                      }
                                  })
                                 
                             
                          }
                      }

                  }
                 }) 






     },

     droppable : true,
     drop: function(date){
        var originalEventObject = $(this).data('eventObject');
        var copiedEventObject = $.extend({}, originalEventObject);
        var title = copiedEventObject.title;
        copiedEventObject.backgroundColor = $(this).css('background-color');
        var color = copiedEventObject.backgroundColor;
            $.ajax({
                url:"run/cal/crud.php",
                type:"POST",
                data:{title:title, start:date.format(),color:color, insert:'0k'},
                success:function()
                {
                    calendar.fullCalendar('refetchEvents');
                }
                })
        if ($('#drop-remove').is(':checked')) { 
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
          var id = $(this).attr('tanboe');
          $.ajax({
                url:"run/cal/crud.php",
                type:"POST",
                data:{id:id, delete_event:'ok'},
                success:function()
                {
                ele.remove();
                }
            })
        }
     }
    });
   });
   
   </script>
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
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



    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('.save').css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : "white"
      })
    })
    //delete easy_events

  $(document).on('click','.del-easy', function(e){
  var id = $(this).parent().attr('tanboe');
  var ele = $(this);
    bootbox.confirm("Are You Sure", function(result){
       if(result == true){
        $.ajax({
            url:"run/cal/crud.php",
            type:"POST",
            data:{id:id, delete_event:'ok'},
              success:function()
              {
              ele.parent().remove();
              }
          })
       }
    })
  })



    $('.save').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#add-easy').val()
      if (val.length == 0) {
        return
      }      
      $.ajax({
                url:"run/cal/crud.php",
                type:"POST",
                data:{title:val, color:currColor , event:'ok'},
                success: function(data){
                    $('#add-easy').val('');
                    $('#external-events').html('');
                    get_easy();
                }
      })
      //Add draggable funtionality
      
      //Remove event from text input
      $('#add-easy').val('')
    })


    function get_easy(){
      jsonAjax({easy: 1}, "run/cal/easy.php", function(output){
        //console.log(output);
         $.each(output, function(k,v){
           $('#external-events').append('<div class="external-event btn btn-block text-left text-capitalize" tanboe="'+v.id+'" style="color:white;background-color:'+v.color+'">'+v.title+'<i class="fas fa-window-close pointer text-white pull-right del-easy"></i></div>')
         })
         ini_events($('#external-events div.external-event'))
      })
      
    }
    get_easy();
  })
</script>