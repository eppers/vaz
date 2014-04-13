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
    
    if($('#isCat').is(':checked')){
        $('tr#pick-cat').hide();
    };
    
    $('#isCat').change(function(){
        var c = this.checked ? 'hide' : 'show';
        switch(c) {
            case "show":
                //showing tr
                $('tr#pick-cat').show();
                break;
            case "hide":
                $('tr#pick-cat').hide();
                break;                    
        }
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
    
    
});  

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
            data: {x : x, y : y, city : city},
            dataType: 'json',
            beforeSend: function(){
            $('#ajax-loader-small').show();
            },
            success: function(data) {
                console.log(data);
         /*
                  var clss='',
                      newTr= '',
                      bgColor = 'alternate-row',
                      msg='',   
                      linkString = '',
                      shortContent = content.substr(0,50);    

                      if(link==1)linkString='tak'; else linkString='nie';
                
                  $('#ajax-loader-small').hide();
                
                  if(data['error']==0) { 
                      clss='alert-success';
                      if(action=='edit') {

                        var tr = $('a[rel="'+id+'"]').parents('tr');
                        
                        tr.children('td.title').html(title);
                        tr.children('td.text').html(shortContent);
                        tr.children('td.link').html(linkString);
                        tr.children('td.url').html(linkUrl);
                        tr.find("input.city-link").val(link);
                        tr.find("input.city-text").val(content);
                    
                      } else if(action=='add') {

                        if ($('#product-table').find('tr.category-row').last().hasClass('alternate-row')) bgColor = '';
                        newTr = '<tr class="'+bgColor+'"><td><input  type="checkbox"/></td><td class="title">'+title+'</td><td class="text">'+shortContent+'...</td><td class="link">'+linkString+'</td><td class="url">'+url+'</td><td class="active" rel="0">nie</td><td class="options-width"><a href="" rel="'+id+'" type="edit" title="Edytuj city" class="icon-1 info-tooltip btn-setting"></a><a href="" rel="'+id+'" type="active" title="Aktywuj/deaktywuj city" class="icon-3 info-tooltip btn-setting"></a><a href="/admin/city/delete/'+id+'" title="Usuń city" class="icon-2 info-tooltip"></a><input type="hidden" value="'+link+'" class="city-link"><input type="hidden" value="'+text+'" class="city-text"></td></tr>';
                        $('#product-table').append(newTr);
                          
                      }
                          
                  } else if(data['error']==1) clss='alert-error';
                
                 msg='<div class="alert '+clss+' ">'+data['msg']+'</div>';
                  $('.control-group').prepend(msg);
                */
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
