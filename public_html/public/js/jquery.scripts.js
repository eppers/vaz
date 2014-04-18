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
})