$(document).ready(function(){
    $('#upload-file').css('display','none');
    $('#dragThis').draggable(
        {
            containment: $('body'),
            drag: function(){
                var offset = $(this).position();
                var xPos = offset.left;
                var yPos = offset.top;
                $('#posX').text(xPos);
                $('#posY').text(yPos);
            },
            stop: function(){
                var finalOffset = $(this).position();
                var finalxPos = finalOffset.left;
                var finalyPos = finalOffset.top;

                $('input#posx').val(finalxPos);
                $('input#posy').val(finalyPos);
            },
            revert: 'invalid'
        });

    $('#dropHere').droppable(
        {
            accept: '#dragThis',
            over : function(){
                $(this).animate({'border-width' : '5px',
                    'border-color' : '#0f0'
                }, 500);
                $('#dragThis').draggable('option','containment',$(this));
            }
        });


    $('#upload-file-enable').click(function() {
        $('#upload-file').toggle();
        if ($('.file_1').attr('disabled')=='disabled') {
            $('.file_1').removeAttr('disabled');
        }
        else {
            $('.file_1').attr('disabled',true);
        }
    });
    
    $('.icon-2').click(function(){
        var bool = deleteItem();
        
        return bool;
    });

    $("#savename").click(function(){
                
        var city = $('input#city').val(),
            x = $("input#posx").val(),
            y = $('input#posy').val(),
            id = $("input#id").val(),
            action = $("input#action").val();

        $('#myModal').find('.alert').remove();
        addedit(action, id, x, y, city);
    });
        
    $("a[type=active]").click(function(){
           if($(this).attr('rel')!=="")
           activ($(this).attr('rel')); 
       return false;
    });

    $('.calendar_buttons select').change(function() {
        var cityId = $('#city').val(),
            monthId = $('#month').val();
        viewCalendar(monthId, cityId);
    })

    $('#month-container').on('click','li.active',function() {
        var data = $(this).attr('rel');
        var arr = data.split('-');

        var time1 = arr[0].split(':');
        var hours1 = parseInt(time1[0]);
        var minutes1 = parseInt(time1[1]);
        var scroll1 = hours1*60+minutes1;

        var time2 = arr[1].split(':');
        var hours2 = parseInt(time2[0]);
        var minutes2 = parseInt(time2[1]);
        var scroll2 = hours2*60+minutes2;

        $('#amount-time').val(data);
        $('#slider-time').slider("option", "values", [scroll1, scroll2]);

    })

    $('#slider-time').slider({
        range: true,
        min: 0,
        max: 1440,
        step: 15,
        values: [ 600, 1200 ],
        slide: function( event, ui ) {
            var hours1 = Math.floor(ui.values[0] / 60);
            var minutes1 = ui.values[0] - (hours1 * 60);

            if(hours1.length < 10) hours1= '0' + hours;
            if(minutes1.length < 10) minutes1 = '0' + minutes;

            if(minutes1 == 0) minutes1 = '00';

            var hours2 = Math.floor(ui.values[1] / 60);
            var minutes2 = ui.values[1] - (hours2 * 60);

            if(hours2.length < 10) hours2= '0' + hours;
            if(minutes2.length < 10) minutes2 = '0' + minutes;

            if(minutes2 == 0) minutes2 = '00';

            $('#amount-time').val(hours1+':'+minutes1+'-'+hours2+':'+minutes2 );
        }
    });

    $('#month-container').on('click','li', function(){
        if($(this).not('active')) {
            $('ul.calendar').find('li.active').not('.static').removeClass('active');
            var dayId = $(this).html();
            $('#day-id').val(dayId);
            $(this).addClass('active');
        }
    });

    $('.calendar_buttons').on('click','#add-hour', function(e) {
        e.preventDefault();
        var form = $('form').serialize();
        updateFreeHour(form);
    });
    
    $('.calendar_buttons').on('click','#delete-hour', function(e) {
        e.preventDefault();
        if(deleteItem()) {
          var form = $('form').serialize();
          console.log(form);
          deleteFreeHour(form);
        }
        
    });

    $('#add-file').click(function(e){
        e.preventDefault();
        var formData = new FormData($("#mainform")[0]);
        addFile(formData);
    });

});  //END OF DOCUMENT READY

function deleteItem() {
   if (confirm("Czy napewno chcesz usunąć ten obiekt?")) {
       return true;
   }
    return false;
   
}

function addedit(action, id, x, y, city) {
        var url = '/admin/city/'+action;
        $.ajax({
            type: "POST",
            url: url,
            data: {id : id, x : x, y : y, city : city},
            dataType: 'json',
            beforeSend: function(){
            $('#ajax-loader-small').show();
            },
            success: function(data) {
                $('#ajax-loader-small').hide();
                console.log(data);

                 var clss='',
                     newTr= '',
                     bgColor = 'alternate-row',
                     msg='';

                  if(data['error']==0) {
                      clss='alert-success';
                      if(action=='edit') {
                          console.log(x,y);
                          var tr = $('a[rel="'+id+'"]').parents('tr');
                          tr.children('td.name').html(city);
                          tr.find('input.city-posx').val(x);
                          tr.find('input.city-posy').val(y);

                      } else if(action=='add') {

                          if ($('#product-table').find('tr.category-row').last().hasClass('alternate-row')) bgColor = '';
                          newTr = '<tr class="category-row '+bgColor+'"><td><input  type="checkbox" id="uniform-undefined"/></td><td class="name">'+city+'</td><td class="options-width"><a href="" rel="'+data["id"]+'" onclick="return: false;" type="edit" title="Edytuj city" class="icon-1 info-tooltip btn-setting"></a><a href="" rel="'+data['id']+'" type="active" title="Aktywuj/deaktywuj city" class="icon-3 info-tooltip btn-setting"></a><a href="/admin/city/delete/'+data["id"]+'" title="Usuń city" class="icon-2 info-tooltip"></a><input type="hidden" value="'+x+'" class="city-posx"><input type="hidden" value="'+y+'" class="city-posy"></td></tr>';
                          $('#product-table').append(newTr);
                          
                      }
                          
                  } else if(data['error']==1) clss='alert-error';
                
                 msg='<div class="alert '+clss+' ">'+data['msg']+'</div>';
                  $('.control-group').prepend(msg);

                },
            error: function(xhr,textStatus,err)
                {
                    console.log("readyState: " + xhr.readyState);
                    console.log("responseText: "+ xhr.responseText);
                    console.log("status: " + xhr.status);

                }
        });
    };


function viewCalendar(monthId, cityId) {
    var url = '/ajax/calendar';
    $.ajax({
        type: "POST",
        url: url,
        data: {month: monthId, city: cityId},
        dataType: 'html',
        beforeSend: function(){
            $('#ajax-loader-small').show();
        },
        success: function(data) {
            $('#ajax-loader-small').hide();
            console.log(data);
            $('#month-container').html(data);

        },
        error: function(xhr,textStatus,err)
        {
            console.log("readyState: " + xhr.readyState);
            console.log("responseText: "+ xhr.responseText);
            console.log("status: " + xhr.status);
        }
    });
}

function updateFreeHour(form) {
    var url = '/admin/calendar/update';
    $.ajax({
        type: "POST",
        url: url,
        data: {form : form},
        dataType: 'json',
        beforeSend: function(){
            $('#ajax-loader-small').show();
        },
        success: function(data) {
            $('#ajax-loader-small').hide();
            console.log(data);
            if(data == 1) {
                var dayId = $('#day-id').val();
                var li = $("li[data-day-id='" + dayId +"']");
                if (li.hasClass('active')) {
                    li.not('.static').addClass('static');
                    var inputTime = $('#amount-time').val();
                    li.attr('rel',inputTime);
                    alert('Zmiany zostały zapisane');
                } else alert('Odśwież stronę');
            } else alert('Wystąpił problem z dodaniem danego dnia dla tego miasta. Spróbuj ponownie.');
        },
        error: function(xhr,textStatus,err)
        {
            console.log("readyState: " + xhr.readyState);
            console.log("responseText: "+ xhr.responseText);
            console.log("status: " + xhr.status);
        }
    });
}

function deleteFreeHour(form) {
    var url = '/admin/calendar/delete';
    $.ajax({
        type: "POST",
        url: url,
        data: {form : form},
        dataType: 'json',
        beforeSend: function(){
            $('#ajax-loader-small').show();
        },
        success: function(data) {
            $('#ajax-loader-small').hide();
            console.log(data);
            if(data == 1) {
                var dayId = $('#day-id').val();
                var li = $("li[data-day-id='" + dayId +"']");
                if (li.hasClass('active')) {
                    if(li.hasClass('static')) li.removeClass('static');
                    li.removeClass('active');
                } else alert('Odśwież stronę');
            } else alert('Wystąpił problem z usunięciem danego dnia dla tego miasta. Spróbuj ponownie.');
        },
        error: function(xhr,textStatus,err)
        {
            console.log("readyState: " + xhr.readyState);
            console.log("responseText: "+ xhr.responseText);
            console.log("status: " + xhr.status);
        }
    });
}

function activ(id) {
        $.ajax({
            type: "POST",
            url: '/admin/city/active',
            data: {id : id},
            dataType: 'json',
            beforeSend: function(){
            $('#ajax-loader-small').show();
            },
            success: function(data) {
         
                var tr = $('a[rel="'+id+'"]').closest('tr'),
                    active = '';        
                  
                $('#ajax-loader-small').hide();
                
                if(data['error']==0) { 
                      if(data['active']==1)active='tak'; else active='nie';
                      tr.find('td.active').html(active);
                          
                  } else if(data['error']==1) alert(data['msg']);

                },
            error: function(xhr,textStatus,err)
                {
                    console.log("readyState: " + xhr.readyState);
                    console.log("responseText: "+ xhr.responseText);
                    console.log("status: " + xhr.status);

                }
        });
}

function addFile(form) {
    console.log(form);
    $.ajax({
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        url: '/admin/doc/add',
        data: form,
        beforeSend: function(){
            $('#ajax-loader-small').show();
        },
        success: function(data) {
            console.log(data);
            var response = $.parseJSON(data);
            $('#ajax-loader-small').hide();

            if(response.error==0) {
                window.location.replace("/admin/dokumenty");
            } else if(response.error==1) alert(response.msg);

        },
        error: function(xhr,textStatus,err)
        {
            console.log("readyState: " + xhr.readyState);
            console.log("responseText: "+ xhr.responseText);
            console.log("status: " + xhr.status);

        }
    });
}
