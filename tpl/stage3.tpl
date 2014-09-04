{% extends "main.tpl" %}
{% block aditioncss %}
<style>
	table,input {
		font-size:22px;
		line-height: 24px;
		vertical-align: top;
	}
	.q_answer {
		padding-left:15px;
		padding-right:15px;
		/*min-width: 150px;*/
	}
</style>
{% endblock %}
{% block contaner %}
<center>
	<table border="0" cellpadding="5" cellspacing="5" width="90%">
		<tr>
			<td align="left">{{ user.name }}</td>
			<td align="center" rowspan="3" width="35%">
				{% if user.photo_link|length > 0 %}
					<img border="0" src="{{ user.photo_link }}">
				{% else %}
					нет фото
				{% endif %}
			</td>

		</tr>
		<tr>
			<td align="left">{{ user.nick }}</td>
		</tr>
		<tr>
			<td align="center"><button class="btn" onclick="$('button[data-answerid=0]:not(.active)').click();">Недостаточно знаком</button></td>
		</tr>
		{# <tr>
			<td align="left" class="questionLayar" colspan="2"></td>
		</tr> #}
	</table>
	<hr style="margin-bottom:30px;"/>
	<div class="text-left question_content">
	{% include "stage3_questions.tpl" %}
	</div>

	<hr style="margin-bottom:30px;"/>
	<button class="btn btn-large" onclick="document.location.reload();">Следующий</button>
</center>
{% endblock %}
{% block endJS %}
<script>
function clickRegister() {
	$('.q_answer').click(function() {
		var t=$(this);
		var p=t.parent();
		var b=$('b',p);
		b.each(function(){
			if($(this).hasClass('icon-check')) {
				$(this).removeClass('icon-check');
				$(this).addClass('icon-unchecked');
			}
		});
		b=$('b',t);
		b.removeClass('icon-unchecked');
		b.addClass('icon-check');
		var d=t.data();
		d.user={{ user.id }};
		$.post('/stage3/answ',d,'script');

	});
}
clickRegister();
// $('.questionLayar').load('/stage1/pquestion');
</script>
{% endblock %}