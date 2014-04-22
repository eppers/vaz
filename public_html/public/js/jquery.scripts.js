/**
 * Created by Peter on 18.04.14.
 */
$(document).ready(function(){
    $('li.city a.city-name').click( function(e) {
        e.preventDefault();

        var active_x = $('#map').find('li.active').data('x_pos'),
            active_y = $('#map').find('li.active').data('y_pos');
        $('#map').find('li.active').css({top:active_y, left:active_x});
        $('#map').find('li.active').removeClass('active');

        var li = $(this).parent('li'),
            position = li.position(),
            new_x = position.left-6,
            new_y = position.top-6;

        li.css({top:new_y, left:new_x});
        li.addClass('active');
        $('#city-name-title').html(li.attr('rel'));
        $('a#city-free').attr('href','/miasto/'+$(this).attr('rel'));
    });
    
    $('#calendar-container').on('click','li.active', function(){
        var time=$(this).attr('rel');
        $('.hours-info').html(time);
    });
    
    $('#placowki-cities .city-name').click(function(e){
        e.preventDefault();
        
        var cityId = $(this).attr('rel'),
            monthId = $('#month').val();
        $('#city').val(cityId);
                    
        viewCalendar(monthId, cityId);
    });
    
    $('select#month').change(function(){
        var cityId =  $('#city').val(),
            monthId = $(this).val();

        viewCalendar(monthId, cityId);
    });    

}) //END DOCUMENT READY

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
            $('#calendar-container').html(data);

        },
        error: function(xhr,textStatus,err)
        {
            console.log("readyState: " + xhr.readyState);
            console.log("responseText: "+ xhr.responseText);
            console.log("status: " + xhr.status);
        }
    });
}