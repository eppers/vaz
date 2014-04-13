{% extends 'layout.php' %}
{% block page_title %}edytuj stronę{% endblock %}
{% block content %} 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>{% if site.top_menu == 1 %}{{site.name}}{% else %} {% if form=='edit' %}Edytuj{% else %}Dodaj{% endif %} pozycję{% endif %}</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="/public/admin/img/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="./public/admin/img/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
        {% if error is defined %}
            {% include 'error.php' %}
        {% endif %}
		<!-- start id-form -->
   <form name="site-form" action="/admin/site/{% if form=='edit' %}edit/{{site.id_site}}{% else %}add{% endif %}" method="post" enctype="multipart/form-data">        
       
       
        <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                <tr>
                    <th valign="top">Nazwa:</th>
                    <td>{{site.title}}</td>
                    <td></td>
                </tr>
                <tr>
                    <th valign="top">Treść:</th>
                    <td>
                        <div class="control-group">
                                <div class="controls">
                                    <textarea class="cleditor" id="textarea2" name="content" rows="3">{{site.text}}</textarea>
                                </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <button type="submit" class="btn btn-primary" >Zapisz</button>
                            <a href="/admin/site/all" class="btn btn-danger">Wróć</a>
                    </td>
                    <td></td>
                </tr>
	</table>
	<!-- end id-form  -->

    </form>
	</td>
	<td>

</td>
</tr>
<tr>
<td><img src="/public/admin/img/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>
 
<div class="clear"></div>
 

</div>
<!--  end content-table-inner  -->
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
<!--  end content-outer -->
{% endblock %}