{% if questions is defined and questions|length > 0 %}
	{% set qblock = '0' %}
	{% for question in questions %}
		{% if qblock != question.dessoc_questions_block_id %}
			{% if qblock > 0 %}
				</fieldset>
			{% endif %}
			{% if question.dessoc_questions_block_id > 0 %}
			<fieldset>
				<legend>{{ question.block_name}}</legend>
			{% endif %}
			{% set qblock = question.dessoc_questions_block_id %}
		{% endif %}
		<div class="div-question-{{ question.id }}">
		{% include "stage3_item.tpl" %}
		</div>
		<hr/>
		
	{% endfor %}

	{% if qblock > 0 %}
		</fieldset>
	{% endif %}
	
{% else %}
<header class="jumbotron">
	<h1>Нет ни одного вопроса</h1>
</header>
{% endif %}