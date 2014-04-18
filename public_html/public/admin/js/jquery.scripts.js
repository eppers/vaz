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
