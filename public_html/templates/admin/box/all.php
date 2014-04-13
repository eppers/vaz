{% extends 'layout.php' %}

{% block page_title %}Internet przewody{% endblock %}
{% block content %} 
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Lista boksów</h1>
	</div>
	<!-- end page-heading -->
        <a href="" id="add-box" class="btn btn-large btn-primary">Dodaj boks</a>
	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="/public/admin/img/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="/public/admin/img/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
                                

				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-check"><a id="toggle-all" ></a> </th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Tytuł</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Tekst</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Link aktywny</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Url</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Boks aktywny</a></th>

                                        <th class="table-header-options line-left"><a href="">Options</a></th>
				</tr>
                           {% for box in boxes %}
				<tr class="category-row{% if loop.index is divisibleby(2) %} alternate-row{% endif %}" >
					<td><input  type="checkbox"/></td>
					<td class="title">{{ box.title }}</td>
                                        <td class="text">{{ box.text[:50] }}...</td>
                                        <td class="link">{% if box.link==1 %}tak{% else %}nie{% endif %}</td>
                                        <td class="url">{{ box.url }}</td>
                                        <td class="active" rel="{{ box.active }}">{% if box.active==1 %}tak{% else %}nie{% endif %}</td>
					<td class="options-width">
					<a href="" rel="{{ box.id_box }}" type="edit" title="Edytuj box" class="icon-1 info-tooltip btn-setting"></a>
                                        <a href="" rel="{{ box.id_box }}" type="active" title="Aktywuj/deaktywuj box" class="icon-3 info-tooltip "></a>
                                        <a href="/admin/box/delete/{{ box.id_box }}" title="Usuń box" class="icon-2 info-tooltip"></a>
                                        <input type="hidden" value="{{ box.link }}" class="box-link">
                                        <input type="hidden" value="{{ box.text }}" class="box-text">
					</td>
				</tr>
                                
                        {% else %}  
                            <tr><td colspan="5"><p>Brak boksów</p></td><td>Brak opcji</td></tr>
                        {% endfor %}

				
				</table>
				<!--  end product-table................................... --> 
				</form>
			</div>
			<!--  end content-table  -->
		
	
			
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Ustawienia</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
                                        <label class="control-label" for="focusedInput" style="display: inline-block; margin-bottom: 0; color: #555555;">Tytuł boksa</label>
                                        <input class="input-xlarge focused" id="focusedInput" type="text" placeholder="Nazwa" style="margin-bottom: 0;"><br><br>
                                        <div style="">
                                            <div class="controls">
                                                <label class="control-label" for="textarea2" style="vertical-align: top; display: inline-block; margin-bottom: 0; color: #555555;">Zawartość boksa</label>
                                                <textarea class="/*cleditor*/ classic input-xlarge" id="textarea2" name="content" rows="6"></textarea>
                                            </div>
                                        </div>
                                        <label class="control-label" for="link-holder" style="display: inline-block; margin-bottom: 0; color: #555555;">Link do podstrony</label>
                                        <input id="link-holder" name="link" type="checkbox"><br><br>
                                        <label class="control-label" for="url" style="display: inline-block; margin-bottom: 0; color: #555555;">URL linku</label>
                                        <input class="input-xlarge focused" id="url" type="text" placeholder="Url" style="margin-bottom: 0;"><br>
                                        <input type="hidden" id="id" value="">
                                        <input id="link" name="link" type="hidden">
                                        <input type="hidden" id="action" value="">
                                  </div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Zamknij</a>
        <a id="savename" class="btn btn-primary">Zapisz zmiany</a>
        <div id="ajax-loader-container" style="width:16px; display:inline-block; height: 18px; vertical-align:middle;">
          <div id="ajax-loader-small" style="display:none;"><img src="/public/admin/img/ajax-loaders/ajax-loader-1.gif"></div>
        </div>
                               
			</div>
		</div>
{% endblock %}