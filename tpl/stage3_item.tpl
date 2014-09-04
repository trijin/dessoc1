<div style="font-size:18px;margin-bottom:15px;">{{ question.question }}</div>

<div class="text-center">
	<div class="btn-group" data-toggle="buttons-radio">
	{% for answer in question.answers %}
		{% if question.answer is defined and question.answer == loop.index0 %}
		<button type="button" class="btn q_answer active" data-answerid="{{ loop.index0 }}" data-question="{{ question.id }}"><b class="icon-check"></b> {{ answer }}</button>
		{% else %}
		<button type="button" class="btn q_answer" data-answerid="{{ loop.index0 }}" data-question="{{ question.id }}"><b class="icon-unchecked"></b> {{ answer }}</button>
		{% endif %}
	{% endfor %}
	</div>
</div>
