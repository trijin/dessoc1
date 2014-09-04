{% extends "main.tpl" %}
{% block aditioncss %}

{% endblock %}
{% block contaner %}
<center>
	<h2>Список зарегистрированых на DesСоцОпрос</h2>
	<table border="0" cellpadding="5" cellspacing="5" class="table table-striped table-hover">
		{% set counter = 0 %}
		{% for user in users %}
			{% set counter = counter + 1 %}
			<tr>
				<td>{{ counter }})</td>
				<td>{{ user.name }}</td>
				<td>{{ user.nick }}</td>
				<td>{% if user.photo_link|length > 0 %}<span class="photo_tooltip" data-placement="right" data-html="true" data-toggle="tooltip" title="&lt;img src=&quot;{{ user.photo_link }}&quot; width=&quot;200&quot;/&gt;">фото</span>{% else %}&nbsp;{% endif %}</td>
				{% if ds.stage == 4 %}
					{% if user.show_my_result == 1 %}
						<td><a href="/stage4/show/{{ user.id }}" target="_blank">анкета</a></td>
					{% else %}
						<td> </td>
					{% endif %}
				{% endif %}
			</tr>
		{% endfor %}
	</table>
</center>
{% endblock %}
{% block endJS %}
<script>
$('.photo_tooltip').tooltip();
</script>
{% endblock %}