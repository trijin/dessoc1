{% extends "main.tpl" %}
{% block aditioncss %}
<style>
dl dt {
	font-size: 18px;
	width: 40% !important;
}
dl dd {
	margin-left: 42% !important;
}
</style>
{% endblock %}
{% block contaner %}
<dl class="dl-horizontal">
	<dt>Зарегистрировано:</dt>
	<dd>{{ register_count|default(0) }}
		{% if stage == 1 %}
			<button class="btn btn-mini" onclick="$.post('',{'a':'nextStage'},'script');">Закончить 1 этап (регистрация)</button>
		{% endif %}
	</dd>
	<dt>Индивидуальных вопросов:</dt>
	<dd>{{ individual_questions|default(0) }}</dd>
	<dt>Ждут модерации:</dt>
	<dd>{{ need_moderate|default(0) }}</dd>
	<dt>Этап:</dt>
	<dd>{{ stage|default(0) }}
		{% if stage == 2 and need_moderate == 0 and register_count == hashes_count  %}
			<button class="btn btn-mini" onclick="$.post('',{'a':'nextStage'},'script');">Начать опрос (3 этап)</button>
		{% endif %}
	</dd>
	<dt>Уникальных паролей:</dt>
	<dd>{{ hashes_count|default(0) }}</dd>
	<dt>Из них активировано:</dt>
	<dd>{{ active_hashes_count|default(0) }}</dd>
	{% if stage > 1 and register_count != hashes_count %}
	<dt>Ждут ссылки:</dt>
	<dd>{{ register_count - hashes_count }}
		<button class="btn btn-mini" onclick="$.post('',{'a':'sendHashes'},'script');">разослать</button>
	</dd>
	{% endif %}
	{% if stage > 2 %}
	<dt>Закончили опрос:</dt>
	<dd>{{ ended_hashes_count }}
	{% if stage == 3 %}
		<button class="btn btn-mini" onclick="$.post('',{'a':'nextStage'},'script');">Закончить 3 этап</button>
	{% endif %}
	{% if stage == 4 %}
	<dt>Разослано результатов:</dt>
	<dd>{{ results_dended_count|default(0) }}
		{% if register_count > results_dended_count %}
		<button class="btn btn-mini" onclick="$.post('',{'a':'sendResults'},'script');">Разослать результаты</button>
		{% endif %}
	</dd>
	{% endif %}
	</dd>
	{% endif %}
</dl>
{# <button class="btn btn-mini" onclick="$.post('',{'a':'test'},'script');">test</button> #}
{% endblock %}