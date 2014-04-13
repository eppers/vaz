{% set color = ['green','red','yellow','blue'] %}
{% if session.msg is not empty  %}
    {% set error = {'status':session.status, 'msg':session.msg} %}
{% endif %}
				<!--  start message-yellow -->
				<div id="message-{{color[error.status]}}">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="{{color[error.status]}}-left">{{error.msg}}.</td>
					<td class="{{color[error.status]}}-right"><a class="close-{{color[error.status]}}"><img src="/public/admin/img/table/icon_close_{{color[error.status]}}.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>
				<!--  end message-yellow -->                             

