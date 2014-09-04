{% if questions is defined and questions|length > 0 %}
	{% set qblock = '0' %}
	{% for question in questions %}
		{% if qblock != question.dessoc_questions_block_id %}
			{% if qblock > 0 %}
				</fieldset>
			{% endif %}
			<fieldset>
				<legend>{{ question.block_name}}</legend>
			{% set qblock = question.dessoc_questions_block_id %}
		{% endif %}
		<button class="btn btn-small" style="float:right;" onclick="$.post('',{'act':'delQ','qid':{{ question.id }} },function(data){$('.question_content').html(data);},'text');">Удалить</button>
		<div style="font-size:18px;margin-bottom:15px;">{{ question.question }}</div>
		
		<div style="padding-left:15px;font-size:15px;" class="row">
		{% for answer in question.answers %}
			<div class="span2">
				<b class="icon-check"></b> {{ answer }}
			</div>
		{% endfor %}
		</div>
		
		<hr/>
		
	{% endfor %}

	{% if qblock > 0 %}
		</fieldset>
	{% endif %}
	
{% else %}
<header class="jumbotron">
	<h1>Еще нет ни одного вопроса</h1>
</header>
{% endif %}