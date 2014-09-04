{% if questions is defined and questions|length > 0 %}
	{% for question in questions %}
		<i>Вопрос от: <b>{{ question.nick }}</b> ({{ question.name }})</i> - {{ attribute(questions_status, question.aproved ) }}
		<div style="font-size:18px;margin-bottom:15px;">{{ question.question }}</div>
		
		<div style="padding-left:15px;font-size:15px;" class="row">
		{% for answer in question.answers %}
			<div class="span2">
				<b class="icon-check"></b> {{ answer }}
			</div>
		{% endfor %}
		</div>

		<div style="text-align:center;margin:10px;">
			{% if question.aproved in [0, -1] %}
			<button class="btn btn-small" onclick="$.post('',{'act':'aprove','qid':{{ question.id }} },function(data){$('.question_content').html(data);},'text');">Подтвердить</button>
			{% endif %}
			{% if question.aproved in [0, 1] %}
			<button class="btn btn-small" onclick="$.post('',{'act':'notaprove','qid':{{ question.id }} },function(data){$('.question_content').html(data);},'text');">Отклонить</button>
			{% endif %}
			{# <button class="btn btn-small" onclick="$.post('',{'act':'notaprove','qid':{{ question.id }} },function(data){$('.question_content').html(data);},'text');">Редактировать</button> #}


		</div>
		
		<hr/>
		
	{% endfor %}

	
{% else %}
<header class="jumbotron">
	<h1>Еще нет ни одного вопроса</h1>
</header>
{% endif %}